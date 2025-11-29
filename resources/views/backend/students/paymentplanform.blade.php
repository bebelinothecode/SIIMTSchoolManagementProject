@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-6">
    {{-- <h1 class="text-2xl font-bold text-gray-800 mb-6">Payment Plan</h1> --}}

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Payment Plan</h1>
        <div class="flex flex-wrap items-center">
            <a href="{{ url()->previous() }}" class="bg-gray-200 text-gray-700 text-sm uppercase py-2 px-4 flex items-center rounded">
                <svg class="w-3 h-3 fill-current" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="long-arrow-alt-left" class="svg-inline--fa fa-long-arrow-alt-left fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M134.059 296H436c6.627 0 12-5.373 12-12v-56c0-6.627-5.373-12-12-12H134.059v-46.059c0-21.382-25.851-32.09-40.971-16.971L7.029 239.029c-9.373 9.373-9.373 24.569 0 33.941l86.059 86.059c15.119 15.119 40.971 4.411 40.971-16.971V296z"></path></svg>
                <span class="ml-2 text-xs font-semibold">Back</span>
            </a>
        </div>
    </div>

    <!-- Due Date Alerts Summary -->
    @if($student->paymentPlans && $student->paymentPlans->count())
        @php
            $dueSoonCount = 0;
            $overdueCount = 0;
            $today = now()->startOfDay();
        @endphp
        
        @foreach($student->paymentPlans as $plan)
            @if($plan->installments)
                @foreach($plan->installments as $inst)
                    @if(!$inst->paid_on)
                        @php
                            $dueDate = \Carbon\Carbon::parse($inst->due_date);
                            $daysUntilDue = $today->diffInDays($dueDate, false);
                            
                            if ($daysUntilDue < 0) {
                                $overdueCount++;
                            } elseif ($daysUntilDue <= 7) {
                                $dueSoonCount++;
                            }
                        @endphp
                    @endif
                @endforeach
            @endif
        @endforeach

        @if($overdueCount > 0 || $dueSoonCount > 0)
        <div class="mb-6">
            @if($overdueCount > 0)
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-3">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-red-800 font-semibold">
                        {{ $overdueCount }} installment(s) are overdue!
                    </span>
                </div>
            </div>
            @endif

            @if($dueSoonCount > 0)
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-yellow-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-yellow-800 font-semibold">
                        {{ $dueSoonCount }} installment(s) due within 7 days!
                    </span>
                </div>
            </div>
            @endif
        </div>
        @endif
    @endif

    <!-- Student Info -->
    <div class="bg-white p-6 rounded shadow mb-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Student Details</h2>
        <p><strong>Name:</strong> {{ $student->user->name }}</p>
        <p><strong>Email:</strong> {{ $student->user->email }}</p>
        <p><strong>Phone:</strong> {{ $student->phone ?? 'N/A' }}</p>
        <p><strong>Programme:</strong> {{ $student->course->course_name ?? $student->diploma->name ?? 'N/A' }}</p>
        @if ($student->student_category === 'Academic')
            <p><strong>Level:</strong> {{ $student->level ?? 'N/A' }}</p> 
            <p><strong>Semester:</strong> {{ $student->session ?? 'N/A' }}</p> 
        @endif
    </div>

    @if($student->paymentPlans && $student->paymentPlans->count())
        @foreach($student->paymentPlans as $plan)
            <!-- Payment Plan Info (Read-only) -->
            <div class="bg-white p-6 rounded shadow mb-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Existing Payment Plan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-600">Total Fees Due</label>
                        <input type="number" value="{{ $plan->total_fees_due }}" class="w-full border rounded px-3 py-2" readonly>
                    </div>
                    <div>
                        <label class="block text-gray-600">Amount Already Paid</label>
                        <input type="number" value="{{ $plan->amount_already_paid }}" class="w-full border rounded px-3 py-2" readonly>
                    </div>
                    <div>
                        <label class="block text-gray-600">Outstanding Balance</label>
                        <input type="number" value="{{ $plan->outstanding_balance }}" class="w-full border rounded px-3 py-2" readonly>
                    </div>
                    <div>
                        <label class="block text-gray-600">Currency</label>
                        <input type="text" value="{{ $plan->currency }}" class="w-full border rounded px-3 py-2" readonly>
                    </div>
                </div>
            </div>

            <!-- Installments with Payment Update Form -->
            <form action="{{ route('update.installments', $plan->id) }}" method="POST" x-data="paymentUpdate()">
                @csrf
                @method('PUT')
                
                <div class="bg-gray-50 p-6 rounded shadow mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-700">Installments</h2>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                            Update Payments
                        </button>
                    </div>
                    
                    @if($plan->installments && $plan->installments->count())
                        <table class="w-full border">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-2 border">#</th>
                                    <th class="p-2 border">Due Date</th>
                                    <th class="p-2 border">Amount</th>
                                    <th class="p-2 border">Payment Method</th>
                                    <th class="p-2 border">Status</th>
                                    <th class="p-2 border">Due Status</th>
                                    <th class="p-2 border">Mark as Paid</th>
                                    <th class="p-2 border">Paid On</th>
                                    <th class="p-2 border">Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($plan->installments as $index => $inst)
                                    @php
                                        $dueDate = \Carbon\Carbon::parse($inst->due_date);
                                        $today = now();
                                        $daysUntilDue = $today->diffInDays($dueDate, false);
                                        
                                        $dueStatus = '';
                                        $statusColor = '';
                                        $statusIcon = '';
                                        
                                        if ($inst->paid_on) {
                                            $dueStatus = 'Paid';
                                            $statusColor = 'bg-green-100 text-green-800';
                                            $statusIcon = '✓';
                                        } elseif ($daysUntilDue < 0) {
                                            $dueStatus = 'Overdue';
                                            $statusColor = 'bg-red-100 text-red-800';
                                            $statusIcon = '⚠';
                                        } elseif ($daysUntilDue == 0) {
                                            $dueStatus = 'Due Today';
                                            $statusColor = 'bg-orange-100 text-orange-800';
                                            $statusIcon = '⏰';
                                        } elseif ($daysUntilDue <= 7) {
                                            $dueStatus = 'Due Soon';
                                            $statusColor = 'bg-yellow-100 text-yellow-800';
                                            $statusIcon = '📅';
                                        } else {
                                            $dueStatus = 'Future';
                                            $statusColor = 'bg-blue-100 text-blue-800';
                                            $statusIcon = '⏳';
                                        }
                                    @endphp
                                    <tr class="@if($dueStatus === 'Overdue') bg-red-50 @elseif($dueStatus === 'Due Today') bg-orange-50 @elseif($dueStatus === 'Due Soon') bg-yellow-50 @endif">
                                        <td class="p-2 border">{{ $inst->installments_num }}</td>
                                        <td class="p-2 border font-medium">
                                            {{ $inst->due_date }}
                                            @if($dueStatus === 'Overdue')
                                                <div class="text-xs text-red-600 mt-1">
                                                    Overdue by {{ abs($daysUntilDue) }} day(s)
                                                </div>
                                            @elseif($dueStatus === 'Due Today')
                                                <div class="text-xs text-orange-600 mt-1">
                                                    Due today!
                                                </div>
                                            @elseif($dueStatus === 'Due Soon')
                                                <div class="text-xs text-yellow-600 mt-1">
                                                    Due in {{ $daysUntilDue }} day(s)
                                                </div>
                                            @endif
                                        </td>
                                        <td class="p-2 border">GHS {{ number_format($inst->amount, 2) }}</td>
                                        <td class="p-2 border">{{ $inst->payment_method }}</td>
                                        <td class="p-2 border">
                                            @if($inst->paid_on)
                                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Paid</span>
                                            @else
                                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Pending</span>
                                            @endif
                                        </td>
                                        <td class="p-2 border">
                                            <span class="{{ $statusColor }} px-2 py-1 rounded text-xs font-medium">
                                                {{ $statusIcon }} {{ $dueStatus }}
                                            </span>
                                        </td>
                                        <td class="p-2 border">
                                            <input type="checkbox" 
                                                   name="installments[{{ $index }}][is_paid]" 
                                                   value="1"
                                                   @if($inst->paid_on) checked @endif
                                                   @change="togglePaidDate({{ $index }})"
                                                   class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                                            <input type="hidden" name="installments[{{ $index }}][id]" value="{{ $inst->id }}">
                                        </td>
                                        <td class="p-2 border">
                                            <input type="datetime-local" 
                                                   name="installments[{{ $index }}][paid_on]" 
                                                   value="{{ $inst->paid_on ? \Carbon\Carbon::parse($inst->paid_on)->format('Y-m-d\TH:i') : '' }}"
                                                   :disabled="!document.querySelector('input[name=\"installments[{{ $index }}][is_paid]\"]').checked"
                                                   class="w-full border rounded px-2 py-1 text-sm disabled:bg-gray-100">
                                        </td>
                                        <td class="p-2 border">
                                            <input type="text" 
                                                   name="installments[{{ $index }}][notes]" 
                                                   value="{{ $inst->notes }}"
                                                   class="w-full border rounded px-2 py-1 text-sm"
                                                   placeholder="Payment notes">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-gray-500 text-sm">No installments added yet.</div>
                    @endif
                </div>
            </form>
        @endforeach
    @else
        <!-- New Payment Plan Creation Form (Your existing code) -->
        <form action="{{ route('save.paymentplan', $student->id) }}" method="POST" x-data="paymentPlan()">
            @csrf
            <input type="hidden" name="student_id" value="{{ $student->id }}">

            <!-- Payment Plan Info -->
            <div class="bg-white p-6 rounded shadow mb-6">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Create Payment Plan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-600">Total Fees Due</label>
                        <input type="number"
                               x-model.number="totalFees"
                               value="{{ $student->course->fees ?? $student->diploma->fees ?? 0 }}"
                               step="0.01"
                               name="total_fees_due"
                               class="w-full border rounded px-3 py-2"
                               readonly>
                    </div>
                    <div>
                        <label class="block text-gray-600">Amount Already Paid</label>
                        <input type="number"
                               x-model.number="amountPaid"
                               step="0.01"
                               name="amount_already_paid"
                               class="w-full border rounded px-3 py-2"
                               value="0">
                    </div>
                    <div>
                        <label class="block text-gray-600">Outstanding Balance</label>
                        <input type="number"
                               :value="outstandingBalance.toFixed(2)"
                               step="0.01"
                               name="outstanding_balance"
                               class="w-full border rounded px-3 py-2"
                               readonly>
                    </div>
                    <div>
                        <label class="block text-gray-600">Currency</label>
                        <select name="currency" class="w-full border rounded px-3 py-2" required>
                            <option value="Ghana Cedi">GHS (Ghana Cedi)</option>
                            <option value="Dollar">USD (Dollar)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Installments -->
            <div class="bg-gray-50 p-6 rounded shadow mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-700">Installments</h2>
                    <button type="button"
                            @click="addInstallment"
                            class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700">
                        + Add Installment
                    </button>
                </div>

                <template x-for="(installment, index) in installments" :key="index">
                    <div class="bg-white p-4 rounded border mb-3">
                        <div class="grid grid-cols-1 md:grid-cols-6 gap-3">
                            <div>
                                <label class="block text-gray-600">#</label>
                                <input type="number"
                                       x-model="installment.number"
                                       :name="`installments[${index}][installments_num]`"
                                       class="w-full border rounded px-2 py-1" readonly>
                            </div>
                            <div>
                                <label class="block text-gray-600">Due Date</label>
                                <input type="date"
                                       x-model="installment.due_date"
                                       :name="`installments[${index}][due_date]`"
                                       @change="checkDueDate(installment)"
                                       class="w-full border rounded px-2 py-1" required>
                                <div x-show="installment.dueStatus" class="text-xs mt-1" 
                                     :class="{
                                         'text-red-600': installment.dueStatus === 'overdue',
                                         'text-orange-600': installment.dueStatus === 'dueToday',
                                         'text-yellow-600': installment.dueStatus === 'dueSoon'
                                     }">
                                    <template x-if="installment.dueStatus === 'overdue'">
                                        ⚠ Overdue
                                    </template>
                                    <template x-if="installment.dueStatus === 'dueToday'">
                                        ⏰ Due today!
                                    </template>
                                    <template x-if="installment.dueStatus === 'dueSoon'">
                                        📅 Due soon
                                    </template>
                                </div>
                            </div>
                            <div>
                                <label class="block text-gray-600">Amount</label>
                                <input type="number"
                                       step="0.01"
                                       x-model.number="installment.amount"
                                       @input="checkInstallmentLimit()"
                                       :name="`installments[${index}][amount]`"
                                       class="w-full border rounded px-2 py-1" required>
                            </div>
                            <div>
                                <label class="block text-gray-600">Payment Method</label>
                                <select
                                    :name="`installments[${index}][payment_method]`"
                                    x-model="installment.method"
                                    class="w-full border rounded px-2 py-1" required>
                                    <option value="">-- Select method --</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Mobile Money">Mobile Money</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                </select>
                            </div>

                            <!-- Mark as Paid Checkbox -->
                            {{-- <div>
                                <label class="block text-gray-600">Mark as Paid</label>
                                <div class="flex items-center h-9">
                                    <input type="checkbox"
                                           x-model="installment.is_paid"
                                           @change="togglePaidStatus(index)"
                                           class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                                    <span class="ml-2 text-sm" x-text="installment.is_paid ? 'Paid' : 'Unpaid'"></span>
                                </div>
                            </div> --}}

                            <!-- Paid On (auto-populated when checkbox is checked) -->
                            {{-- <div>
                                <label class="block text-gray-600">Paid On</label>
                                <input type="datetime-local"
                                       x-model="installment.paid_on"
                                       :name="`installments[${index}][paid_on]`"
                                       :disabled="!installment.is_paid"
                                       class="w-full border rounded px-2 py-1 disabled:bg-gray-100"
                                       :class="{'bg-gray-100': !installment.is_paid}">
                            </div> --}}
                        </div>
                        
                        <!-- Notes (full width) -->
                        <div class="mt-3">
                            <label class="block text-gray-600">Notes</label>
                            <input type="text"
                                   x-model="installment.notes"
                                   :name="`installments[${index}][notes]`"
                                   class="w-full border rounded px-2 py-1"
                                   placeholder="Add payment notes or references">
                        </div>
                        
                        <button type="button" @click="removeInstallment(index)"
                                class="mt-2 text-red-600 text-sm hover:text-red-800">Remove</button>
                    </div>
                </template>

                <div x-show="installments.length === 0" class="text-gray-500 text-sm">
                    No installments added yet.
                </div>

                <div class="mt-3 text-right text-gray-700 font-semibold" x-show="installments.length > 0">
                    Total of installments: GHS <span x-text="totalInstallmentAmount.toFixed(2)"></span>
                </div>
                <p class="text-sm text-red-600 mt-2" x-show="!installmentsMatch && totalInstallmentAmount > 0">
                    ⚠️ The total of installments must match the outstanding balance (GHS <span x-text="outstandingBalance.toFixed(2)"></span>).
                </p>
            </div>

            <!-- Submit -->
            <div class="text-right">
                <button type="submit"
                        class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 disabled:opacity-50"
                        :disabled="!installmentsMatch">
                    Save Payment Plan
                </button>
            </div>
        </form>
    @endif
</div>
@endsection

@push('scripts')
<script src="//unpkg.com/alpinejs" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function paymentPlan() {
    return {
        totalFees: {{ $student->course->fees ?? $student->diploma->fees ?? 0 }},
        amountPaid: 0,
        installments: [],
        get outstandingBalance() {
            return this.totalFees - this.amountPaid;
        },
        get totalInstallmentAmount() {
            return this.installments.reduce((sum, i) => sum + (parseFloat(i.amount) || 0), 0);
        },
        get installmentsMatch() {
            return this.outstandingBalance.toFixed(2) == this.totalInstallmentAmount.toFixed(2);
        },
        addInstallment() {
            this.installments.push({
                number: this.installments.length + 1,
                due_date: '',
                amount: '',
                method: '',
                is_paid: false,
                paid_on: '',
                notes: '',
                dueStatus: ''
            });
        },
        removeInstallment(index) {
            this.installments.splice(index, 1);
            this.installments.forEach((i, idx) => i.number = idx + 1);
        },
        togglePaidStatus(index) {
            const installment = this.installments[index];
            if (installment.is_paid) {
                // Auto-fill with current date and time when checked
                const now = new Date();
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                installment.paid_on = `${year}-${month}-${day}T${hours}:${minutes}`;
            } else {
                // Clear paid_on when unchecked
                installment.paid_on = '';
            }
        },
        checkInstallmentLimit() {
            if (this.totalInstallmentAmount > this.outstandingBalance) {
                Swal.fire({
                    title: 'Amount Exceeded',
                    text: `The total installments (GHS ${this.totalInstallmentAmount.toFixed(2)}) exceed the outstanding balance (GHS ${this.outstandingBalance.toFixed(2)}).`,
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            }
        },
        checkDueDate(installment) {
            if (!installment.due_date) return;
            
            const dueDate = new Date(installment.due_date);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            const timeDiff = dueDate.getTime() - today.getTime();
            const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
            
            if (daysDiff < 0) {
                installment.dueStatus = 'overdue';
            } else if (daysDiff === 0) {
                installment.dueStatus = 'dueToday';
            } else if (daysDiff <= 7) {
                installment.dueStatus = 'dueSoon';
            } else {
                installment.dueStatus = '';
            }
        }
    }
}

function paymentUpdate() {
    return {
        togglePaidDate(index) {
            const checkbox = document.querySelector(`input[name="installments[${index}][is_paid]"]`);
            const dateField = document.querySelector(`input[name="installments[${index}][paid_on]"]`);
            
            if (checkbox.checked) {
                // Auto-fill with current date and time when checked
                const now = new Date();
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                dateField.value = `${year}-${month}-${day}T${hours}:${minutes}`;
            } else {
                // Clear paid_on when unchecked
                dateField.value = '';
            }
        }
    }
}

// Auto-show alert for overdue payments when page loads
document.addEventListener('DOMContentLoaded', function() {
    @if($student->paymentPlans && $student->paymentPlans->count())
        @php
            $hasOverdue = false;
            $overdueInstallments = [];
            $today = now()->startOfDay();
        @endphp
        
        @foreach($student->paymentPlans as $plan)
            @if($plan->installments)
                @foreach($plan->installments as $inst)
                    @if(!$inst->paid_on)
                        @php
                            $dueDate = \Carbon\Carbon::parse($inst->due_date);
                            if ($today->gt($dueDate)) {
                                $hasOverdue = true;
                                $overdueInstallments[] = [
                                    'number' => $inst->installments_num,
                                    'due_date' => $inst->due_date,
                                    'amount' => $inst->amount,
                                    'days_overdue' => $today->diffInDays($dueDate)
                                ];
                            }
                        @endphp
                    @endif
                @endforeach
            @endif
        @endforeach

        @if($hasOverdue)
            Swal.fire({
                title: 'Overdue Payments!',
                html: `You have {{ count($overdueInstallments) }} overdue installment(s).<br>
                      Please review the payment plan and update payment status.`,
                icon: 'warning',
                confirmButtonText: 'View Installments',
                confirmButtonColor: '#dc2626'
            });
        @endif
    @endif
});
</script>

@if (session('success'))
    <script>
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            title: 'Error!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>
@endif
@endpush