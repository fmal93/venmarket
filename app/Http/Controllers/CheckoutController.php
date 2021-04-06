<?php

namespace App\Http\Controllers;
require_once '../vendor/autoload.php';

use Illuminate\Http\Request;
use Transbank\Webpay\WebpayPlus\Transaction;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use App\Models\Preorder;
use App\Models\Product;

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
        $validatedData = $request->validate([
            'c_nombre' => 'required|max:255',
            'c_telefono' => 'regex:/^[\+0-9\-\(\)\s]*$/',
            'c_email' => 'email',
            'c_direccion' => 'required',
            // 'c_region' => 'required',
            // 'c_comuna' => 'required',
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
            $preOrder_anulacion = Preorder::where('tokenWS', $token_anulacion)->firstOrFail();
            $items_in_cart = unserialize($preOrder_anulacion->cart);
            foreach ($items_in_cart as $item){
                $oldCart = Session::has('cart') ? Session::get('cart') : null;
                $cart = new Cart($oldCart);
                $product = Product::find($item['item']['id']);
                $cart->restoreCart($item['item'], $item['item']['id'], $item['qty']);
                Session::put('cart', $cart);
            }
            $delete_preorder = Preorder::find($preOrder_anulacion->id);
            $delete_preorder->delete();
            $oldCart = Session::has('cart') ? Session::get('cart') : null;
            $cart = new Cart($oldCart);
            return view('payment.cart', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice]);
        }
        $token= $request->token_ws;
        $response = Transaction::commit($token);

        $response->getVci();
        $response->getAmount();
        $response->getStatus();
        $response->getBuyOrder();
        $response->getSessionId();
        $response->getCardDetail();
        $response->getAccountingDate();
        $response->getTransactionDate();
        $response->getAuthorizationCode();
        $response->getPaymentTypeCode();
        $response->getResponseCode();
        $response->getInstallmentsAmount();
        $response->getInstallmentsNumber();
        $response->getBalance();

        return view('payment.checkout-return', ['response' => $response]);
    }

    public function  transactionStatus()
    {
        $response = Transaction::getStatus($token); 
        
        $response->getVci();
        $response->getAmount();
        $response->getStatus();
        $response->getBuyOrder();
        $response->getSessionId();
        $response->getCardDetail();
        $response->getAccountingDate();
        $response->getTransactionDate();
        $response->getAuthorizationCode();
        $response->getPaymentTypeCode();
        $response->getResponseCode();
        $response->getInstallmentsAmount();
        $response->getInstallmentsNumber();
        $response->getBalance();
    }
}
