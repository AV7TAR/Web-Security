<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    // قائمة المنتجات + search
    public function index(Request $request)
    {
        $query = Product::query();

        // بحث بالاسم أو الفئة
        if ($kw = $request->keywords) {
            $query->where(function ($q) use ($kw) {
                $q->where('name', 'like', "%$kw%")
                  ->orWhere('category', 'like', "%$kw%");
            });
        }

        // فلتر بالسعر (اختياري)
        if ($min = $request->min_price) {
            $query->where('price', '>=', $min);
        }
        if ($max = $request->max_price) {
            $query->where('price', '<=', $max);
        }

        $products = $query->orderBy('id', 'desc')->get();

        return view('products.index', compact('products'));
    }

    // فورم إضافة/تعديل منتج
    public function edit(Product $product = null)
    {
        $isNew = $product === null;
        if ($isNew) {
            $product = new Product();
        }

        return view('products.edit', compact('product', 'isNew'));
    }

    // حفظ المنتج
    public function save(Request $request, Product $product = null)
    {
        $isNew = $product === null;
        if ($isNew) {
            $product = new Product();
        }

        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'category'    => ['nullable', 'string', 'max:255'],
            'price'       => ['required', 'numeric', 'min:0'],
            'quantity'    => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
        ]);

        $product->fill($data);
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product saved.');
    }

    // حذف منتج
    public function delete(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted.');
    }
}
