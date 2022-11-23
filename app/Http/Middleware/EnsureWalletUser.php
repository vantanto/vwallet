<?php

namespace App\Http\Middleware;

use App\Models\Wallet;
use Closure;
use Illuminate\Http\Request;

class EnsureWalletUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->route('wallet')) {
            $wallet = Wallet::where('id', $request->route('wallet'))->first();
            if (! $wallet) {
                return redirect()->route('dashboard')->with('error', 'Wallet Not Found.');
            } else {
                $request->merge(['wallet' => $wallet]);
            }
        }
        return $next($request);
    }
}
