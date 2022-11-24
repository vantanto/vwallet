<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $wallet = Wallet::where('is_main', true)->first();
        $transactions = [];
        $cashFlows['inout'] = ["in" => 0, "out" => 0];
        
        if ($wallet) {
            $transactions = Transaction::with(['category', 'designatedWallet', 'designatedWalletChild'])
                ->where('wallet_id', $wallet->id)
                ->whereBetween('date', [date('Y-m-01'), date('Y-m-d')])
                ->orderBy('date', 'desc')
                ->limit(15)
                ->get();

            $cashFlows['inout'] = [
                'in' => Transaction::where(fn($query) => 
                        $query->where(fn($query2) => $query2->whereHas('wallet')->where('type', 'in'))
                            ->orWhere(fn($query2) => $query2->wherehas('designatedWalletChild')->where('type', 'transfer'))
                    )
                    ->whereBetween('date', [date('Y-m-01'), date('Y-m-d')])
                    ->sum('nominal'),
                'out' => Transaction::where(fn($query) => 
                        $query->where(fn($query2) => $query2->whereHas('wallet')->where('type', 'out'))
                            ->orWhere(fn($query2) => $query2->wherehas('designatedWallet')->where('type', 'transfer'))
                    )
                    ->whereBetween('date', [date('Y-m-01'), date('Y-m-d')])
                    ->sum('nominal'),
            ];
        }
        $cashFlows['status'] = "";
        if ($cashFlows['inout']['in'] > $cashFlows['inout']['out']) $cashFlows['status'] = "+";
        else if ($cashFlows['inout']['in'] < $cashFlows['inout']['out']) $cashFlows['status'] = "-";
        
        return view('dashboard', compact('wallet', 'transactions', 'cashFlows'));
    }
}
