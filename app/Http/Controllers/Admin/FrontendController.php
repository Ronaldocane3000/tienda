<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Asegúrate de importar Carbon

class FrontendController extends Controller
{
  
    public function index()
    {
        $categories = Category::count();
        $products = Product::count();
        $users = User::count();
        $orders = Order::count();
        $notifications = Notification::where('is_seen', false)->get();
        $notificationsCount = $notifications->count();
        $orders_completed = Order::where('status', 1)->count();
        $orders_pending = Order::where('status', 0)->count();
        $userRegistrationsData = $this->getUserRegistrationsLast30Days();
        $productsAddedLast7Days = $this->getProductsAddedLast7Days();
        $ordersLast30Days = $this->getOrdersLast30Days();
        $dailyEarningsLast30Days = $this->getDailyEarningsLast30Days();

       
        return view('admin.index', compact(
            'products',
            'categories',
            'users',
            'orders',
            'orders_completed',
            'orders_pending',
            'userRegistrationsData',
            'productsAddedLast7Days',
            'ordersLast30Days',
            'dailyEarningsLast30Days',
            'notifications',
            'notificationsCount'
        ));


    }

    // Función para obtener datos de Usuarios Registrados en el último mes
    public function getUserRegistrationsLast30Days()
    {
        $startDate = Carbon::now()->subDays(30); // Fecha de inicio hace 30 días
        $endDate = Carbon::now(); // Fecha de finalización (hoy)

        $data = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Formatear los datos para que se ajusten al gráfico
        $formattedData = $data->map(function ($item) {
            return [
                'date' => $item->date,
                'count' => $item->count,
            ];
        });
        
        return $formattedData;
    }

    // Función para obtener datos de Productos Agregados en los Últimos 7 Días
    public function getProductsAddedLast7Days()
    {
        $startDate = Carbon::now()->subDays(7); // Fecha de inicio hace 7 días
        $endDate = Carbon::now(); // Fecha de finalización (hoy)

        $data = Product::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Formatear los datos para que se ajusten al gráfico
        $formattedData = $data->map(function ($item) {
            return [
                'date' => $item->date,
                'count' => $item->count,
            ];
        });
        
        return $formattedData;
    }

    // Función para obtener datos de Pedidos Realizados en los Últimos 30 Días
    public function getOrdersLast30Days()
    {
        $startDate = Carbon::now()->subDays(30); // Fecha de inicio hace 30 días
        $endDate = Carbon::now(); // Fecha de finalización (hoy)

        $data = Order::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Formatear los datos para que se ajusten al gráfico
        $formattedData = $data->map(function ($item) {
            return [
                'date' => $item->date,
                'count' => $item->count,
            ];
        });
        
        return $formattedData;
    }

    // Función para obtener datos de Ganancias Diarias en un Período de 30 Días
    public function getDailyEarningsLast30Days()
    {
        $endDate = Carbon::now(); // Fecha de finalización (hoy)
        $startDate = $endDate->copy()->subDays(29); // Fecha de inicio hace 30 días

        $data = Order::selectRaw('DATE(created_at) as date, SUM(total_price) as earnings')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Formatear los datos para que se ajusten al gráfico
        $formattedData = $data->map(function ($item) {
            return [
                'date' => $item->date,
                'earnings' => $item->earnings,
            ];
        });
        
        return $formattedData;
    }

    public function indexProfileA(){

        return view('admin.updateA');
    }


    public function updateProfileA(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->input('fname');
        $user->lname = $request->input('lname');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->address1 = $request->input('address1');
        $user->address2 = $request->input('address2');
        $user->city = $request->input('city');
        $user->state = $request->input('state');
        $user->country = $request->input('country');
        $user->pincode = $request->input('pincode');
        $user->update();

        return redirect('my-profileA')->with('status', "Profile Update Successfully");
    }

   

    
}
