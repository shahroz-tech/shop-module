<?php

namespace App\Http\Controllers\Manager\ProductController;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProdctRequest\StoreProductRequest;
use App\Http\Requests\ProdctRequest\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
        $this->authorizeResource(Product::class, 'product');
    }

    public function create(){
        return view('manager.products.create');
    }



    public function edit(Product $product){

        return view('manager.products.edit', compact('product'));
    }

    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->store($request->validated());
        return back()->with('success','Product created successfully');
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product = $this->productService->update($product, $request->validated());
        return back()->with('success','Product updated successfully');

    }

    public function destroy(Product $product)
    {
        $this->productService->destroy($product);
        return back()->with('success','Product deleted successfully');

    }
}
