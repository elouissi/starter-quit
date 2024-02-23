<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeadlineAndBudget extends Model
{
  use HasFactory, SoftDeletes;

  protected $table = 'deadlines_and_budgets';

  protected $fillable = ['specification_id', 'gestion_projet', 'communication', 'deadline', 'budget_from', 'budget_to'];

  protected $casts = [
    'communication' => 'json',
  ];



  public function specification()
  {
    return $this->belongsTo(Specification::class);
  }
}
