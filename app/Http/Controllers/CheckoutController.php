<?php

namespace App\Http\Controllers;
require_once '../vendor/autoload.php';

use Illuminate\Http\Request;
use Transbank\Webpay\WebpayPlus\Transaction;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use App\Models\Preorder;
use App\Models\Comuna;
use App\Models\Order;
use App\Models\ProductStock;
use App\Models\Product;
use App\Models\WebpayToken;
use Illuminate\Support\Facades\Mail;
use App\Mail\orderPlaced;

class CheckoutController extends Controller
{
    public function getCheckoutForm() {
        if (!Session::has('cart')) {
            return view('payment.cart');
        }
        $cart = Session::get('cart');
        
        $total = $cart->totalPrice; 

        return view('payment.checkoutForm', ['total' => $total]);
    }

    public function initTransaction(Request $request)
    {
        $request->validate([
            'c_nombre' => 'required|max:255',
            'c_telefono' => 'required|regex:/^[\+0-9\-\(\)\s]*$/||min:9',
            'c_email' => 'required|email:rfc,dns',
            'c_direccion' => 'required',
            'c_region' => 'required',
            'c_comuna' => 'required',
        ]);
        if (!Session::has('cart')) {
            return view('payment.cart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $total = $request->c_amount;
        $amount = $total;
        // Identificador que será retornado en el callback de resultado:
        $session_id = "venmarket-id";
        // Identificador único de orden de compra:
        $buy_order = strval(rand(100000, 999999999));
        $return_url = "http://localhost:8000/checkout-return";

        $response = Transaction::create($buy_order, $session_id, $amount, $return_url);

        $response_url = $response->getUrl();
        $response_token = $response->getToken();

        $p_cart = $cart->items;
        $serialized_items = serialize($p_cart); 
        $p_datos = serialize($request->toArray());
        $PreOrder = new Preorder;
        $PreOrder->buyOrder = $buy_order;
        $PreOrder->cart = $serialized_items;
        $PreOrder->datos = $p_datos;
        $PreOrder->tokenWS	 = $response_token;
        $PreOrder->save();

        return view('payment.checkout', ['url' => $response_url, 'token' => $response_token]);
    }

    public function confirmTransaction(Request $request)
    {
        if ($request->TBK_TOKEN) {
            $token_anulacion = $request->TBK_TOKEN;            
            $this->restoreCart($token_anulacion);            
            $oldCart = Session::has('cart') ? Session::get('cart') : null;
            $cart = new Cart($oldCart);
            return redirect('/carrito');
        }else{
            $token = $request->token_ws;
            $response = Transaction::commit($token);

            if ($response->getResponseCode() == 0) {
                $this->CreateWebpayToken($response, $token); 
                $preOrder = Preorder::where('tokenWS', $token)->firstOrFail();
                $tems_cart = unserialize($preOrder->cart);
                $item_names = [];
                $items_qty = [];
                foreach ($tems_cart as $item) {
                    array_push($item_names, $item['item']['name']);
                    array_push($items_qty, $item['qty']);
                    $stock = $item['item']['productValue']['productStock']['stock'] - $item['qty'];
                    ProductStock::findOrFail($item['item']['productValue']['productStock']['id'])->update(['stock' => $stock]);     
                }
                $items_names_implode = implode(",", $item_names);
                $items_qty_implode = implode(",",$items_qty);  
                $unser_datos = unserialize($preOrder->datos); 
                $this->CreateOrder($response, $unser_datos, $items_qty_implode, $items_names_implode);
                Mail::send(new OrderPlaced($tems_cart, $unser_datos, $response->getBuyOrder()));
                Mail::to($unser_datos['c_email'])->send(new OrderPlaced($tems_cart, $unser_datos, $response->getBuyOrder()));
                $preOrder->delete();
                return view('payment.checkout-return',  ['status' => 'Orden completa', 'response' => $response]);
            }

            $this->CreateWebpayToken($response, $token);
            $this->restoreCart($token);  
            return view('payment.checkout-return')->with('status', 'Ha ocurrido un error');
        }
    }

    public function restoreCart($token)
    {
        $preOrder_anulacion = Preorder::where('tokenWS', $token)->firstOrFail();
        $items_in_cart = unserialize($preOrder_anulacion->cart);
        foreach ($items_in_cart as $item){            
            $oldCart = Session::has('cart') ? Session::get('cart') : null;
            $cart = new Cart($oldCart);
            $product = Product::find($item['item']['id']);
            $cart->restoreCart($item['item'], $item['item']['id'], $item['qty']);
            Session::put('cart', $cart);
        }
        $preOrder_anulacion->delete();
    }

    public function CreateWebpayToken($response, $token)
    {
        $wpToken = new WebpayToken;
        $wpToken->buyOrder = $response->getBuyOrder();
        $wpToken->tokenWs = $token;
        $wpToken->authorizationCode = $response->getAuthorizationCode() . " TIPODEPAGO " . $response->getPaymentTypeCode();
        $wpToken->responseCode = $response->getResponseCode();
        $wpToken->amount = $response->getAmount(). " CUOTAS " . $response->getInstallmentsNumber() . " " .  $response->getInstallmentsAmount();
        $wpToken->save();  
    }

    public function CreateOrder($response, $unser_datos, $items_qty_implode, $items_names_implode)
    {
        $ordenFinal = new Order;
        $ordenFinal->buyOrder = $response->getBuyOrder();
        $ordenFinal->status = $response->getResponseCode();
        $ordenFinal->items = $items_names_implode; 
        $ordenFinal->cantidad = $items_qty_implode;
        $ordenFinal->total = $response->getAmount();
        $ordenFinal->nombre = $unser_datos['c_nombre'];
        $ordenFinal->telefono = $unser_datos['c_telefono'];
        $ordenFinal->email = $unser_datos['c_email'];
        $ordenFinal->direccion = $unser_datos['c_direccion'];
        $ordenFinal->region = $unser_datos['c_region'];
        $ordenFinal->comuna = Comuna::findOrFail($unser_datos['c_comuna'])->name;
        $ordenFinal->save();  
    }
}

