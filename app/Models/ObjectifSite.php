<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ObjectifSite extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = ['specification_id', 'project_need', 'project_type', 'payment_options', 'languages', 'expected_functions', 'expected_objectives', 'menu'];
  protected $casts = [
    'payment_options' => 'json',
    'languages' => 'json',
    'expected_functions' => 'json',
];
  public function specification()
  {
    return $this->belongsTo(Specification::class);
  }
}
