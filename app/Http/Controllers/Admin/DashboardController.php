<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function users(Request $request)
    {

        $notifications = Notification::where('is_seen', false)->get();
        $notificationsCount = $notifications->count();
        $perPage = 2; // Número de categorías por página
        $search = $request->input('search');

        // Consulta de búsqueda
        $query = User::query();

        if (!empty($search)) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('phone', 'like', "%$search%");
        }

        $users = $query->paginate($perPage);

        if ($request->ajax()) {
            return view('admin.users.search', compact('users', 'notifications', 'notificationsCount'))->render();
        }

        return view('admin.users.index', compact('users', 'search', 'notifications', 'notificationsCount'));
    }

    public function search(Request $request)
    {
        $perPage = 2;
        $search = $request->input('search');

        $query = User::query();

        if (!empty($search)) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('phone', 'like', "%$search%");
        }

        $users = $query->paginate($perPage);

        return view('admin.users.search', compact('users'))->render();
    }


    public function viewuser($id)
    {

        $notifications = Notification::where('is_seen', false)->get();
        $notificationsCount = $notifications->count();
        $users = User::find($id);
        return view('admin.users.view', compact('users','notifications', 'notificationsCount'));
    }
}
