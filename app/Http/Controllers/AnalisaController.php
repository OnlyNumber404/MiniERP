<?php

namespace App\Http\Controllers;

use App\Models\CryptoAsset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AnalisaController extends Controller
{
    const SUPPORTED_COINS = [
        'bitcoin' => ['symbol' => 'BTC', 'name' => 'Bitcoin', 'binance' => 'BINANCE:BTCUSDT'],
        'ethereum' => ['symbol' => 'ETH', 'name' => 'Ethereum', 'binance' => 'BINANCE:ETHUSDT'],
        'solana' => ['symbol' => 'SOL', 'name' => 'Solana', 'binance' => 'BINANCE:SOLUSDT'],
        'binancecoin' => ['symbol' => 'BNB', 'name' => 'BNB', 'binance' => 'BINANCE:BNBUSDT'],
        'ripple' => ['symbol' => 'XRP', 'name' => 'XRP', 'binance' => 'BINANCE:XRPUSDT'],
        'dogecoin' => ['symbol' => 'DOGE', 'name' => 'Dogecoin', 'binance' => 'BINANCE:DOGEUSDT'],
        'cardano' => ['symbol' => 'ADA', 'name' => 'Cardano', 'binance' => 'BINANCE:ADAUSDT'],
    ];

    public function index()
    {
        $userId = auth()->id() ?? 1;

        $assets = CryptoAsset::where('user_id', $userId)->get();

        if ($assets->isEmpty()) {
            CryptoAsset::create([
                'user_id' => $userId,
                'coin_id' => 'bitcoin',
                'coin_symbol' => 'BTC',
                'amount' => 0,
            ]);
            $assets = CryptoAsset::where('user_id', $userId)->get();
        }

        $coinIds = $assets->pluck('coin_id')->toArray();
        $coinIdsString = implode(',', $coinIds);

        $prices = \Illuminate\Support\Facades\Cache::remember('crypto_prices_' . md5($coinIdsString), 60, function () use ($coinIdsString) {
            $response = Http::get('https://api.coingecko.com/api/v3/simple/price', [
                'ids' => $coinIdsString,
                'vs_currencies' => 'usd',
            ]);

            return $response->json() ?? [];
        });

        $totalValue = 0;
        $watchlist = [];
        $assetData = [];

        foreach ($assets as $asset) {
            $price = $prices[$asset->coin_id]['usd'] ?? 0;
            $value = $asset->amount * $price;
            $totalValue += $value;

            $binanceSymbol = self::SUPPORTED_COINS[$asset->coin_id]['binance'] ?? 'BINANCE:BTCUSDT';
            $watchlist[] = $binanceSymbol;

            $assetData[] = [
                'id' => $asset->id,
                'coin_id' => $asset->coin_id,
                'symbol' => $asset->coin_symbol,
                'name' => self::SUPPORTED_COINS[$asset->coin_id]['name'] ?? $asset->coin_id,
                'amount' => $asset->amount,
                'price' => $price,
                'value' => $value,
            ];
        }

        $supportedCoins = self::SUPPORTED_COINS;

        return view('analisa', compact('assetData', 'totalValue', 'watchlist', 'supportedCoins', 'assets'));
    }

    public function addFavorite(Request $request)
    {
        $request->validate([
            'coin_id' => 'required|string',
        ]);

        $userId = auth()->id() ?? 1;
        $currentAssetsCount = CryptoAsset::where('user_id', $userId)->count();

        if ($currentAssetsCount >= 3) {
            return back()->withErrors(['coin_id' => 'Maksimal koin favorit adalah 3.']);
        }

        if (!array_key_exists($request->coin_id, self::SUPPORTED_COINS)) {
            return back()->withErrors(['coin_id' => 'Koin tidak didukung.']);
        }

        $exists = CryptoAsset::where('user_id', $userId)->where('coin_id', $request->coin_id)->exists();
        if ($exists) {
            return back()->withErrors(['coin_id' => 'Koin ini sudah ada di favorit Anda.']);
        }

        CryptoAsset::create([
            'user_id' => $userId,
            'coin_id' => $request->coin_id,
            'coin_symbol' => self::SUPPORTED_COINS[$request->coin_id]['symbol'],
            'amount' => 0,
        ]);

        return redirect()->route('analisa.index')->with('success', 'Koin berhasil ditambahkan ke favorit.');
    }

    public function removeFavorite($id)
    {
        $userId = auth()->id() ?? 1;

        $asset = CryptoAsset::where('user_id', $userId)->where('id', $id)->firstOrFail();
        $currentAssetsCount = CryptoAsset::where('user_id', $userId)->count();

        if ($currentAssetsCount <= 1) {
            return back()->withErrors(['amount' => 'Minimal harus ada 1 koin favorit.']);
        }

        $asset->delete();

        return redirect()->route('analisa.index')->with('success', 'Koin berhasil dihapus dari favorit.');
    }

    public function updateAmount(Request $request)
    {
        $amountInput = str_replace(',', '.', $request->amount);
        $request->merge(['amount' => $amountInput]);

        $request->validate([
            'coin_id' => 'required|string',
            'amount' => 'required|numeric|min:0',
        ]);

        $userId = auth()->id() ?? 1;

        CryptoAsset::updateOrCreate(
            ['user_id' => $userId, 'coin_id' => $request->coin_id],
            ['amount' => $request->amount]
        );

        return redirect()->route('analisa.index')->with('success', 'Jumlah ' . strtoupper($request->coin_id) . ' berhasil diperbarui.');
    }
}
