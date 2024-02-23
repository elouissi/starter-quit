<?php

namespace App\Http\Controllers;

use App\Models\DeadlineAndBudget;
use App\Models\DesignContent;
use App\Models\ExistingAnalysis;
use App\Models\ExpectedFunction;
use App\Models\ObjectifSite;
use App\Models\Specification;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;

// use Image;

class SpecificationsController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
    return view('content.specifications.index');
  }

  public function indexDataTable()
  {

    return DataTables::of(Specification::query())
      ->addColumn(
        'actions',
        function ($item) {
          return '<a class="btn btn-icon btn-primary text-white" target="_blank" href="specifications/' . $item->id . '" data-id="' . $item->id . '">
                    <i class="ti ti-file-invoice"></i>
                </a>';
        }
      )
      ->rawColumns(['actions'])
      ->make(true);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
    $expected_functions = ExpectedFunction::orderBy('order')->get();
    return view('content.specifications.create', compact('expected_functions'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $specification = Specification::with('objectif_site', 'existing_analysis', 'design_content', 'deadline_and_budget')->findOrFail($id);
    // return response()->json($specification);

    $pdf = PDF::loadView('content.pdf.index', compact('specification'));
    // return $pdf->stream('pdf.pdf');
    return $pdf->download('pdf.pdf');
  }


  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }

  // STEP 1 //
  public function storestep1(Request $request)
  {
    if ($request->ajax()) {
      $validator = Validator::make($request->all(), [
        'entreprise_name' => 'required|string|max:255',
        'contact_person' => 'required|string|max:255',
        'phone' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'prompt_description' => 'nullable|string',
        'description' => 'nullable|string',
        'prompt_main_activities' => 'nullable|string',
        'main_activities' => 'nullable|string',
        'prompt_services_products' => 'nullable|string',
        'services_products' => 'nullable|string',
        'target' => 'nullable|string',
      ], [
        'required' => 'Le champ :attribute est requis.',
        'string' => 'Le champ :attribute doit être une chaîne de caractères.',
        'email' => 'Le champ :attribute doit être une adresse e-mail valide.',
        'max' => 'Le champ :attribute ne peut pas dépasser :max caractères.',
      ]);

      if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
      }

      // Si la validation réussit, vous pouvez procéder à l'insertion des données
      $specification = new Specification();
      $specification->entreprise_name = $request->entreprise_name;
      $specification->contact_person = $request->contact_person;
      $specification->phone = $request->phone;
      $specification->email = $request->email;
      $specification->prompt_description = $request->prompt_description;
      $specification->description = $request->description;
      $specification->prompt_main_activities = $request->prompt_main_activities;
      $specification->main_activities = $request->main_activities;
      $specification->prompt_services_products = $request->prompt_services_products;
      $specification->services_products = $request->services_products;
      $specification->target = $request->target;

      $specification->save();

      $recordId = $specification->id;

      return response()->json(['success' => true, 'message' => 'Record created successfully', 'record_id' => $recordId], 201);
    } else {
      return response()->json(['message' => 'Only AJAX requests are allowed'], 400);
    }
  }
  public function showstep1(Request $request, $id)
  {
    if ($request->ajax()) {
      $result = Specification::find($id);
      if ($result) {
        return response()->json(['result' => $result], 200);
      } else {
        return response()->json(['message' => 'Spécification non trouvée'], 404);
      }
    }
  }

  public function storestep2(Request $request)
  {
    //
    if ($request->ajax()) {
      $validator = Validator::make($request->all(), [
        'specification_id' => 'required|exists:specifications,id',
        'project_need' => 'nullable|string|max:255',
        'project_type' => 'nullable|string|max:255',
        'payment_options' => 'nullable|array',
        'languages' => 'nullable|array',
        'target_keywords' => 'nullable|string',
        'expected_functions' => 'nullable|array',
        'expected_objectives' => 'nullable|string',
        'menu' => 'nullable|string|max:255',
      ], [
        'required' => 'Le champ :attribute est requis.',
        'string' => 'Le champ :attribute doit être une chaîne de caractères.',
        'max' => 'Le champ :attribute ne peut pas dépasser :max caractères.',
        'exists' => 'Le :attribute spécifié est invalide.',
        'json' => 'Le champ :attribute doit être une chaîne JSON valide.',
        'array' => 'Le champ :attribute doit être un tableau.',
      ]);

      if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
      }


      // Si la validation réussit, vous pouvez procéder à l'insertion des données
      $objectifSite = new ObjectifSite();
      $objectifSite->specification_id = $request->specification_id;
      $objectifSite->project_need = $request->project_need;
      $objectifSite->project_type = $request->project_type;
      $objectifSite->payment_options = $request->payment_options;
      $objectifSite->languages = $request->languages;
      $objectifSite->target_keywords = $request->target_keywords;
      $objectifSite->expected_functions = $request->expected_functions;
      $objectifSite->expected_objectives = $request->expected_objectives;
      $objectifSite->menu = $request->menu;

      $objectifSite->save();

      $objectifSite->save();

      $recordId = $objectifSite->id;

      return response()->json(['success' => true, 'message' => 'Record created successfully', 'record_id' => $recordId], 201);
    } else {
      return response()->json(['message' => 'Only AJAX requests are allowed'], 400);
    }
  }

  public function showstep2(Request $request, $id)
  {
    if ($request->ajax()) {
      $result = ObjectifSite::find($id);
      if ($result) {
        return response()->json(['result' => $result], 200);
      } else {
        return response()->json(['message' => 'Spécification non trouvée'], 404);
      }
    }
  }

  public function storestep3(Request $request)
  {
    if ($request->ajax()) {
      $validator = Validator::make($request->all(), [
        'specification_id' => 'required|numeric',
        'competitors' => 'required|string',
        'sample_sites' => 'required|string',
        'sample_sites_files' => ['nullable', 'array'],
        'sample_sites_files.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,bmp,svg,webp,pdf,doc,docx'],
        'constraints' => 'nullable|string',
        'constraints_files' => ['nullable', 'array'],
        'constraints_files.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,bmp,svg,webp,pdf,doc,docx'],
        'domain' => 'required|string',
        'domain_name' => 'nullable|string',
        'logo' => 'required|string',
        'logo_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,bmp,svg,webp,pdf,doc,docx'],
        'hosting' => 'required|string',
        'hosting_name' => 'nullable|string'
      ], [
        'required' => 'Le champ :attribute est requis.',
        'numeric' => 'Le champ :attribute doit être numérique.',
        'string' => 'Le champ :attribute doit être une chaîne de caractères.',
        'array' => 'Le champ :attribute doit être un tableau.',
        'file' => 'Le champ :attribute doit être un fichier.',
        'mimes' => 'Le champ :attribute doit être de type :values.',
      ]);

      if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
      }

      $specification_id = $request->specification_id;
      $files_sample_sites_files = [];
      $files_constraints_files = [];
      $logoFilePath = '';

      if ($request->hasFile('sample_sites_files')) {
        $files_sample_sites_files = $this->handleFiles($request->file('sample_sites_files'), $specification_id, 'sample_sites_files');
      }

      if ($request->hasFile('constraints_files')) {
        $files_constraints_files = $this->handleFiles($request->file('constraints_files'), $specification_id, 'constraints_files');
      }

      if ($request->hasFile('logo_file')) {
        $logoFilePath = $this->handleSingleFile($request->file('logo_file'), $specification_id, 'logo');
      }

      $record = new ExistingAnalysis();
      $record->specification_id = $specification_id;
      $record->competitors = $request->competitors;
      $record->sample_sites = $request->sample_sites;
      $record->sample_sites_files = $files_sample_sites_files ? $files_sample_sites_files : null;
      $record->constraints = $request->constraints;
      $record->constraints_files = $files_constraints_files ? $files_constraints_files : null;
      $record->domain = $request->domain;
      $record->domain_name = $request->domain_name;
      $record->logo = $request->logo;
      $record->logo_file = $logoFilePath;
      $record->hosting = $request->hosting;
      $record->hosting_name = $request->hosting_name;
      $record->save();

      return response()->json(['success' => true, 'message' => 'Record created successfully', 'record_id' => $record->id], 201);
    } else {
      return response()->json(['message' => 'Only AJAX requests are allowed'], 400);
    }
  }

  public function showstep3(Request $request, $id)
  {
    if ($request->ajax()) {
      $result = ExistingAnalysis::find($id);
      if ($result) {
        return response()->json(['result' => $result], 200);
      } else {
        return response()->json(['message' => 'Spécification non trouvée'], 404);
      }
    }
  }

  public function storestep4(Request $request)
  {

    if ($request->ajax()) {
      $messages = [
        'specification_id.required' => 'L\'identifiant de la spécification est requis.',
        'specification_id.numeric' => 'L\'identifiant de la spécification doit être numérique.',
        'content.required' => 'Le contenu est requis.',
        'content.string' => 'Le contenu doit être une chaîne de caractères.',
        'style_graphiques.required' => 'Le style graphique est requis.',
        'style_graphiques.array' => 'Le style graphique doit être un tableau.',
        'style_graphiques.*.string' => 'Chaque élément du style graphique doit être une chaîne de caractères.',
        'style_graphique_autre.string' => 'Le style graphique (autre) doit être une chaîne de caractères.',
        'number_of_propositions.required' => 'Le nombre de propositions est requis.',
        'number_of_propositions.numeric' => 'Le nombre de propositions doit être numérique.',
        'color_palette.required' => 'La palette de couleurs est requise.',
        'color_palette.string' => 'La palette de couleurs doit être une chaîne de caractères.',
        'typography.required' => 'La typographie est requise.',
        'typography.string' => 'La typographie doit être une chaîne de caractères.',
        'exemples_sites.required' => 'Les exemples de sites sont requis.',
        'exemples_sites.string' => 'Les exemples de sites doivent être une chaîne de caractères.',
        'exemples_sites_files.array' => 'Les exemples de sites doivent être un tableau.',
        'exemples_sites_files.*.file' => 'Les fichiers d\'exemples de sites doivent être valides.',
        'exemples_sites_files.*.mimes' => 'Les fichiers d\'exemples de sites doivent être au format JPG, JPEG, PNG, GIF, BMP, SVG, WEBP, PDF, DOC ou DOCX.',
      ];

      $validatedData = $request->validate([
        'specification_id' => 'required|numeric',
        'content' => 'required|string',
        'style_graphiques' => 'required|array',
        'style_graphiques.*' => 'required|string',
        'style_graphique_autre' => 'nullable|string',
        'number_of_propositions' => 'required|numeric',
        'color_palette' => 'nullable|string',
        'typography' => 'nullable|string',
        'exemples_sites' => 'nullable|string',
        'exemples_sites_files' => ['nullable', 'array'],
        'exemples_sites_files.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,bmp,svg,webp,pdf,doc,docx'],
      ], [
        'required' => 'Le champ :attribute est requis.',
        'numeric' => 'Le champ :attribute doit être numérique.',
        'string' => 'Le champ :attribute doit être une chaîne de caractères.',
        'array' => 'Le champ :attribute doit être un tableau.',
        'file' => 'Le champ :attribute doit être un fichier.',
        'mimes' => 'Le champ :attribute doit être de type :values.',
      ]);

      $specification_id = $validatedData['specification_id'];

      $successFiles_exemples_sites_files = [];

      if ($request->hasFile('exemples_sites_files')) {
        $successFiles_exemples_sites_files = $this->handleFiles($validatedData['exemples_sites_files'], $specification_id, 'exemples_sites_files');
      }

      $record = new DesignContent();
      $record->specification_id = $validatedData['specification_id'];
      $record->content = $validatedData['content'];
      $record->style_graphiques = ($validatedData['style_graphiques']);
      $record->style_graphique_autre = $validatedData['style_graphique_autre'];
      $record->number_of_propositions = $validatedData['number_of_propositions'];
      $record->color_palette = $validatedData['color_palette'];
      $record->typography = $validatedData['typography'];
      $record->exemples_sites = $validatedData['exemples_sites'];
      $record->exemples_sites_files = $successFiles_exemples_sites_files ? ($successFiles_exemples_sites_files) : null;

      $record->save();
      $recordId = $record->id;
      return response()->json(['success' => true, 'message' => 'Record created successfully', 'record_id' => $recordId], 201);
    } else {
      return response()->json(['message' => 'Only AJAX requests are allowed'], 400);
    }
  }

  public function showstep4(Request $request, $id)
  {
    if ($request->ajax()) {
      $result = DesignContent::find($id);
      if ($result) {
        return response()->json(['result' => $result], 200);
      } else {
        return response()->json(['message' => 'Spécification non trouvée'], 404);
      }
    }
  }

  public function storestep5(Request $request)
  {
    if ($request->ajax()) {
      $validatedData = $request->validate([
        'specification_id' => 'required|numeric',
        'gestion_projet' => 'required|string',
        'communication' => 'required|array',
        'communication.*' => 'required|string',
        'deadline' => 'required|string',
        'budget_from' => 'required|string',
        'budget_to' => 'required|string',
      ], [
        'required' => 'Le champ :attribute est requis.',
        'numeric' => 'Le champ :attribute doit être numérique.',
        'string' => 'Le champ :attribute doit être une chaîne de caractères.',
      ]);
      $record = new DeadlineAndBudget();
      $record->specification_id = $validatedData['specification_id'];
      $record->communication = ($validatedData['communication']);
      $record->gestion_projet = $validatedData['gestion_projet'];
      $record->deadline = $validatedData['deadline'];
      $record->budget_from = $validatedData['budget_from'];
      $record->budget_to = $validatedData['budget_to'];
      $record->save();
      $recordId = $record->id;
      return response()->json(['success' => true, 'message' => 'Record created successfully', 'record_id' => $recordId], 201);
    } else {
      return response()->json(['message' => 'Only AJAX requests are allowed'], 400);
    }
  }

  public function showstep5(Request $request, $id)
  {
    if ($request->ajax()) {
      $result = DeadlineAndBudget::find($id);
      if ($result) {
        return response()->json(['result' => $result], 200);
      } else {
        return response()->json(['message' => 'Spécification non trouvée'], 404);
      }
    }
  }



  // public function updateStepOne(Request $request, $id)
  // {
  //   //
  //   if ($request->ajax()) {
  //     // Validate the incoming request data
  //     $validatedData = $request->validate([
  //       'entreprise_name' => 'required|string|min:2|max:255',
  //       'contact_person' => 'required|string',
  //       'phone' => 'required|string',
  //       'email' => 'required|email',
  //       'description' => 'nullable|string',
  //       'main_activities' => 'nullable|string',
  //       'services_products' => 'nullable|string',
  //       'target' => 'nullable|string',
  //     ], [
  //       'entreprise_name.required' => 'Le champ nom est requis.',
  //       'entreprise_name.string' => 'Le champ nom doit être une chaîne de caractères.',
  //       'entreprise_name.min' => 'Le champ nom doit avoir au moins :min caractères.',
  //       'entreprise_name.max' => 'Le champ nom ne peut pas dépasser :max caractères.',
  //       'contact_person.required' => 'Le champ personne de contact est requis.',
  //       'contact_person.string' => 'Le champ personne de contact doit être une chaîne de caractères.',
  //       'phone.required' => 'Le champ téléphone est requis.',
  //       'phone.string' => 'Le champ téléphone doit être une chaîne de caractères.',
  //       'email.required' => 'Le champ email est requis.',
  //       'email.email' => 'Le champ email doit être une adresse email valide.',
  //     ]);


  //     $record = Specification::findOrFail($id);

  //     // Update the record with the validated data
  //     $record->entreprise_name = $validatedData['entreprise_name'];
  //     $record->contact_person = $validatedData['contact_person'];
  //     $record->phone = $validatedData['phone'];
  //     $record->email = $validatedData['email'];
  //     $record->description = $validatedData['description'];
  //     $record->main_activities = $validatedData['main_activities'];
  //     $record->services_products = $validatedData['services_products'];
  //     $record->target = $validatedData['target'];
  //     // Update other fields as needed

  //     $record->save();

  //     // Return a response to indicate success
  //     return response()->json(['success' => true, 'message' => 'Record updated successfully'], 200);
  //   } else {
  //     // Handle non-AJAX requests
  //     return response()->json(['message' => 'Only AJAX requests are allowed'], 400);
  //   }
  // }
  // public function updateStepTwo(Request $request, $id)
  // {
  //   //
  //   if ($request->ajax()) {
  //     // Validate the incoming request data
  //     $messages = [
  //       'specification_id.required' => 'Le champ ID de la spécification est requis.',
  //       'specification_id.numeric' => 'Le champ ID de la spécification doit être numérique.',
  //       'project_need.required' => 'Le champ Besoin du projet est requis.',
  //       'project_need.string' => 'Le champ Besoin du projet doit être une chaîne de caractères.',
  //       'project_type.required' => 'Le champ Type de projet est requis.',
  //       'project_type.string' => 'Le champ Type de projet doit être une chaîne de caractères.',
  //       'payment_options.array' => 'Le champ Options de paiement doit être un tableau.',
  //       'payment_options.*.string' => 'Chaque élément du champ Options de paiement doit être une chaîne de caractères.',
  //       'expected_functions.required' => 'Le champ Fonctions attendues est requis.',
  //       'expected_functions.array' => 'Le champ Fonctions attendues doit être un tableau.',
  //       'expected_functions.*.string' => 'Chaque élément du champ Fonctions attendues doit être une chaîne de caractères.',
  //       'languages.required' => 'Le champ Langues est requis.',
  //       'languages.array' => 'Le champ Langues doit être un tableau.',
  //       'languages.*.string' => 'Chaque élément du champ Langues doit être une chaîne de caractères.',
  //       'expected_objectives.required' => 'Le champ Objectifs attendus est requis.',
  //       'expected_objectives.string' => 'Le champ Objectifs attendus doit être une chaîne de caractères.',
  //       'menu.string' => 'Le champ Menu doit être une chaîne de caractères.',
  //     ];

  //     $validatedData = $request->validate([
  //       'specification_id' => 'required|numeric',
  //       'project_need' => 'required|string',
  //       'project_type' => 'required|string',
  //       'payment_options' => 'nullable|array',
  //       'payment_options.*' => 'string',
  //       'expected_functions' => 'required|array',
  //       'expected_functions.*' => 'string',
  //       'languages' => 'required|array',
  //       'languages.*' => 'string',
  //       'expected_objectives' => 'required|string',
  //       'menu' => 'nullable|string',
  //     ], $messages);

  //     if (isset($validatedData['payment_options']) && $validatedData['project_type'] == 'E-commerce')
  //       $validatedData['payment_options'] = ($validatedData['payment_options']);
  //     else $validatedData['payment_options'] = null;

  //     // Find the record with the given ID
  //     $record = ObjectifSite::findOrFail($id);

  //     // Update the record with the validated data
  //     $record->specification_id = $validatedData['specification_id'];
  //     $record->project_need = $validatedData['project_need'];
  //     $record->project_type = $validatedData['project_type'];
  //     $record->payment_options = $validatedData['payment_options'];
  //     $record->expected_functions = $validatedData['expected_functions'];
  //     $record->languages = $validatedData['languages'];
  //     $record->expected_objectives = $validatedData['expected_objectives'];
  //     $record->menu = $validatedData['menu'];
  //     // Update other fields as needed

  //     $record->save();

  //     // Return a response to indicate success
  //     return response()->json(['success' => true, 'message' => 'Record updated successfully'], 200);
  //   } else {
  //     // Handle non-AJAX requests
  //     return response()->json(['message' => 'Only AJAX requests are allowed'], 400);
  //   }
  // }

  private function handleFiles($files, $specification_id, $folder)
  {
    $successFiles = [];

    foreach ($files as $file) {
      if ($file->isValid()) {
        $destinationPath = 'assets/img/specifications/' . $specification_id . '/' . $folder;
        $fileName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $fileName = pathinfo($fileName, PATHINFO_FILENAME) . '_' . uniqid() . '.' . $extension;
        $file->move($destinationPath, $fileName);
        $successFiles[] = $destinationPath . '/' . $fileName;
      }
    }

    return $successFiles;
  }

  private function handleSingleFile($file, $specification_id, $folder)
  {
    if ($file->isValid()) {
      $destinationPath = 'assets/img/specifications/' . $specification_id . '/' . $folder;
      $fileName = $file->getClientOriginalName();
      $extension = $file->getClientOriginalExtension();
      $fileName = pathinfo($fileName, PATHINFO_FILENAME) . '_' . uniqid() . '.' . $extension;
      $file->move($destinationPath, $fileName);
      return $destinationPath . '/' . $fileName;
    }

    return '';
  }
}
