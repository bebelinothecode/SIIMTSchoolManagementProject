@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Inventory Detailed Report - All Items</h3>

    @foreach($data as $id => $item)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $item['stock']->stock_name ?? 'Item ' . $id }}</h5>
                <p><strong>Current Amount:</strong> {{ $item['current_amount'] }}</p>

                <div class="row">
                    <div class="col-md-6">
                        <h6>Stock In (recent)</h6>
                        <ul>
                            @foreach($item['ins'] as $in)
                                <li>{{ optional($in->created_at)->format('Y-m-d') }} — {{ $in->new_stock_in_quantity }}</li>
                            @endforeach
                            @if(empty($item['ins']) || count($item['ins'])===0)
                                <li>No stock in records</li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Stock Out (recent)</h6>
                        <ul>
                            @foreach($item['outs'] as $out)
                                <li>{{ optional($out->date_issued)->format('Y-m-d') }} — {{ $out->quantity_issued }}</li>
                            @endforeach
                            @if(empty($item['outs']) || count($item['outs'])===0)
                                <li>No stock out records</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <a href="{{ route('inventoryreport.form') }}" class="btn btn-secondary">Back to Inventory Report</a>
</div>
@endsection
