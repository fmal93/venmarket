<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
// use App\Cupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        if (!Session::has('cart')) {
            return view('payment.cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        return view('payment.cart', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice]);
        
    }

    public function getAddToCart(Request $request, $id) 
    {
        $product = Product::findOrFail($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        if ($cart->items != null && array_key_exists($id, $cart->items) && $cart->items[$id]['qty'] >= $product->productValue->productStock->stock) {
            return redirect('/carrito')->with('status', 'Cantidad supera el Stock Disponible');
        }
        $cart->add($product, $product->id);

        Session::put('cart', $cart);
        return back();
    }

    public function getRemoveItem($id) 
    {
        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        if ($cart->items && array_key_exists($id, $cart->items)){
            $cart->removeItem($id);
        }
        

        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        }else {
            Session::forget('cart');
        }
        
        return redirect('/carrito');
    }

    public function getupdateItem(Request $request) 
    {
        $id = $request->input('id');
        $qty = $request->input('qty');
        $product = Product::find($id);
        $stock = $product->productValue->productStock->stock;
        $oldCart = Session::has('cart') ? Session::get('cart') : null; 
        $cart = new Cart($oldCart);
        $cart->updateItem($product, $id, $qty, $stock);

        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
        }else {
            Session::forget('cart');
        }

        return redirect('/carrito');
    }

    public function getAddManyItem(Request $request) 
    {
        $id = $request->input('id');
        $qty = $request->input('qty');
        $product = Product::find($id);
        $extra_cost_exist = $product->extraCost != null ? $product->extraCost->cargo : 0;
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        if ($cart->items != null && array_key_exists($id, $cart->items) && $cart->items[$id]['qty'] >= $product->productStokc->stock) {
            return redirect()->route('cart.index')->with('status', 'Cantidad supera el Stock Disponible');
        }
        $cart->addManyItem($product, $id, $qty, $extra_cost_exist);

        Session::put('cart', $cart);
        
        return redirect()->route('cart.index');
    }

    public function getDiscountItems(Request $request) {
        // sacar informacion del cupon de la base de datos
        $cupon = Cupon::where('token', $request->input('c_cupon'))->first();
        // si el codigo no existe en la base de datos
        if (!$cupon) {
            return redirect()->route('cart.index')->with('status', 'cupon invalido');
        }
        // si el cupon si existe, sacar todos los productos asociados con ese cupon de la base de datos
        $cupon_products = Product::where('cupon_id', $cupon->id)->get();
        // obtener la informacion del carrito en la sesion si existe
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        // variable donde se guardara los articulos con descuento que se encuentran en el carrito actual
        $items_on_discount = [];
        // loop de cada uno de los productos asociados al cupon comparandolos con los productos en el carro 
        foreach ($cupon_products as $item){
            // si existe el producto en el carrito
            if (array_key_exists($item['id'], $oldCart->items)){
                // se añade a la variable
                array_push($items_on_discount, $item);
            }
        }
        // si ell array esta vacio el cupon no aplica para los productos actualmente en el carrito
        if (!$items_on_discount) {
            return redirect()->route('cart.index')->with('status', 'ninguno de los articulos en la bolsa aplican con este codigo'); 
        }
        // si ya se ha aplicado un cupon no acepta otro
        if ($oldCart->cupon_applied === true) {
            return redirect()->route('cart.index')->with('status', 'Cupon ya aplicado');
        }
        // recrear el carro para el constructor
        $cart = new Cart($oldCart);
        foreach ($items_on_discount as $item_on_discount){
            $cart->discountItems($cupon, $item_on_discount);
        }        
        Session::put('cart', $cart);
        return redirect()->route('cart.index')->with('status', 'cupon aplicado correctamente');   
    }
}
