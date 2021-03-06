<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Section;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:products_index', ['only' => ['index']]);
        $this->middleware('permission:create_product', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit_product', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete_product', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        $sections = Section::all();
        return view('products.index', [
            'products' => $products,
            'sections' => $sections
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        Product::create($request->validated());
        session()->flash('success', __('notifications.success_create_product'));
        return redirect()->route('products.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        session()->flash('success', __('notifications.success_update_product'));
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        session()->flash('success', __('notifications.success_delete_product'));
        return redirect()->route('products.index');
    }
}
