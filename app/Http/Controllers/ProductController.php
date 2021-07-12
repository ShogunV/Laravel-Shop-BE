<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = ProductResource::collection(Product::all());
        $categories = Category::all();
        return compact('products', 'categories');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $formInput = $request->except('image');
        $formInput['price'] = $formInput['price'] * 100;

        $image = $request->file('image');
        if(!empty($image)){
            $path = $image->store('images');
            $formInput['image'] = $path;
        }

        Product::create($formInput);
        return ProductResource::collection(Product::all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return compact('product');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        $formInput = $request->except('image');
        $formInput['price'] = $formInput['price'] * 100;

        $image = $request->file('image');
        if(!empty($image)){
            $path = $image->store('images');
            $formInput['image'] = $path;
        }

        $product->update($formInput);
        return ProductResource::collection(Product::all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::destroy($id);
        return ProductResource::collection(Product::all());
    }
}
