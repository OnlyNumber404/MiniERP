<x-main>
  <x-slot:title>Analisa</x-slot:title>
  <x-slot:head>Analisa</x-slot:head>
  @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
      <span class="block sm:inline">{{ session('success') }}</span>
    </div>
  @endif

  @if($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
      <ul class="list-disc pl-5 mt-1">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- Top Actions & Stats -->
  <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    <!-- Total Value -->
    <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-xs flex-1 w-full md:w-auto">
      <h3 class="text-green-500 text-sm font-bold mb-1 uppercase tracking-wide">Total Nilai Semua Asset (USD)</h3>
      <p class="text-3xl font-bold text-green-500">${{ number_format($totalValue ?? 0, 2) }}</p>
    </div>

    <!-- Add Favorite Form -->
    @if(count($assetData) < 3)
      <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-xs w-full md:w-1/3">
        <h3 class="text-gray-600 text-sm font-bold mb-2 uppercase tracking-wide">Tambah Aset Kripto</h3>
        <form action="{{ route('analisa.favorite.add') }}" method="POST" class="flex gap-2">
          @csrf
          <select name="coin_id" class="border border-gray-300 rounded px-3 py-2 w-full flex-1 text-black" required>
            <option value="" class="text-black">Pilih Koin...</option>
            @foreach($supportedCoins as $id => $coin)
              <option value="{{ $id }}" class="text-black">{{ $coin['name'] }} ({{ $coin['symbol'] }})</option>
            @endforeach
          </select>
          <button type="submit"
            class="bg-blue-600 hover:cursor-pointer text-white px-4 py-2 rounded hover:bg-blue-700 font-semibold transition">Tambah</button>
        </form>
      </div>
    @endif
  </div>

  <!-- Asset Cards -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    @foreach($assetData as $asset)
      <div
        class="bg-white text-black rounded-xl border border-gray-200 p-6 shadow-xs flex flex-col justify-between relative">
        <div>
          <div class="flex justify-between items-start mb-2">
            <h3 class="text-gray-600 text-sm font-bold uppercase tracking-wide">{{ $asset['name'] }}
              ({{ $asset['symbol'] }})</h3>

            @if(count($assetData) > 1)
              <form action="{{ route('analisa.favorite.remove', $asset['id']) }}" method="POST"
                onsubmit="return confirm('Hapus koin ini dari favorit?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700 text-sm hover:cursor-pointer" title="Hapus Favorit">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                      d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                      clip-rule="evenodd" />
                  </svg>
                </button>
              </form>
            @endif
          </div>
          <p class="text-xl font-bold text-blue-600 mb-4">Harga: ${{ number_format($asset['price'], 2) }}</p>
        </div>

        <form action="{{ route('analisa.update') }}" method="POST" class="flex flex-col gap-2 mt-1">
          @csrf
          <input type="hidden" name="coin_id" value="{{ $asset['coin_id'] }}">
          <label class="text-xs text-gray-500">Jumlah Dimiliki</label>
          <div class="flex gap-2">
            <input type="text" inputmode="decimal" name="amount" value="{{ floatval($asset['amount']) }}"
              class="border border-gray-300 rounded px-3 py-2 w-full text-lg flex-1" required placeholder="0.00">
            <button type="submit"
              class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 font-semibold transition hover:cursor-pointer">Simpan</button>
          </div>
        </form>

        <div class="mt-4 pt-4 border-t border-gray-100">
          <p class="text-sm text-gray-500">Nilai Aset: <span
              class="font-bold text-green-500">${{ number_format($asset['value'], 2) }}</span></p>
        </div>
      </div>
    @endforeach
  </div>

  <!--Analisa Chart-->
  <!-- TradingView Widget BEGIN -->
  <div class="tradingview-widget-container" style="height:500px;width:100%">
    <div class="tradingview-widget-container__widget" style="height:calc(100% - 32px);width:100%"></div>
    <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/" rel="noopener nofollow"
        target="_blank"><span class="blue-text">Track all markets on TradingView</span></a></div>
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
                                  "symbol": "{{ $watchlist[0] ?? 'BINANCE:BTCUSDT' }}",
                                    "theme": "light",
                                      "timezone": "Etc/UTC",
                                        "backgroundColor": "#ffffff",
                                          "gridColor": "rgba(46, 46, 46, 0.06)",
                                            "watchlist": {!! json_encode($watchlist) !!},
                                              "withdateranges": false,
                                                "compareSymbols": [],
                                                  "studies": [],
                                                    "autosize": true
        }
      </script>
  </div>
  <!-- TradingView Widget END -->
</x-main>