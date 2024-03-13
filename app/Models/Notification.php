<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
  use HasFactory;

  protected $fillable = ['user_id', 'message', 'pdf_link', 'specification_id', 'read'];

  public function sendNotification($userId, $message,  $pdf_link, $specification_id)
  {
    $notification = new Notification;
    $notification->user_id = $userId;
    $notification->message = $message;
    $notification->pdf_link = $pdf_link;
    $notification->specification_id = $specification_id;
    $notification->read = false;
    $notification->save();
  }

  public function markAsRead()
  {
    $this->read = true;
    $this->save();
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function specification()
  {
    return $this->belongsTo(Specification::class);
  }
}
