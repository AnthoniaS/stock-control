<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'user' => 'nullable|string|max:100'
        ]);

        $movement = new Movement($request->all());
        $movement->save();

        $product = Product::find($request->product_id);

        if ($request->type === 'in') {
            $product->stock += $request->quantity;
        } else {
            if ($product->stock < $request->quantity) {
                return back()->withErrors(['quantity' => 'Not enough stock available.']);
            }
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
