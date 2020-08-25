<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use App\Product;
use Session;

class ShoppingController extends Controller
{
    public function add_to_cart()
    {

      $pdt = Product::find(request()->pdt_id);

      $cartItem = Cart::add([

        'id' => $pdt->id,
        'name' => $pdt->name,
        'qty' => request()->qty,
        'price' => $pdt->price,

      ]);

      Cart::associate($cartItem->rowId, 'App\Product');

      Session::flash('success', 'Product has been added to the cart');

      return Redirect(route('cart'));
    }


    public function cart()
    {

      return view('cart');
    }


    public function cart_delete($pdt)
    {
      Cart::remove($pdt);
      return redirect()->back();
    }


    public function increase($pdt, $qty)
    {
      Cart::update($pdt, $qty + 1);

      Session::flash('success', 'Product has been added ');

      return redirect()->back();
    }


    public function decrease($pdt, $qty)
    {
      Cart::update($pdt, $qty - 1);

      Session::flash('success', 'Product has been deleted');

      return redirect()->back();
    }


    public function quick_add($pdt)
    {
      $pdt = Product::find($pdt);

      $cartItem = Cart::add([

        'id' => $pdt->id,
        'name' => $pdt->name,
        'qty' => 1,
        'price' => $pdt->price,

      ]);

      Cart::associate($cartItem->rowId, 'App\Product');

      Session::flash('success', 'Product has been added');

      return Redirect(route('cart'));
    }
}
