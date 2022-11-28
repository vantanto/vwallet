<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $wallet = Wallet::where('is_main', true)->first();
        $widgets = [];
        
        if ($wallet) {
            $widgets['cash_flow'] = WidgetController::cashFlow($wallet);
            $widgets['transactions'] = WidgetController::transactions($wallet);
            $widgets['expense-category-donut'] = WidgetController::expenseCategoryDonut($wallet);
        }
        
        return view('dashboard', compact('wallet', 'widgets'));
    }
}
