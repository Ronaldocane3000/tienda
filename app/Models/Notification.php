<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications'; // Asegúrate de que coincida con el nombre de tu tabla de notificaciones
    protected $fillable = ['user_id', 'order_id', 'message', 'read', 'is_seen'];
    // Define las relaciones si es necesario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }



}
