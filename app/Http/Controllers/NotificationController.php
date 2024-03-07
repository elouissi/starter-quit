<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
  //
  public function index()
  {
    $unreadNotifications = auth()->user()->unreadNotifications;
    $unreadCount = $unreadNotifications->count();

    // Si le nombre de notifications non lues est inférieur à 5
    if ($unreadCount < 5) {
        // Compléter jusqu'à 5 avec les dernières notifications lues
        $readNotifications = auth()->user()->readNotifications()
            ->orderBy('created_at', 'desc')
            ->limit(5 - $unreadCount)
            ->get();

        // Ajouter ces notifications lues à la liste de notifications non lues
        $unreadNotifications = $unreadNotifications->merge($readNotifications);
    }

    return response()->json($unreadNotifications);
  }

  public function markAllAsRead()
  {
    // Récupérer l'utilisateur authentifié
    $user = auth()->user();

    // Marquer toutes les notifications de l'utilisateur comme lues
    $user->unreadNotifications->each(function ($notification) {
      $notification->markAsRead();
    });

    return response()->json(['success' => true]);
  }

  public function markAsRead(Request $request)
  {
    // Marquer une notification spécifique comme lue
    $notification = Notification::find($request->id);
    $notification->read = true;
    $notification->save();

    return response()->json(['success' => true]);
  }
}
