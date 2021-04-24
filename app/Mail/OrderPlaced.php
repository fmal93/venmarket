<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Comuna;

class OrderPlaced extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'VenMarket Pedido';

    public $order;

    public $datos;

    public $buyOrder;

    public $comuna;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $datos, $buyOrder)
    {
        $this->order = $order;
        $this->datos = $datos;
        $this->buyOrder = $buyOrder;
        $this->comuna = Comuna::find($datos['c_comuna'])->name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('moffera655@gmail.com')->view('payment.order-placed')->withSwiftMessage(function ($message) {
            $message->getHeaders()
                ->addTextHeader('VenMarket Pedido', 'VenMarket Pedido');
        }); 
    }
}
