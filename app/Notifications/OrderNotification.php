<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderNotification extends Notification
{
    use Queueable;
    protected $order; 
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */

     public function toMail($notifiable)
     {
         $order = $this->order;
         $status = $order->status == 0 ? 'Pendiente' : 'Completado';
         $orderItems = $order->orderitems; // Obtener los detalles del pedido desde OrderItem
         $productDetails = [];
 
         foreach ($orderItems as $orderItem) {
             $product = $orderItem->products;
             $productDetails[] = [
                 'Nombre_Producto' => $product->name,
                 'Cantidad' => $orderItem->qty,
             ];
         }
 
         return (new MailMessage)
             ->line('Hola! Ha realizado un pedido: ' . $order->id)
             ->line('Detalles del pedido:')
             ->line('Nombre del Producto: ' . $productDetails[0]['Nombre_Producto'])
             ->line('Cantidad: ' . $productDetails[0]['Cantidad'])
             ->line('Cantidad a pagar: ' . $order->total_price)
             ->line('Método de pago: ' . $order->payment_mode)
             ->line('Estado del pedido: ' . $status)
             ->action('Ver detalle del pedido', url('/view-order/'.$order->id))
             ->line('Gracias por utilizar nuestra aplicación!');
     }


    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
