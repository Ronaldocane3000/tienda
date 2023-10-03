<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;
    protected $order; 

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $order = $this->order;
        $userName = $order->user->name;
        $Status = $order->status == 0 ? 'Pendiente' : 'Completado';
    
        // Obtener los detalles del producto y la cantidad desde OrderItem
        $orderItems = $order->orderitems;
        $productDetails = [];
    
        foreach ($orderItems as $orderItem) {
            $product = $orderItem->products;
            $productDetails[] = [
                'Nombre_Producto' => $product->name,
                'Cantidad' => $orderItem->qty,
            ];
        }
    
        $mailMessage = (new MailMessage)
            ->line("Hello! Se ha recibido un nuevo pedido del cliente $userName")
            ->line('Detalles del pedido:')
            ->line('Nombre del Producto: ' . $productDetails[0]['Nombre_Producto'])
            ->line('Cantidad: ' . $productDetails[0]['Cantidad']) // Esto mostrará los detalles del primer producto
            ->line('Pagar: ' . $order->total_price)
            ->line('Método de pago: ' . $order->payment_mode)
            ->line('Estado del pedido: ' . $Status)
            ->action('Ver detalle del pedido', url('/admin/view-order/' . $order->id))
            ->line('Gracias por utilizar nuestra aplicación!');
    
        return $mailMessage;
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
