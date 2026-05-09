<?php

namespace App\Http\Controllers;

use App\Models\CryptoAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AnalisaController extends Controller
{
    public function index()
    {
        $userId = auth()->id() ?? 1; // Basic fallback if no auth, check auth

        $asset = CryptoAsset::firstOrCreate(
            ['user_id' => $userId, 'coin_id' => 'bitcoin'],
            ['coin_symbol' => 'BTC', 'amount' => 0]
        );

        $btcPrice = \Illuminate\Support\Facades\Cache::remember('btc_price_usd', 60, function () {
            $response = Http::get('https://api.coingecko.com/api/v3/simple/price', [
                'ids' => 'bitcoin',
                'vs_currencies' => 'usd',
            ]);

            return $response->json()['bitcoin']['usd'] ?? 0;
        });

        $totalValue = $asset->amount * $btcPrice;

        return view('analisa', compact('asset', 'btcPrice', 'totalValue'));
    }

    public function updateAmount(Request $request)
    {
        $amountInput = str_replace(',', '.', $request->amount);
        $request->merge(['amount' => $amountInput]);

        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $userId = auth()->id() ?? 1;

        CryptoAsset::updateOrCreate(
            ['user_id' => $userId, 'coin_id' => 'bitcoin'],
            ['amount' => $request->amount]
        );

        return redirect()->route('analisa.index')->with('success', 'Jumlah BTC berhasil diperbarui.');
    }
}
