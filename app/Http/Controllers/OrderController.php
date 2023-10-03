<?php

namespace App\Http\Controllers;

use App\Models\Notification as ModelsNotification;
use App\Models\Order;
use App\Notifications\OrderStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification as NotificationsNotification;
use App\Models\Notification;
class OrderController extends Controller
{
    public function index(Request $request)
    {
        $notifications = Notification::where('is_seen', false)->get();
        $notificationsCount = $notifications->count();
        $perPage = 2; // Número de pedidos por página
        $search = $request->input('search');
    
        // Consulta de búsqueda
        $query = Order::query();
    
        if (!empty($search)) {
            $query->where(function ($subquery) use ($search) {
                $subquery->where('tracking_no', 'like', "%$search%")
                    ->orWhere('total_price', 'like', "%$search%")
                    ->orWhere('status', 'like', "%$search%");
            });
        }
    
        $orders = $query->paginate($perPage);
    
        if ($request->ajax()) {
            return view('admin.orders.search', compact('orders','notifications','notificationsCount'))->render();
        }
    
        return view('admin.orders.index', compact('orders', 'search','notifications','notificationsCount'));
    }

    
    public function search(Request $request)
{
    $perPage = 2; // Número de pedidos por página
    $search = $request->input('search');

    $query = Order::query();

    if (!empty($search)) {
        $query->where(function ($subquery) use ($search) {
            $subquery->where('tracking_no', 'like', "%$search%")
                ->orWhere('total_price', 'like', "%$search%")
                ->orWhere('status', 'like', "%$search%");
        });
    }

    $orders = $query->paginate($perPage);

    return view('admin.orders.search', compact('orders'))->render();
}

public function view($id){
    $orders = Order::find($id);

    $notification= Notification::find($id);
    if ($notification) {
        // Verificar si la notificación no ha sido vista
        if (!$notification->is_seen) {
            // Marcar la notificación como vista
            $notification->update(['is_seen' => true]);
        }

        // Recalcular el contador de notificaciones no vistas
        $notifications = Notification::where('is_seen', false)->get();
        $notificationsCount = $notifications->count();

        return view('admin.orders.view', compact('orders', 'notificationsCount', 'notifications'));
    }
    
    // Manejar el caso en que no se encuentre el pedido
    // Aquí puedes mostrar un mensaje de error o redirigir a otra página
}


    public function updateorder(Request $request, $id)
    {
        $order = Order::find($id);
    
        if (!$order) {
            return redirect('orders')->with('error', 'Order not found.');
        }
    
        $user = $order->user;
    
        if ($user) {
            $newStatus = $request->input('order_status');
            $order->status = $newStatus;
            $order->update();
    
            // Enviar notificación de cambio de estado al usuario
            $user->notify(new OrderStatusNotification($order));
    
            return redirect('orders')->with('status', 'Order Updated Successfully');
        } else {
            return redirect('orders')->with('error', 'User not found for this order.');
        }
    }
    

    public function orderhistory(){

        $notifications = Notification::where('is_seen', false)->get();
        $notificationsCount = $notifications->count();
        $orders = Order::where('status', '1')->get();
        return view('admin.orders.history', compact('orders','notifications','notificationsCount'));
    }

}
