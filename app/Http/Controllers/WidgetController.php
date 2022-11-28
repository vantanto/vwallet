<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;

class WidgetController extends Controller
{
    public static function cashFlow($wallet)
    {
        $cashFlows = [
            'inout' => ["in" => 0, "out" => 0],
            'status' => "",
        ];

        // Get CashFlow Total
        $cashFlows['inout']['in'] = Transaction::where(fn($query) => 
                $query->where(fn($query2) => $query2->whereHas('wallet')->where('type', 'in'))
                    ->orWhere(fn($query2) => $query2->wherehas('designatedWalletChild')->where('type', 'transfer'))
            );
        $cashFlows['inout']['out'] = Transaction::where(fn($query) => 
                $query->where(fn($query2) => $query2->whereHas('wallet')->where('type', 'out'))
                    ->orWhere(fn($query2) => $query2->wherehas('designatedWallet')->where('type', 'transfer'))
            );
        
        foreach ($cashFlows['inout'] as $key => $cashFlow) {
            $cashFlows['inout'][$key] = $cashFlow->whereBetween('date', [date('Y-m-01'), date('Y-m-d')])
                ->sum('nominal');
        }

        if ($cashFlows['inout']['in'] > $cashFlows['inout']['out']) $cashFlows['status'] = "+";
        else if ($cashFlows['inout']['in'] < $cashFlows['inout']['out']) $cashFlows['status'] = "-";

        return $cashFlows;
    }

    public static function transactions($wallet)
    {
        $transactions = Transaction::with(['category.category', 'designatedWallet', 'designatedWalletChild'])
            ->where('wallet_id', $wallet->id)
            ->whereBetween('date', [date('Y-m-01'), date('Y-m-d')])
            ->orderBy('date', 'desc')
            ->limit(7)
            ->get();

        return $transactions;
    }

    public static function expenseCategory($wallet)
    {
        $categories = Category::select('categories.*')
            ->selectRaw('SUM(tr.nominal) as tr_nominal')
            ->join('transactions as tr', 'tr.category_id', 'categories.id')
            ->join('wallets as w', 'w.id', 'tr.wallet_id')
            ->where(fn($query) => $query->userId()->orWhereNull('categories.user_id'))
            ->where(fn($query) => 
                $query->where(fn($query2) => $query2->where('tr.wallet_id', $wallet->id)->where('tr.type', 'out'))
                    ->orWhere(fn($query2) => $query2->where('tr.designated_wallet_id', $wallet->id)->where('tr.type', 'transfer'))
            )
            ->whereBetween('tr.date', [date('Y-m-01'), date('Y-m-d')])
            ->whereNull(['tr.deleted_at', 'w.deleted_at'])
            ->groupBy('categories.id')
            ->get();
        $mainCategories = $categories->groupBy(fn($item) => $item->category_id ?? $item->id );

        return $mainCategories;
    }

    public static function expenseCategoryDonut($wallet)
    {
        $mainCategories = self::expenseCategory($wallet);

        $dataCategories= [
            "sum" => $mainCategories->map(fn($item) => $item->sum('tr_nominal'))->values()->toArray(),
            "name" => $mainCategories->map(fn($item) => $item[0]->name ?? "")->values()->toArray(),
        ];

        return $dataCategories;
    }
}
