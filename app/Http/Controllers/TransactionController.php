<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function create(Request $request, $wallet)
    {
        $wallet = $request->wallet;
        $categories = CategoryController::getCategories();
        return view('transaction.create', compact('wallet', 'categories'));
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
            $addition = $transaction->type == "in" ? $transaction->nominal : -$transaction->nominal;
            $wallet->balance += $addition;
            $wallet->save();

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
        $transaction = Transaction::where('wallet_id', $wallet->id)
            ->where('id', $id)->firstOrFail();
        return view('transaction.edit', compact('wallet', 'categories', 'transaction'));
    }

    public function update(Request $request, $wallet, $id)
    {
        $wallet = $request->wallet;
        $validator = \Validator::make($request->all(), [
            'type' => 'required|in:'.implode(',', Transaction::$Type),
            'date' => 'required|date',
            'category' => 'required|exists:categories,id',
            'nominal' => 'required|numeric',
            'desciprtion' => 'sometimes',
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
            if ($transaction->type == $transactionOld->type) {
                $addition = $transaction->nominal - $transactionOld->nominal;
            } else {
                $addition = $transaction->nominal + $transactionOld->nominal;
                $addition = $transaction->type == "in" ? $addition : -$addition;
            }
            $wallet->balance += $addition;
            $wallet->save();

            DB::commit();
            return response()->json(['status' => 'success', 'msg' => 'Transaction Successfully Updated.']);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'msg' => 'Transaction Failed Updated.']);
        }
    }

    public function destroy(Request $request, $wallet, $id)
    {
        $wallet = $request->wallet;
        $transaction = Transaction::where('wallet_id', $wallet->id)
            ->where('id', $id)->firstOrFail();
        
        // Update Wallet Balance
        $addition = $transaction->type = "out" ? $transaction->nominal : -$transaction->nominal;
        $wallet->balance += $addition;
        $wallet->save();

        $transaction->delete();
        return redirect()->route('categories.index')->with('success', 'Transaction Successfully Deleted.');
    }
}
