<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function index(Request $request)
    {
        $wallets = Wallet::orderBy('is_main', 'desc')
            ->get();
        return view('wallet.index', compact('wallets'));
    }

    public function create()
    {
        return view('wallet.create');
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'balance' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'msg' => $validator->messages()], 400);
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

        return response()->json(['status' => 'success', 'msg' => 'Wallet Successfully Created.']);
    }

    public function detail(Request $request, $id)
    {
        $wallet = Wallet::where('id', $id)->firstOrFail();
        $transactions = Transaction::with(['category', 'designatedWallet', 'designatedWalletChild'])
            ->where('wallet_id', $wallet->id)
            ->whereBetween('date', [date('Y-m-01'), date('Y-m-d')])
            ->orderBy('date', 'desc')
            ->get();
        return view('wallet.detail', compact('wallet', 'transactions'));
    }

    public function edit(Request $request, $id)
    {
        $wallet = Wallet::where('id', $id)->firstOrFail();
        return view('wallet.edit', compact('wallet'));
    }

    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'balance' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'validator', 'msg' => $validator->messages()], 400);
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

        return response()->json(['status' => 'success', 'msg' => 'Wallet Successfully Updated.', 'href' => route('wallets.detail', $wallet->id)]);
    }

    public function destroy(Request $request, $id)
    {
        $wallet = Wallet::where('id', $id)->firstOrFail();
        $wallet->delete();
        return redirect()->route('wallets.index')->with('success', 'Wallet Successfully Deleted.');
    }
}
