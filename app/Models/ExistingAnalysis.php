<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExistingAnalysis extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = ['specification_id', 'competitors', 'sample_sites', 'sample_sites_files', 'constraints', 'constraints_files', 'domain', 'domain_name', 'logo', 'logo_file', 'hosting', 'hosting_name'];

  protected $casts = [
    'sample_sites_files' => 'json',
    'constraints_files' => 'json',
  ];

  public function specification()
  {
    return $this->belongsTo(Specification::class);
  }
}
