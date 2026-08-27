<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductController extends Controller
{
    public function products()
    {
        $products = Product::with(['category', 'brand'])->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.products', compact('products'));
    }

    public function productAdd(){
        $categories = Category::select('id', 'name')->orderBy('name', 'asc')->get();
        $brands = Brand::select('id', 'name')->orderBy('name', 'asc')->get();
        return view('admin.product-add', compact('categories', 'brands'));
    }

    public function productStore(Request $request){
        $request->validate([
            'name'              => 'required|string|max:255',
            'slug'              => 'required|string|max:255|unique:products,slug',
            'short_description' => 'nullable|string|max:500',
            'information'       => 'nullable|string',
            'description'       => 'required|string',
            'regular_price'     => 'required|numeric|min:0',
            'sale_price'        => 'nullable|numeric|min:0|lt:regular_price',
            'SKU'               => 'required|string|max:100|unique:products,SKU',
            'stock_status'      => 'required|in:instock,outofstock',
            'quantity'          => 'required|integer|min:0',
            'featured'          => 'boolean',
            'status'            => 'boolean',
            'category_id'       => 'nullable|exists:categories,id',
            'brand_id'          => 'nullable|exists:brands,id',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'images'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
    }
}
