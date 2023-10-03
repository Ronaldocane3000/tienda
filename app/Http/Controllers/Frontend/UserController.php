<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(){
        $orders = Order::where('user_id', Auth::id())->paginate(2);
        return view('frontend.orders.index' ,compact('orders'));
    }

    public function search(Request $request){
        $perPage = 2; // Número de pedidos por página
        $search = $request->input('search');

        // Consulta de búsqueda
        $query = Order::where('user_id', Auth::id());

        if (!empty($search)) {
            // Agrega condiciones de búsqueda según tus necesidades
            $query->where(function ($subquery) use ($search) {
                $subquery->where('tracking_no', 'like', "%$search%")
                    ->orWhere('total_price', 'like', "%$search%")
                    ->orWhere('status', 'like', "%$search%");
            });
        }

        $orders = $query->paginate($perPage);

        if ($request->ajax()) {
            return view('frontend.orders.search', compact('orders'))->render();
        }

        return view('frontend.orders.index', compact('orders', 'search'));
    }

    public function view($id){
        $orders = Order::with('orderitems')->where('id', $id)->where('user_id', Auth::id())->first();
        return view('frontend.orders.view', compact('orders'));
    }
}
