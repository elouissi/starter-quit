<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facturation extends Model
{
  use HasFactory, SoftDeletes;

  protected $guarded = ['id', 'created_at', 'updated_at', 'deleted_at'];

  public function specification()
  {
    return $this->belongsTo(Specification::class);
  }
}
