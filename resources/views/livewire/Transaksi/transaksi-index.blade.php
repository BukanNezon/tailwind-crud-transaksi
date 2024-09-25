<div class="container mx-auto mt-10 p-8 max-w-5xl bg-white shadow-md rounded-lg" x-data="{ openModal: false, selectedTransaksi: null }">
    <h1 class="mb-4 text-2xl font-semibold text-center">Transaksi</h1>
    
    <div class="flex justify-between mb-4">
        <!-- Search Bar -->
        <div class="w-1/2">
            <input type="text" class="border rounded w-full py-2 px-3" placeholder="Search transactions..." wire:model.live="search">
        </div>
        <!-- Add Transaction Button -->
        <a href="{{ route('transaksi.form') }}" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Make Transaction</a>
    </div>

    <!-- Transaction Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto bg-white border border-gray-300">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-2 px-4 border border-gray-300">#</th>
                    <th class="py-2 px-4 border border-gray-300">Invoice</th>
                    <th class="py-2 px-4 border border-gray-300">Pelanggan</th>
                    <th class="py-2 px-4 border border-gray-300">Tanggal</th>
                    <th class="py-2 px-4 border border-gray-300">Total</th>
                    <th class="py-2 px-4 border border-gray-300">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksis as $transaksi)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $transaksi->id }}</td>
                        <td class="py-2 px-4">
                            <a href="#" class="text-blue-500 hover:underline" @click.prevent="selectedTransaksi = {{ $transaksi->id }}; openModal = true" wire:click="loadTransaksi({{ $transaksi->id }})">
                                {{ $transaksi->invoice }}
                            </a>
                        </td>
                        <td class="py-2 px-4">{{ $transaksi->pelanggan }}</td>
                        <td class="py-2 px-4">{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d-m-Y') }}</td>
                        <td class="py-2 px-4">{{ number_format($transaksi->details->sum('total'), 2) }}</td>
                        <td class="py-2 text-center px-4">
                            <button class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-600 text-sm" @click="$dispatch('transaksi-delete', { get_id: {{ $transaksi->id }} })">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $transaksis->links('pagination::tailwind') }}
    </div>

    <x-transaksi-delete />

    <!-- Modal for displaying transaction details -->
    <div x-show="openModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50 overflow-y-auto" x-cloak>
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-auto">
            <div class="px-6 py-4 border-b">
                <h2 class="text-lg font-semibold">Detail Transaksi</h2>
                <button class="absolute top-2 right-2" @click="openModal = false">✖</button>
            </div>
            <div class="px-6 py-4">
                @if($selectedTransaksi)
                    <p><strong>Invoice:</strong> {{ $selectedTransaksi->invoice }}</p>
                    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($selectedTransaksi->tanggal)->format('d-m-Y') }}</p>

                    <!-- Product Details -->
                    <table class="w-full text-sm mt-2 border border-gray-300">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="py-2 px-4 border border-gray-300">Nama Produk</th>
                                <th class="py-2 px-4 border border-gray-300">Harga</th>
                                <th class="py-2 px-4 border border-gray-300">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($selectedTransaksi->details as $detail)
                                <tr class="border-b">
                                    <td class="py-2 px-4">{{ $detail->product->name }}</td>
                                    <td class="py-2 px-4">{{ number_format($detail->product->harga, 2) }}</td>
                                    <td class="py-2 px-4">{{ $detail->qty }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Payment Details -->
                    <p class="mt-4"><strong>Pembayaran:</strong> Rp {{ number_format($selectedTransaksi->pembayaran, 2) }}</p>
                    <p><strong>Kembalian:</strong> Rp {{ number_format($selectedTransaksi->kembalian, 2) }}</p>
                    <p><strong>Total:</strong> Rp {{ number_format($selectedTransaksi->details->sum('total'), 2) }}</p>
                @endif
            </div>
            <div class="px-6 py-4 border-t flex justify-between">
                <button class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600" @click="openModal = false">Close</button>
            </div>
        </div>
    </div>
</div>
