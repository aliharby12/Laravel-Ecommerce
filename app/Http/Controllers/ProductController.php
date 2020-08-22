<?php

namespace App\Http\Controllers;

use App\Product;
use Session;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        return view('products.index', ['products' => Product::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'image' => 'required|image'
        ]);

        $product = new Product;

        $product_image = $request->image;

        $product_image_new_name = time() . $product_image->getClientOriginalName();

        $product_image->move('uploads/products', $product_image_new_name);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->image = 'uploads/products/' . $product_image_new_name;

        $product->save();

        Session::flash('success', 'Product created.');

        return redirect(route('products.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */

     public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required'
        ]);

        $product = Product::find($id);

        if($request->hasFile('image'))
        {
            $product_image = $request->image;

            $product_image_new_name = time() . $product_image->getClientOriginalName();

            $product_image->move('uploads/products', $product_image_new_name);

            $product->image = 'uploads/products/' . $product_image_new_name;

            $product->save();
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;


        $product->save();

        Session::flash('success', 'Product updated.');

        return redirect(route('products.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {

        if (file_exists($product->image)) {

            unlink($product->image);

        }

        $product->delete();

        Session::flash('success', 'Product deleted');

        return redirect(route('products.index'));
    }
}
