<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specification extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = ['entreprise_name', 'contact_person', 'phone', 'email', 'description', 'main_activities', 'services_products', 'target'];

  public function objectif_site()
  {
    return $this->hasOne(ObjectifSite::class);
  }

  public function existing_analysis()
  {
    return $this->hasOne(ExistingAnalysis::class);
  }

  public function design_content()
  {
    return $this->hasOne(DesignContent::class);
  }

  public function deadline_and_budget()
  {
      return $this->hasOne(DeadlineAndBudget::class);
  }

  public function facturation()
  {
      return $this->hasOne(Facturation::class);
  }
}
