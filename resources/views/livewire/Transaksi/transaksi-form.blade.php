<div class="container mx-auto mt-10 p-8 max-w-5xl bg-white shadow-md rounded-lg" 
     x-data="{ quantityAlert: false, paymentAlert: false, successAlert: false, emptyCartAlert: false }">
    <h2 class="text-center text-2xl font-bold mb-8">Transaction Form</h2>
    
    <!-- Form transaksi -->
    <form class="space-y-6" wire:submit.prevent="saveTransaction">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="form-group">
                <label for="customerName" class="block mb-2">Customer Name</label>
                <input type="text" id="customerName" class="w-full border border-gray-300 rounded-lg p-2" wire:model="customerName">
                @error('customerName') <small class="text-red-500">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="invoice" class="block mb-2">Invoice</label>
                <input type="text" id="invoice" class="w-full border border-gray-300 rounded-lg p-2" wire:model="invoice" readonly value="{{ $invoice }}">
            </div>

            <div class="form-group">
                <label for="transactionDate" class="block mb-2">Transaction Date</label>
                <input type="date" id="transactionDate" class="w-full border border-gray-300 rounded-lg p-2" wire:model="transactionDate">
                @error('transactionDate') <small class="text-red-500">{{ $message }}</small> @enderror
            </div>

            <div class="form-group">
                <label for="product" class="block mb-2">Select Product</label>
                <select id="product" class="w-full border border-gray-300 rounded-lg p-2" wire:model="selectedProduct">
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ $product->jumlah == 0 ? 'disabled' : '' }}>
                            {{ $product->jumlah == 0 ? 'EMPTY' : '' }} {{ $product->name }} - {{ number_format($product->harga, 2) }}
                        </option>
                    @endforeach
                </select>
                @error('selectedProduct') <small class="text-red-500">{{ $message }}</small> @enderror
            </div>
        </div>
        
        <div class="flex justify-center mt-4">
            <button wire:click="addToCart" type="button" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600">
                Add to Cart
            </button>
        </div>
    </form>

    <!-- Menampilkan keranjang -->
    @if(count($cart) > 0)
        <div class="card mt-8">
            <div class="card-header">
                <h4 class="text-xl font-bold">Cart</h4>
            </div>
            <div class="card-body">
                <table class="table-auto w-full mt-4 border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2">Product</th>
                            <th class="border border-gray-300 px-4 py-2">Quantity</th>
                            <th class="border border-gray-300 px-4 py-2">Price</th>
                            <th class="border border-gray-300 px-4 py-2">Total</th>
                            <th class="border border-gray-300 px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart as $index => $item)
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">{{ $item['product']->name }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <input type="number" class="w-full border border-gray-300 rounded-lg p-2" wire:model="cart.{{ $index }}.quantity" min="1" wire:change="updateQuantity({{ $index }}, $event.target.value)">
                                    @if($item['quantity'] > $item['product']->jumlah)
                                        <small class="text-red-500">Quantity exceeds available stock!</small>
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-4 py-2">{{ number_format($item['price'], 2) }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ number_format($item['total'], 2) }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <button class="bg-red-500 text-white font-semibold py-1 px-2 rounded-lg hover:bg-red-600" wire:click="removeItem({{ $index }})">Remove</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="alert alert-info mt-4 text-center">Cart is empty.</div>
    @endif

    <!-- Payment Details dalam tabel -->
    <div class="mt-8">
        @php
            $total = array_sum(array_column($cart, 'total'));
        @endphp
        @if ($payment < $total)
            <div class="bg-red-500 text-white p-2 rounded-lg mb-4">
                Your payment is insufficient!
            </div>
        @endif

        <h3 class="text-xl font-bold mb-4">Payment Details</h3>
        <table class="table-auto w-full border-collapse border border-gray-300">
            <tbody>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2">Payment</th>
                    <td class="border border-gray-300 px-4 py-2">
                        <input type="number" id="payment" class="w-full border border-gray-300 rounded-lg p-2" wire:model="payment" wire:input="calculateTotal">
                    </td>
                </tr>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2">Change</th>
                    <td class="border border-gray-300 px-4 py-2">{{ number_format($change, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Notifikasi jika tidak ada transaksi di keranjang -->
        @if (count($cart) == 0)
            <div class="bg-red-500 text-white p-2 rounded-lg mt-4">
                No transactions. Cart is empty!
            </div>
        @endif

        <!-- Notifikasi jika transaksi berhasil -->
        @if (session()->has('success'))
            <div class="bg-green-500 text-white p-2 rounded-lg mt-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-center mt-8">
            <button wire:click="saveTransaction" class="bg-green-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-600">
                Save Transaction
            </button>
        </div>
    </div>
</div>
