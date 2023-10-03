<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewOrderNotification;
use App\Notifications\OrderNotification;
use Illuminate\Support\Facades\Notification as LaravelNotification; // Alias para el facade de notificaciones
use App\Models\Notification as AppNotification; // Alias para tu modelo Notification

class CheckoutController extends Controller
{
    public function index()
    {
        // Obtener los detalles del carrito
        $cartitems = $this->getCartDetails();

        // Calcular el total del carrito
        $total = $this->calculateTotal($cartitems);

        // Comprueba si hay productos en el carrito antes de mostrar la vista
        if ($cartitems->count() > 0) {
            return view('frontend.checkout', compact('cartitems', 'total'));
        } else {
            // Si no hay productos en el carrito, redirige o muestra un mensaje de error
            return redirect()->route('cart.viewcart')->with('error', 'El carrito está vacío.');
        }
    }

    private function calculateTotal($cartitems)
    {
        $total = 0;

        foreach ($cartitems as $item) {
            $total += ($item->products->selling_price * $item->prod_qty);
        }

        return $total;
    }

    private function getCartDetails()
    {
        return Cart::where('user_id', Auth::id())->with('products')->get();
    }

    public function placeorder(Request $request)
    {

        $order = new Order();
        $order->user_id = Auth::id();
        $order->fname = $request->input('fname');
        $order->lname = $request->input('lname');
        $order->email = $request->input('email');
        $order->phone = $request->input('phone');
        $order->address1 = $request->input('address1');
        $order->address2 = $request->input('address2');
        $order->city = $request->input('city');
        $order->state = $request->input('state');
        $order->country = $request->input('country');
        $order->pincode = $request->input('pincode');

        $order->payment_mode = $request->input('payment_mode');
        $order->payment_id = $request->input('payment_id');

        $total = 0;
        $cartitems_total = Cart::where('user_id', Auth::id())->get();

        foreach ($cartitems_total as $prod) {
            $total += $prod->products->selling_price * $prod->prod_qty;
        }

        $order->total_price = $total;

        $order->tracking_no = 'sharma' . rand(1111, 9999);
        $order->save();

        $cartitems = Cart::where('user_id', Auth::id())->get();

        $pedidoUsuario = Order::where('user_id', Auth::id())->count() + 1;

        foreach ($cartitems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'prod_id' => $item->prod_id,
                'qty' => $item->prod_qty,
                'price' => $item->products->selling_price,
            ]);
            $prod = Product::where('id', $item->prod_id)->first();
            $prod->qty = $prod->qty - $item->prod_qty;
            $prod->update();

            $order->tracking_no = 'sharma' . $pedidoUsuario . rand(1111, 9999);
        }

        if (
            Auth::user()->name !== $request->input('name') ||
            Auth::user()->lname !== $request->input('lname') ||
            Auth::user()->phone !== $request->input('phone') ||
            Auth::user()->address1 !== $request->input('address1') ||
            Auth::user()->address2 !== $request->input('address2') ||
            Auth::user()->city !== $request->input('city') ||
            Auth::user()->state !== $request->input('state') ||
            Auth::user()->country !== $request->input('country') ||
            Auth::user()->pincode !== $request->input('pincode')
        ) {
            $user = User::where('id', Auth::id())->first();
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
        }

        $notification = new AppNotification(); // Usar el alias para tu modelo Notification
        $notification->user_id = Auth::id(); // El ID del usuario que realizó el pedido
        $notification->order_id = $order->id; // El ID del pedido
        $notification->message = 'Se ha realizado un nuevo pedido.'; // Puedes personalizar este mensaje
        $notification->save();

        $cartitems = Cart::where('user_id', Auth::id())->get();
        Cart::destroy($cartitems);

        // Enviar notificaciones
        $this->sendOrderNotifications($order);

        if ($request->input('payment_mode') == "Paid by Razorpay" || $request->input('payment_mode') == "Paid by Paypal") {
            return response()->json(['status' => 'Order placed Successfully']);
        }

        return redirect('/')->with('status', 'Order placed Successfully');
    }

    private function sendOrderNotifications($order)
    {
        // Enviar notificación al administrador
        $admin = User::where('role_as', '1')->first();
        LaravelNotification::send($admin, new NewOrderNotification($order));

        // Enviar notificación al usuario
        $user = Auth::user();
        LaravelNotification::send($user, new OrderNotification($order));
    }

    public function razorpaycheck(Request $request)
    {
        $cartitems = Cart::where('user_id', Auth::id())->get();
        $total_price = 0;

        foreach ($cartitems as $item) {
            $total_price += $item->products->selling_price * $item->prod_qty;
        }

        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $address1 = $request->input('address1');
        $address2 = $request->input('address2');
        $city = $request->input('city');
        $state = $request->input('state');
        $country = $request->input('country');
        $pincode = $request->input('pincode');

        return response()->json([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'phone' => $phone,
            'address1' => $address1,
            'address2' => $address2,
            'city' => $city,
            'state' => $state,
            'country' => $country,
            'pincode' => $pincode,
            'total_price' => $total_price,
        ]);
    }
}
