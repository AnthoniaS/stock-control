<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Movement;
use App\HTTP\Requests\StoreMovementRequest;
use Illuminate\Support\Facades\DB;

class MovementController extends Controller
{

    public function index()
    {
        $movements = Movement::with('product')->latest()->get();
        return view('movements.index', compact('movements'));
    }
    public function create()
    {
        $products = Product::all();
        return view('movements.create', compact('products'));
    }

    public function store(StoreMovementRequest $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'type' => 'required|in:entry,exit',
                'quantity' => 'required|integer|min:1',
            ]);
        
            DB::transaction(function () use ($request) {
                $product = Product::lockForUpdate()->find($request->product_id);
        
                if ($request->type === 'exit') {
                    if ($product->stock < $request->quantity) {
                        throw new \Exception('Not enough stock available.');
                    }
                    $product->stock -= $request->quantity;
                } else {
                    $product->stock += $request->quantity;
                }
        
                $product->save();
        
                Movement::create([
                    'product_id' => $product->id,
                    'type' => $request->type,
                    'quantity' => $request->quantity,
                    'user' => auth()->user()->name ?? 'Unknown',
                ]);
            });
            return redirect()->route('movements.index')->with('success', 'Movement recorded successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
