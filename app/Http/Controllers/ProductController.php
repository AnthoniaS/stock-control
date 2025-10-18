<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use App\HTTP\Requests\StoreProductRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $categoryId = $request->get('category_id');
    
        $products = Product::when($search, function($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->when($categoryId, function($query, $categoryId) {
                return $query->where('category_id', $categoryId);
            })
            ->orderBy('name', 'asc')
            ->get();
    
        $categories = Category::orderBy('name')->get();
    
        return view('products.index', compact('products', 'search', 'categories', 'categoryId'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')){
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/products', $filename);
            $data['photo'] = $filename;
        }
        Product::create($data);
        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(StoreProductRequest $request, Product $product)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')){
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/products', $filename);
            $data['photo'] = $filename;
        }
        $product->update($data);
        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }

    public function stockReport()
    {
        $products = Product::with('category')->get();

        return view('products.stock_report', compact('products'));
    }

    public function topExits()
    {
        $products = Product::withCount(['movements as exits_count' => function($query) {
            $query->where('type', 'exit');
        }])->orderByDesc('exits_count')->take(10)->get();

        return view('products.top_exits', compact('products'));
    }

    public function downloadPdf()
    {
        $products = Product::all();

        $pdf = Pdf::loadView('products.stock_pdf', compact('products'));
        return $pdf->download('stock-report.pdf');
    }
}
