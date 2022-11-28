<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    public function create(Request $request, $wallet)
    {
        $wallet = $request->wallet;
        $categories = CategoryController::getCategories();
        $designatedWallets = Wallet::where('id', '!=', $wallet->id)->get();
        return view('transaction.create', compact('wallet', 'categories', 'designatedWallets'));
    }

    public function store(Request $request, $wallet)
    {
        $wallet = $request->wallet;
        $validator = \Validator::make($request->all(), [
            'type' => 'required|in:'.implode(',', Transaction::$Type),
            'date' => 'required|date',
            'category' => 'required|exists:categories,id',
            'nominal' => 'required|numeric',
            'desciprtion' => 'sometimes',
            'designated_wallet' => [
                'nullable',
                'required_if:type,transfer',
                'not_in:'.$wallet->id,
                Rule::exists('wallets', 'id')
                    ->where('user_id', Auth::user()->id)
            ]
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'msg' => $validator->messages()], 400);
        }

        DB::beginTransaction();
        try {
            $transaction = new Transaction();
            $transaction->wallet_id = $wallet->id;
            $transaction->date = $request->date;
            $transaction->category_id = $request->category;
            $transaction->type = $request->type;
            $transaction->nominal = $request->nominal;
            $transaction->description = $request->description;
            $transaction->save();

            // Update Wallet Balance
            $addition = $transaction->type_in_out == "in" ? $transaction->nominal : -$transaction->nominal;
            $wallet->balance += $addition;
            $wallet->save();

            // Update Designated Wallet Balance
            if ($transaction->type == "transfer") {
                $designatedWallet = Wallet::where('id', $request->designated_wallet)->first();

                $desTransaction = new Transaction();
                $desTransaction->wallet_id = $designatedWallet->id;
                $desTransaction->date = $transaction->date;
                $desTransaction->category_id = $transaction->category_id;
                $desTransaction->type = $transaction->type;
                $desTransaction->nominal = $transaction->nominal;
                $desTransaction->description = $transaction->description;
                $desTransaction->designated_wallet_id = $wallet->id;
                $desTransaction->designated_transaction_id = $transaction->id;
                $desTransaction->save();

                $addition = $desTransaction->nominal;
                $designatedWallet->balance += $addition;
                $designatedWallet->save();
            }

            DB::commit();
            return response()->json(['status' => 'success', 'msg' => 'Transaction Successfully Created.']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'msg' => 'Transaction Failed Created.']);
        }
    }

    public function edit(Request $request, $wallet, $id)
    {
        $wallet = $request->wallet;
        $categories = CategoryController::getCategories();
        $designatedWallets = Wallet::where('id', '!=', $wallet->id)->get();
        $transaction = Transaction::where('wallet_id', $wallet->id)
            ->where('id', $id)
            ->whereNull(['designated_wallet_id', 'designated_transaction_id'])
            ->firstOrFail();
        return view('transaction.edit', compact('wallet', 'categories', 'designatedWallets', 'transaction'));
    }

    public function update(Request $request, $wallet, $id)
    {
        $wallet = $request->wallet;
        $request->merge(['id' => $id]);
        $validator = \Validator::make($request->all(), [
            'id' => Rule::exists('transactions', 'id')
                ->whereNull('designated_wallet_id')
                ->whereNull('designated_transaction_id'),
            'type' => 'required|in:'.implode(',', Transaction::$Type),
            'date' => 'required|date',
            'category' => 'required|exists:categories,id',
            'nominal' => 'required|numeric',
            'desciprtion' => 'sometimes',
            'designated_wallet' => [
                'nullable',
                'required_if:type,transfer',
                'not_in:'.$wallet->id,
                Rule::exists('wallets', 'id')
                    ->where('user_id', Auth::user()->id)
            ]
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'msg' => $validator->messages()], 400);
        }

        DB::beginTransaction();
        try {
            $transaction = Transaction::where('id', $id)->firstOrFail();
            $transactionOld = clone $transaction;
            $transaction->date = $request->date;
            $transaction->category_id = $request->category;
            $transaction->type = $request->type;
            $transaction->nominal = $request->nominal;
            $transaction->description = $request->description;
            $transaction->save();

            // Update Wallet Balance
            $addition = 0;
            if ($transaction->type_in_out == $transactionOld->type_in_out) {
                $addition = $transaction->nominal - $transactionOld->nominal;
            } else {
                $addition = $transaction->nominal + $transactionOld->nominal;
            }
            $addition = $transaction->type_in_out == "in" ? $addition : -$addition;
            $wallet->balance += $addition;
            $wallet->save();

            // Update Designated Wallet Balance
            if ($transaction->type == "transfer") {
                $designatedWallet = Wallet::where('id', $request->designated_wallet)->first();

                $desTransaction = $transaction->type == $transactionOld->type
                    ? $transaction->designated_wallet_id ? $transaction->designatedTransaction : $transaction->designatedTransactionChild
                    : new Transaction();
                $desTransactionOld = clone $desTransaction;
                $desTransaction->wallet_id = $designatedWallet->id;
                $desTransaction->date = $transaction->date;
                $desTransaction->category_id = $transaction->category_id;
                $desTransaction->type = $transaction->type;
                $desTransaction->nominal = $transaction->nominal;
                $desTransaction->description = $transaction->description;
                $desTransaction->designated_wallet_id = $wallet->id;
                $desTransaction->designated_transaction_id = $transaction->id;
                $desTransaction->save();

                $addition = 0;
                if ($desTransactionOld) {
                    if ($desTransaction->type == $desTransactionOld->type) {
                        $addition = $desTransaction->nominal - $desTransactionOld->nominal;
                    } else {
                        $addition = $desTransaction->nominal + $desTransactionOld->nominal;
                        $addition = $transaction->type_in_out ? $addition : -$addition;
                    }
                } else {
                    $addition = $desTransaction->nominal;
                }
                $designatedWallet->balance += $addition;
                $designatedWallet->save();
            } else if ($transactionOld->type == "transfer") {
                // Delete Designated Transaction
                $designatedWallet = $transaction->designatedWalletChild;
                $desTransaction = $transaction->designatedTransactionChild;

                // Update Wallet Balance
                $addition = -$desTransaction->nominal;
                $designatedWallet->balance += $addition;
                $designatedWallet->save();
                
                $desTransaction->delete();
            }

            DB::commit();
            return response()->json(['status' => 'success', 'msg' => 'Transaction Successfully Updated.', 'href' => route('transactions.edit', [$wallet->id, $transaction->id])]);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'msg' => 'Transaction Failed Updated.'], 400);
        }
    }

    public function destroy(Request $request, $wallet, $id)
    {
        $wallet = $request->wallet;
        $transaction = Transaction::where('wallet_id', $wallet->id)
            ->where('id', $id)
            ->whereNull(['designated_wallet_id', 'designated_transaction_id'])
            ->firstOrFail();
        
        // Update Wallet Balance
        $addition = $transaction->type != "in" ? $transaction->nominal : -$transaction->nominal;
        $wallet->balance += $addition;
        $wallet->save();

        if ($transaction->type == "transfer") {
            // Delete Designated Transaction
            $designatedWallet = $transaction->designatedWalletChild;
            $desTransaction = $transaction->designatedTransactionChild;

            // Update Wallet Balance
            $addition = -$desTransaction->nominal;
            $designatedWallet->balance += $addition;
            $designatedWallet->save();
            
            $desTransaction->delete();
        }

        $transaction->delete();
        return redirect()->route('wallets.detail', $wallet->id)->with('success', 'Transaction Successfully Deleted.');
    }
}
