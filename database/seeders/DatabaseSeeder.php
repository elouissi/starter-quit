<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    // \App\Models\User::factory(10)->create();

    \App\Models\User::factory()->create([
      'name' => 'Taha SRH',
      'email' => 'tahasrhdev@gmail.com',
    ]);

    \App\Models\User::factory()->create([
      'name' => 'Khadija',
      'email' => 'arjane.khadija97@gmail.com',
    ]);

    // \App\Models\User::factory()->create([
    //     'name' => 'Taha SRH',
    //     'email' => 'tahasrhdev@gmail.com',
    // ]);
  }
}
