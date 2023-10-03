<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusNotification extends Notification
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
         $newStatus = $order->status == 0 ? 'Pendiente' : 'Completado';
     
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
     
         $message = (new MailMessage)
             ->line("Pedido:$order->id")
             ->line("Estado del Pedido: $newStatus.")
             ->line('Detalles del Pedido:');
     
         foreach ($productDetails as $productDetail) {
             $message->line($productDetail['Nombre_Producto'] . ' - Cantidad: ' . $productDetail['Cantidad']);
         }
     
         $message->action('Ver detalle del pedido', url('/my-order/'.$order->id))
             ->line('Gracias por utilizar nuestra aplicación!');
     
         return $message;
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
