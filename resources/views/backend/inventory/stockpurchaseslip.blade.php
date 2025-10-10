{{-- filepath: resources/views/backend/purchasing_slip/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-6" x-data="purchaseSlip()" x-init="date = today">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Create Stock Purchase Slip</h1>

    <!-- Purchase Slip Form -->
    <form @submit.prevent="showSlip = true" autocomplete="off">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-gray-600">Date</label>
                <input type="date"
                       name="date"
                       x-model="date"
                       class="w-full border rounded px-3 py-2"
                       :value="today"
                       required>
            </div>
        </div>

        <!-- Stock Items Table -->
        <div class="bg-gray-50 p-6 rounded shadow mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-700">Stock Items</h2>
                <button type="button"
                        @click="addItem"
                        class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700">
                    + Add Stock
                </button>
            </div>

            <template x-for="(item, index) in items" :key="index">
                <div class="bg-white p-4 rounded border mb-3">
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
                        <div>
                            <label class="block text-gray-600">Stock Name</label>
                            <input type="text"
                                   x-model="item.name"
                                   :name="`items[${index}][name]`"
                                   class="w-full border rounded px-2 py-1" required>
                        </div>
                        <div>
                            <label class="block text-gray-600">Quantity</label>
                            <input type="number"
                                   min="1"
                                   x-model.number="item.quantity"
                                   :name="`items[${index}][quantity]`"
                                   class="w-full border rounded px-2 py-1" required>
                        </div>
                        <div>
                            <label class="block text-gray-600">Unit Price</label>
                            <input type="number"
                                   min="0"
                                   step="0.01"
                                   x-model.number="item.unit_price"
                                   :name="`items[${index}][unit_price]`"
                                   class="w-full border rounded px-2 py-1" required>
                        </div>
                        <div>
                            <label class="block text-gray-600">Amount</label>
                            <input type="number"
                                   :value="(item.quantity * item.unit_price).toFixed(2)"
                                   class="w-full border rounded px-2 py-1 bg-gray-100"
                                   readonly>
                        </div>
                        <div class="flex items-end">
                            <button type="button" @click="removeItem(index)" class="text-red-600 text-sm hover:text-red-800">Remove</button>
                        </div>
                    </div>
                </div>
            </template>

            <div x-show="items.length === 0" class="text-gray-500 text-sm">
                No stock items added yet.
            </div>

            <div class="mt-3 text-right text-gray-700 font-semibold" x-show="items.length > 0">
                Total Amount: GHS <span x-text="totalAmount.toFixed(2)"></span>
            </div>
        </div>

        <div class="text-right">
            <button type="submit"
                    class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 disabled:opacity-50"
                    :disabled="items.length === 0">
                Generate Purchase Slip
            </button>
        </div>
    </form>

    <!-- Purchase Slip Modal/Section -->
    <div x-show="showSlip" style="background: rgba(0,0,0,0.5)" class="fixed inset-0 flex items-center justify-center z-50">
        <div class="bg-white p-8 rounded shadow-lg w-full max-w-2xl relative" id="printable-slip">
            <button @click="showSlip = false" class="absolute top-2 right-2 text-gray-500 hover:text-red-600">&times;</button>
            <h2 class="text-xl font-bold mb-4 text-center">Stock Purchase Slip</h2>
            <div class="mb-2"><strong>Date:</strong> <span x-text="date"></span></div>
            <table class="w-full mb-4 border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-2 py-1 text-left">#</th>
                        <th class="border px-2 py-1 text-left">Stock Name</th>
                        <th class="border px-2 py-1 text-left">Quantity</th>
                        <th class="border px-2 py-1 text-left">Unit Price</th>
                        <th class="border px-2 py-1 text-left">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(item, idx) in items" :key="idx">
                        <tr>
                            <td class="border px-2 py-1" x-text="idx + 1"></td>
                            <td class="border px-2 py-1" x-text="item.name"></td>
                            <td class="border px-2 py-1" x-text="item.quantity"></td>
                            <td class="border px-2 py-1" x-text="parseFloat(item.unit_price).toFixed(2)"></td>
                            <td class="border px-2 py-1" x-text="(item.quantity * item.unit_price).toFixed(2)"></td>
                        </tr>
                    </template>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="border px-2 py-1 font-bold text-right">Total</td>
                        <td class="border px-2 py-1 font-bold" x-text="totalAmount.toFixed(2)"></td>
                    </tr>
                </tfoot>
            </table>
            <div class="flex justify-between mt-8">
                <div>
                    <div class="mb-12"><strong>Supervisor Signature:</strong></div>
                    <div class="border-t border-gray-400 w-48"></div>
                </div>
                <div>
                    <div class="mb-12"><strong>Accountant Signature:</strong></div>
                    <div class="border-t border-gray-400 w-48"></div>
                </div>
            </div>
            <div class="text-center mt-8">
                <button @click="printSlip" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Print Slip</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="//unpkg.com/alpinejs" defer></script>
<script>
function purchaseSlip() {
    return {
        date: '',
        showSlip: false,
        get today() {
            const d = new Date();
            return d.toISOString().slice(0, 10);
        },
        items: [],
        addItem() {
            this.items.push({
                name: '',
                quantity: 1,
                unit_price: 0
            });
        },
        removeItem(index) {
            this.items.splice(index, 1);
        },
        get totalAmount() {
            return this.items.reduce((sum, i) => sum + ((parseFloat(i.quantity) || 0) * (parseFloat(i.unit_price) || 0)), 0);
        },
        printSlip() {
            let printContents = document.getElementById('printable-slip').innerHTML;
            let originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            window.location.reload();
        }
    }
}
</script>
@endpush