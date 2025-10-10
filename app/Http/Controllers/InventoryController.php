<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stock;

class InventoryController extends Controller
{
     public function index(Request $request)
    {

        $searchTerm = $request->input('search');

        $stocks = Stock::where(function ($query) use ($searchTerm) {
            $query->where('stock_name', 'LIKE', "%{$searchTerm}%")
                ->orWhere('location', 'LIKE', "%{$searchTerm}%");
        })->paginate(10);

        return view('backend.inventory.index', compact('stocks'));
    }

    public function create()
    {
        return view('backend.inventory.create');
    }

    public function store(Request $request)
    {
        try {
            //code...
            // dd($request->all());
            $validatedData = $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'quantity'      => 'required|integer|min:0',
            'unit_of_measure' => 'nullable|string',
            'location'      => 'nullable|string|max:100'
        ]);

        $stockName = $validatedData['name'];
        $description = $validatedData['description'] ?? null;
        $quantity = $validatedData['quantity'];
        $unitOfMeasure = $validatedData['unit_of_measure'] ?? null;
        $location = $validatedData['location'] ?? null;



        Stock::create([
            'stock_name' => $stockName,
            'description' => $description,
            'quantity' => $quantity,
            'unit_of_measure' => $unitOfMeasure,
            'location' => $location,
        ]);

        return redirect()->back()->with('success', 'Stock item created successfully.');
        } catch (Exception $e) {
            //throw $th;
            return redirect()->back()->with('error', 'An error occurred while creating the stock item.');
            Log::error('Error creating stock item: ' . $e->getMessage());
        }

    }

     public function edit($id)
    {
        $stock = Stock::findOrFail($id);

        return view('backend.inventory.edit', compact('stock'));
    }

    public function update(Request $request, $id)
    {
        try {
            //code...
            $validatedData = $request->validate([
                'name'          => 'required|string|max:255',
                'description'   => 'nullable|string',
                'quantity'      => 'required|integer|min:0',
                'unit_of_measure' => 'nullable|string',
                'location'      => 'nullable|string|max:100'
            ]);

            $stock = Stock::findOrFail($id);

            $stock->update([
                'stock_name' => $validatedData['name'],
                'description' => $validatedData['description'] ?? null,
                'quantity' => $validatedData['quantity'],
                'unit_of_measure' => $validatedData['unit_of_measure'] ?? null,
                'location' => $validatedData['location'] ?? null,
            ]);

            return redirect()->back()->with('success', 'Stock item updated successfully.');
        } catch (Exception $e) {
            //throw $th;
            return redirect()->back()->with('error', 'An error occurred while updating the stock item.');
            Log::error('Error updating stock item: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            //code...
            $stock = Stock::findOrFail($id);
            $stock->delete();

            return redirect()->back()->with('success', 'Stock item deleted successfully.');
        } catch (Exception $e) {
            //throw $th;
            return redirect()->back()->with('error', 'An error occurred while deleting the stock item.');
            Log::error('Error deleting stock item: ' . $e->getMessage());
        }
    }

    public function stockInForm($id)
    {
        $stock = Stock::findOrFail($id);

        // return $stock;
        return view('backend.inventory.transactionform', compact('stock'));
    }

    public function saveStockIn(Request $request, $id)
    {
        try {
            //code...
            // dd($request->all());
            $validatedData = $request->validate([
            'new_quantity'          => 'required|integer|min:0',
            'old_quantity'          => 'nullable|integer|min:0',
            'total'                 => 'nullable|integer|min:0',
            'unit_price'            => 'nullable|numeric|min:0',
            'suppliers_info'        => 'nullable|string',
            'remarks'               => 'nullable|string',
            'date_in'               => 'required|date',
        ]);

        $stock = Stock::findOrFail($id);

        $newQuantity = $validatedData['new_quantity'];
        $oldQuantity = $validatedData['old_quantity'] ?? 0;
        $total = $validatedData['total'] ?? ($oldQuantity + $newQuantity);
        $unitPrice = $validatedData['unit_price'] ?? null;
        $suppliersInfo = $validatedData['suppliers_info'] ?? null;
        $remarks = $validatedData['remarks'] ?? null;
        $dateIn = $validatedData['date_in'];

        // Update stock quantity
        $stock->quantity = $total;
        $stock->save();

        // Save to stock_in table
        \DB::table('stock_in')->insert([
            'stock_id' => $stock->id,
            'new_stock_in_quantity' => $newQuantity,
            'old_stock_in_quantity' => $oldQuantity,
            'total_stock_after_in' => $total,
            'unit_price' => $unitPrice,
            'suppliers_info' => $suppliersInfo,
            'date_in' => $dateIn,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Stock in recorded successfully.');
        } catch (Exception $e) {
            //throw $th;
            return redirect()->back()->with('error', 'An error occurred while recording stock in.');
            Log::error('Error recording stock in: ' . $e->getMessage());
        }

    }

    public function stockOutForm($id)
    {
        $stock = Stock::findOrFail($id);

        // return $stock;
        return view('backend.inventory.stockoutform', compact('stock'));
    }

    public function saveStockOut(Request $request, $id)
    {
        try {
            //code...
            // dd($request->all());
            $validatedData = $request->validate([
            'quantity_issued'          => 'required|integer|min:0',
            'initail_quantity'         => 'nullable|integer|min:0',
            'remainder'                => 'nullable|integer|min:0',
            'recipient'                => 'required|string|max:255',
            'remarks'                  => 'nullable|string',
            'date_issued'              => 'required|date',
            'date_returned'            => 'nullable|date|after_or_equal:date_issued',
        ]);

        $stock = Stock::findOrFail($id);

        $quantityIssued = $validatedData['quantity_issued'];
        $initialQuantity = $validatedData['initail_quantity'] ?? $stock->quantity;
        $remainder = $validatedData['remainder'] ?? ($initialQuantity - $quantityIssued);
        $recipient = $validatedData['recipient'];
        $remarks = $validatedData['remarks'] ?? null;
        $dateIssued = $validatedData['date_issued'];
        $dateReturned = $validatedData['date_returned'] ?? null;
        $issuedBy = Auth()->user()->name;

        if ($quantityIssued > $stock->quantity) {
            return redirect()->back()->with('error', 'Issued quantity exceeds available stock.');
        }

        // Update stock quantity
        $stock->quantity = $remainder;
        $stock->save();

        // Save to stock_out table
        \DB::table('stock_out')->insert([
            'stock_id' => $stock->id,
            'quantity_issued' => $quantityIssued,
            'initial_quantity' => $initialQuantity,
            'remaining_quantity' => $remainder,
            'issued_to' => $recipient,
            'notes' => $remarks,
            'date_issued' => $dateIssued,
            'date_returned' => $dateReturned,
            'issued_by' => $issuedBy,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Stock out recorded successfully.');
        } catch (Exception $e) {
            //throw $th;
            return redirect()->back()->with('error', 'An error occurred while recording stock out.');
            Log::error('Error recording stock out: ' . $e->getMessage());
        }   
    }

    public function stockTransactionList($id)
    {
        $stock = Stock::with(['stockIns', 'stockOuts'])->findOrFail($id);


        return view('backend.inventory.transactionlist', compact('stock'));
    }

    public function generateStockPurchaseSlip()
    {
        $stocks = Stock::all();

        return view('backend.inventory.stockpurchaseslip', compact('stocks'));
    }
}
