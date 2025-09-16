<?php

namespace App\Http\Controllers\ProductController;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
//        $this->authorizeResource(Product::class, 'product');
    }

    public function index(Request $request)
    {
        $products = $this->productService->index($request->all());

        $categories =  $this->productService->getProductCategories();

        return view('product.index', [
            'products' => ProductResource::collection($products),
            'categories' => $categories
        ]);
    }

    public function show(Product $product)
    {
        return view('product.show', ['product' => new ProductResource($this->productService->show($product))]);
    }
}
