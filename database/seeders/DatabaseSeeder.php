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

    $promptTypes = [
      [
        'name' => "Description de l'entreprise",
        'order' => 1
      ],
      [
        'name' => "Activité principale de l'entreprise",
        'order' => 2
      ],
      [
        'name' => 'Services ou produits vendus',
        'order' => 3
      ]
    ];

    foreach ($promptTypes as $item) {
      \App\Models\PromptType::factory()->create($item);
    }

    ///

    $prompts = [
      [
        'name' => "Description de l'entreprise [nom de l'entreprise]",
        "type" => "Description de l'entreprise",
        'order' => 1
      ],
      [
        'name' => "Description de 100 mots sur l'entreprise [nom de l'entreprise]",
        "type" => "Description de l'entreprise",
        'order' => 2
      ],
      [
        'name' => "Description de 100 mots sur l'entreprise [nom de l'entreprise] de pays nom de pays]",
        "type" => "Description de l'entreprise",
        'order' => 3
      ]
    ];

    foreach ($prompts as $item) {
      \App\Models\Prompt::factory()->create($item);
    }

    ///

    $expectedFunctions = [
      [
        'name' => 'Formulaire de contact',
        'alias' => 'contact_form',
        'order' => 1
      ],
      [
        'name' => 'Blog',
        'alias' => 'Fcontact_form',
        'order' => 2
      ],
      [
        'name' => 'Backoffice',
        'alias' => 'blogoffice',
        'order' => 3
      ],
      [
        'name' => 'Géolocalisation',
        'alias' => 'backoffice',
        'order' => 4
      ],
      [
        'name' => 'Capture des leads',
        'alias' => 'lead_capture',
        'order' => 5
      ],
      [
        'name' => 'Plugins sur mesure',
        'alias' => 'custom_plugins',
        'order' => 6
      ],
      [
        'name' => 'Besoin des APIs',
        'alias' => 'api_requirements',
        'order' => 7
      ],
      [
        'name' => 'Calendly',
        'alias' => 'calendly',
        'order' => 8
      ]
      ,
      [
        'name' => 'Chatbotai',
        'alias' => 'chatbotai',
        'order' => 8
      ]
      ,
      [
        'name' => 'Google Analytics',
        'alias' => 'google_analytics',
        'order' => 8
      ]
      ,
      [
        'name' => 'Réseaux sociaux',
        'alias' => 'social_media',
        'order' => 8
      ]
    ];

    foreach ($expectedFunctions as $item) {
      \App\Models\ExpectedFunction::factory()->create($item);
    }

    ///

    $users = [
      [
        'name' => 'Taha SRH',
        'email' => 'tahasrhdev@gmail.com',
      ], [
        'name' => 'Khadija',
        'email' => 'arjane.khadija97@gmail.com',
      ]
    ];

    foreach ($users as $item) {
      \App\Models\User::factory()->create($item);
    }
  }
}
