<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        $wallets = Wallet::orderBy('is_main', 'desc')
            ->get();

        return $this->responseSuccess('Wallet Index', [
            'wallets' => $wallets,
        ]);
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'balance' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->responseValidator($validator);
        }

        $user= Auth::user();
        $wallet = new Wallet();
        $wallet->name = $request->name;
        $wallet->initial_balance = $request->balance;
        $wallet->balance = $request->balance;
        $wallet->is_main = $user->wallets->count() > 0 
            ? ($request->is_main ? true : false)
            : true;
        $wallet->user_id = $user->id;
        $wallet->save();

        if ($wallet->is_main) {
            Wallet::where('id', '!=', $wallet->id)
                ->where('is_main', true)
                ->update(['is_main' => false]);
        }

        return $this->responseSuccess('Wallet Successfully Created.', [
            'wallet' => $wallet,
        ]);
    }

    public function detail(Request $request, $id)
    {
        $wallet = Wallet::where('id', $id)->firstOrFail();
        $transactions = Transaction::with(['category.category', 'designatedWallet', 'designatedWalletChild'])
            ->where('wallet_id', $wallet->id)
            ->whereBetween('date', [date('Y-m-01'), date('Y-m-d')])
            ->orderBy('date', 'desc')
            ->get();

        return $this->responseSuccess('Wallet Detail', [
            'wallet' => $wallet,
            'transactions' => $transactions,
        ]);
    }

    public function edit(Request $request, $id)
    {
        $wallet = Wallet::where('id', $id)->firstOrFail();

        return $this->responseSuccess('Wallet Edit', [
            'wallet' => $wallet
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'balance' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->responseValidator($validator);
        }

        $wallet = Wallet::where('id', $id)->firstOrFail();
        $wallet->name = $request->name;
        $wallet->is_main = $request->is_main ? true : false;
        $wallet->save();

        if ($wallet->is_main) {
            Wallet::where('id', '!=', $wallet->id)
                ->where('is_main', true)
                ->update(['is_main' => false]);
        }

        return $this->responseSuccess('Wallet Successfully Updated.', [
            'wallet' => $wallet,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $wallet = Wallet::where('id', $id)->firstOrFail();
        $wallet->delete();

        return $this->responseSuccess('Wallet Successfully Deleted.');
    }
}
