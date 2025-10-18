<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Movement;
use App\HTTP\Requests\StoreMovementRequest;

class MovementController extends Controller
{

    public function index()
    {
        $movements = Movement::with('product')->latest()->paginate(10);
        return view('movements.index', compact('movements'));
    }
    public function create()
    {
        $products = Product::all();
        return view('movements.create', compact('products'));
    }

    public function store(StoreMovementRequest $request)
    {
        $product = Product::find($request->product_id);

        if ($request->type === 'exit' && $product->stock < $request->quantity) {
            return back()->withErrors(['quantity' => 'Not enough stock available.']);
        }
        
        $movement = new Movement($request->all());
        $movement->save();
        
        if ($request->type === 'in') {
            $product->stock += $request->quantity;
        } else {
            $product->stock -= $request->quantity;
        }
        
        $product->save();
        return redirect()->route('movements.index')->with('success', 'Movement recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
