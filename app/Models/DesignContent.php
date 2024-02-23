<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DesignContent extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = ['specification_id', 'content', 'style_graphiques', 'style_graphique_autre', 'number_of_propositions', 'color_palette', 'typography', 'exemples_sites', 'exemples_sites_files'];

  protected $casts = [
    'style_graphiques' => 'json',
    'exemples_sites_files' => 'json',
  ];

  public function specification()
  {
    return $this->belongsTo(Specification::class);
  }
}
