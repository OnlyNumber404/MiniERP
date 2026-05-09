<x-main>
  <x-slot:title>Analisa</x-slot:title>
  <x-slot:head>Analisa</x-slot:head>
  @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
      <span class="block sm:inline">{{ session('success') }}</span>
    </div>
  @endif

  <!-- Top Cards -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Card Harga BTC -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-xs flex flex-col justify-center">
      <h3 class="text-gray-600 text-sm font-bold mb-2 uppercase tracking-wide">Harga BTC (USD)</h3>
      <p class="text-3xl font-bold text-blue-600">${{ number_format($btcPrice ?? 0, 2) }}</p>
    </div>

    <!-- Card Update Jumlah BTC -->
    <div class="bg-white text-black rounded-xl border border-gray-200 p-6 shadow-xs flex flex-col justify-center">
      <h3 class="text-gray-600 text-sm font-bold mb-2 uppercase tracking-wide">Jumlah BTC Anda</h3>
      <form action="{{ route('analisa.update') }}" method="POST" class="flex gap-2 mt-1">
        @csrf
        <input type="text" inputmode="decimal" name="amount" value="{{ old('amount', floatval($asset->amount ?? 0)) }}"
          class="border border-gray-300 rounded px-3 py-2 w-full text-xl flex-1" required placeholder="0.00">
        <button type="submit"
          class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 font-semibold transition">Simpan</button>
      </form>
      @error('amount')
        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
      @enderror
    </div>

    <!-- Card Nilai Asset -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-xs flex flex-col justify-center">
      <h3 class="text-green-500 text-sm font-bold mb-2 uppercase tracking-wide">Total Nilai (USD)</h3>
      <p class="text-3xl font-bold text-green-500">${{ number_format($totalValue ?? 0, 2) }}</p>
    </div>
  </div>

  <!--Analisa Chart-->
  <!-- TradingView Widget BEGIN -->
  <div class="tradingview-widget-container" style="height:100%;width:100%">
    <div class="tradingview-widget-container__widget" style="height:calc(100% - 32px);width:100%"></div>
    <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/symbols/BTCUSDT/?exchange=BINANCE"
        rel="noopener nofollow" target="_blank"><span class="blue-text">BTCUSDT price</span></a><span class="trademark">
        by TradingView</span></div>
    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js"
      async>
        {
        "allow_symbol_change": true,
        "calendar": false,
        "details": false,
        "hide_side_toolbar": true,
        "hide_top_toolbar": false,
        "hide_legend": false,
        "hide_volume": false,
        "hotlist": false,
        "interval": "D",
        "locale": "en",
        "save_image": true,
        "style": "1",
        "symbol": "BINANCE:BTCUSDT",
        "theme": "light",
        "timezone": "Etc/UTC",
        "backgroundColor": "#ffffff",
        "gridColor": "rgba(46, 46, 46, 0.06)",
        "watchlist": [
            "BINANCE:BTCUSDT"
        ],
        "withdateranges": false,
        "compareSymbols": [],
        "studies": [],
        "autosize": true
        }
      </script>
  </div>
  <!-- TradingView Widget END -->
</x-main>