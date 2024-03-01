<?php

namespace App\Http\Controllers;

use App\Models\DeadlineAndBudget;
use App\Models\DesignContent;
use App\Models\ExistingAnalysis;
use App\Models\ExpectedFunction;
use App\Models\Facturation;
use App\Models\ObjectifSite;
use App\Models\Specification;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpWord\PhpWord;

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
      ->addColumn('actions', function ($item) {
        if ($item->step == 5) {
          return '
                <a class="btn btn-icon btn-primary text-white" target="_blank" href="specifications/' . $item->id . '" data-id="' . $item->id . '">
                    <i class="ti ti-eye"></i>
                </a>
               
                ';
        } else {
          return '
               
                ';
        }
      })
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
    // try {
    $specification = Specification::with('objectif_site', 'existing_analysis', 'design_content', 'deadline_and_budget', 'facturation')->findOrFail($id);

    if ($specification) {
      $pdf = PDF::loadView('content.pdf.index', compact('specification'));

      // Stream the PDF
      return $pdf->stream('pdf.pdf');

      // Download the PDF
      // return $pdf->download('pdf.pdf');
    }
    // } catch (\Exception $e) {
    // Log the error if needed
    // Log::error($e->getMessage());

    // Redirect back to the previous page
    // return Redirect::back()->with('error', 'Failed to load specification.');
    // }
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
        'has_website' => 'required|string|max:255',
        'website_domaine' => 'nullable|string|max:255',
        'contact_person' => 'required|string|max:255',
        'phone' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'prompt_description' => 'nullable|string',
        'description' => 'nullable|string',
        'prompt_main_activities' => 'nullable|string',
        'main_activities' => 'nullable|string',
        'prompt_services_products' => 'nullable|string',
        'services_products' => 'nullable|string',
        'prompt_target_audience' => 'nullable|string',
        'target_audience' => 'nullable|string',
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
      $specification->has_website = $request->has_website;
      $specification->website_domaine = $request->website_domaine;
      $specification->contact_person = $request->contact_person;
      $specification->phone = $request->phone;
      $specification->email = $request->email;
      $specification->prompt_description = $request->prompt_description;
      $specification->description = $request->description;
      $specification->prompt_main_activities = $request->prompt_main_activities;
      $specification->main_activities = $request->main_activities;
      $specification->prompt_services_products = $request->prompt_services_products;
      $specification->services_products = $request->services_products;
      $specification->prompt_target_audience = $request->prompt_target_audience;
      $specification->target_audience = $request->target_audience;
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

  public function updatestep1(Request $request, $id)
  {
    // return $request;
    if ($request->ajax()) {
      $validator = Validator::make($request->all(), [
        'entreprise_name' => 'required|string|max:255',
        'has_website' => 'required|string|max:255',
        'website_domaine' => 'nullable|string|max:255',
        'contact_person' => 'required|string|max:255',
        'phone' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'prompt_description' => 'nullable|string',
        'description' => 'nullable|string',
        'prompt_main_activities' => 'nullable|string',
        'main_activities' => 'nullable|string',
        'prompt_services_products' => 'nullable|string',
        'services_products' => 'nullable|string',
        'prompt_target_audience' => 'nullable|string',
        'target_audience' => 'nullable|string',
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

      // Retrieve existing record by ID
      $specification = Specification::find($id);

      // Check if the record exists
      if (!$specification) {
        return response()->json(['error' => 'Record not found'], 404);
      }

      // Update fields with new values
      $specification->entreprise_name = $request->entreprise_name;
      $specification->has_website = $request->has_website;
      $specification->website_domaine = $request->website_domaine;
      $specification->contact_person = $request->contact_person;
      $specification->phone = $request->phone;
      $specification->email = $request->email;
      $specification->prompt_description = $request->prompt_description;
      $specification->description = $request->description;
      $specification->prompt_main_activities = $request->prompt_main_activities;
      $specification->main_activities = $request->main_activities;
      $specification->prompt_services_products = $request->prompt_services_products;
      $specification->services_products = $request->services_products;
      $specification->prompt_target_audience = $request->prompt_target_audience;
      $specification->target_audience = $request->target_audience;
      $specification->target = $request->target;

      // Save the updated record
      $specification->save();

      $recordId = $specification->id;

      return response()->json(['success' => true, 'message' => 'Record updated successfully', 'record_id' => $recordId], 200);
    } else {
      return response()->json(['message' => 'Only AJAX requests are allowed'], 400);
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
        'iatext_target_keywords' => 'nullable|string',
        'prompt_iatext_target_keywords' => 'nullable|string',
        'expected_functions' => 'nullable|array',
        'expected_objectives' => 'nullable|string',
        'prompt_expected_client_objectives' => 'nullable|string',
        'expected_client_objectives' => 'nullable|string',
        'techniques_specs' => 'nullable|string',
        'prompt_iatext_techniques_specs' => 'nullable|string',
        'iatext_techniques_specs' => 'nullable|string',
        'menu' => 'nullable|string',
        'prompt_iatext_menu' => 'nullable|string',
        'iatext_menu' => 'nullable|string',
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
      $objectifSite->iatext_target_keywords = $request->iatext_target_keywords;
      $objectifSite->prompt_iatext_target_keywords = $request->prompt_iatext_target_keywords;
      $objectifSite->expected_functions = $request->expected_functions;
      $objectifSite->expected_objectives = $request->expected_objectives;
      $objectifSite->prompt_expected_client_objectives = $request->prompt_expected_client_objectives;
      $objectifSite->expected_client_objectives = $request->expected_client_objectives;
      $objectifSite->menu = $request->menu;
      $objectifSite->prompt_iatext_menu = $request->prompt_iatext_menu;
      $objectifSite->iatext_menu = $request->iatext_menu;
      $objectifSite->techniques_specs = $request->techniques_specs;
      $objectifSite->prompt_iatext_techniques_specs = $request->prompt_iatext_techniques_specs;
      $objectifSite->iatext_techniques_specs = $request->iatext_techniques_specs;

      $objectifSite->save();

      $specification = Specification::find($request->specification_id);

      if ($specification) {
        // Update the "step" field
        $specification->step = 2;
        $specification->save();
      }

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

  public function updatestep2(Request $request, $id)
  {
    if ($request->ajax()) {
      $validator = Validator::make($request->all(), [
        'specification_id' => 'required|exists:specifications,id',
        'project_need' => 'nullable|string|max:255',
        'project_type' => 'nullable|string|max:255',
        'payment_options' => 'nullable|array',
        'languages' => 'nullable|array',
        'target_keywords' => 'nullable|string',
        'iatext_target_keywords' => 'nullable|string',
        'prompt_iatext_target_keywords' => 'nullable|string',
        'expected_functions' => 'nullable|array',
        'expected_objectives' => 'nullable|string',
        'prompt_expected_client_objectives' => 'nullable|string',
        'expected_client_objectives' => 'nullable|string',
        'techniques_specs' => 'nullable|string',
        'prompt_iatext_techniques_specs' => 'nullable|string',
        'iatext_techniques_specs' => 'nullable|string',
        'menu' => 'nullable|string',
        'prompt_iatext_menu' => 'nullable|string',
        'iatext_menu' => 'nullable|string',
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
      // $objectifSite = new ObjectifSite();

      // Retrieve existing record by ID
      $objectifSite = ObjectifSite::find($id);

      // Check if the record exists
      if (!$objectifSite) {
        return response()->json(['error' => 'Record not found'], 404);
      }

      $objectifSite->specification_id = $request->specification_id;
      $objectifSite->project_need = $request->project_need;
      $objectifSite->project_type = $request->project_type;
      $objectifSite->payment_options = $request->payment_options;
      $objectifSite->languages = $request->languages;
      $objectifSite->target_keywords = $request->target_keywords;
      $objectifSite->iatext_target_keywords = $request->iatext_target_keywords;
      $objectifSite->prompt_iatext_target_keywords = $request->prompt_iatext_target_keywords;
      $objectifSite->expected_functions = $request->expected_functions;
      $objectifSite->expected_objectives = $request->expected_objectives;
      $objectifSite->prompt_expected_client_objectives = $request->prompt_expected_client_objectives;
      $objectifSite->expected_client_objectives = $request->expected_client_objectives;
      $objectifSite->menu = $request->menu;
      $objectifSite->prompt_iatext_menu = $request->prompt_iatext_menu;
      $objectifSite->iatext_menu = $request->iatext_menu;
      $objectifSite->techniques_specs = $request->techniques_specs;
      $objectifSite->prompt_iatext_techniques_specs = $request->prompt_iatext_techniques_specs;
      $objectifSite->iatext_techniques_specs = $request->iatext_techniques_specs;

      $objectifSite->save();

      $recordId = $objectifSite->id;

      return response()->json(['success' => true, 'message' => 'Record updated successfully', 'record_id' => $recordId], 200);
    } else {
      return response()->json(['message' => 'Only AJAX requests are allowed'], 400);
    }
  }


  public function storestep3(Request $request)
  {
    if ($request->ajax()) {
      $validator = Validator::make($request->all(), [
        'specification_id' => 'required|numeric',
        'competitors' => 'required|string',
        'sample_sites' => 'required|string',
        'prompt_iatext_competitors' => 'nullable|string',
        'iatext_competitors' => 'nullable|string',
        'sample_sites_files' => ['nullable', 'array'],
        'sample_sites_files.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,bmp,svg,webp,pdf,doc,docx'],
        'constraints' => 'nullable|string',
        'prompt_iatext_constraints' => 'nullable|string',
        'iatext_constraints' => 'nullable|string',
        'constraints_files' => ['nullable', 'array'],
        'constraints_files.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,bmp,svg,webp,pdf,doc,docx'],
        'domain' => 'required|string',
        'domain_name' => 'nullable|string',
        // 'logo' => 'required|string',
        // 'logo_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,bmp,svg,webp,pdf,doc,docx'],
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
      // $logoFilePath = '';

      if ($request->hasFile('sample_sites_files')) {
        $files_sample_sites_files = $this->handleFiles($request->file('sample_sites_files'), $specification_id, 'sample_sites_files');
      }

      if ($request->hasFile('constraints_files')) {
        $files_constraints_files = $this->handleFiles($request->file('constraints_files'), $specification_id, 'constraints_files');
      }

      // if ($request->hasFile('logo_file')) {
      //   $logoFilePath = $this->handleSingleFile($request->file('logo_file'), $specification_id, 'logo');
      // }

      $record = new ExistingAnalysis();
      $record->specification_id = $specification_id;
      $record->competitors = $request->competitors;
      $record->prompt_iatext_competitors = $request->prompt_iatext_competitors;
      $record->iatext_competitors = $request->iatext_competitors;
      $record->sample_sites = $request->sample_sites;
      $record->sample_sites_files = $files_sample_sites_files ? $files_sample_sites_files : null;
      $record->constraints = $request->constraints;
      $record->prompt_iatext_constraints = $request->prompt_iatext_constraints;
      $record->iatext_constraints = $request->iatext_constraints;
      $record->constraints_files = $files_constraints_files ? $files_constraints_files : null;
      $record->domain = $request->domain;
      $record->domain_name = $request->domain_name;
      $record->hosting = $request->hosting;
      $record->hosting_name = $request->hosting_name;
      $record->save();

      $specification = Specification::find($request->specification_id);

      if ($specification) {
        $specification->step = 3;
        $specification->save();
      }

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

      $validatedData = $request->validate([
        'specification_id' => 'required|numeric',
        'logo' => 'required|string',
        'logo_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,bmp,svg,webp,pdf,doc,docx'],
        'graphical_charter' => 'required|string',
        'graphical_charter_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,bmp,svg,webp,pdf,doc,docx'],
        'wireframe' => 'required|string',
        'wireframe_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,bmp,svg,webp,pdf,doc,docx'],
        'typography' => 'required|string',
        'typography_text' => 'nullable|string',
        'description_product_services' => 'required|string',
        'description_product_services_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,bmp,svg,webp,pdf,doc,docx'],
        'style_graphiques' => 'required|array',
        'style_graphiques.*' => 'required|string',
        'style_graphique_autre' => 'nullable|string',
        'number_of_propositions' => 'required|numeric',
        'color_palette' => 'nullable|string',
        'exemples_sites' => 'nullable|string',
        'exemples_sites_files' => ['nullable', 'array'],
        'exemples_sites_files.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,bmp,svg,webp,pdf,doc,docx'],
        'prompt_iatext_exemples_sites' => 'nullable|string',
        'iatext_exemples_sites' => 'nullable|string',
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

      $logo_file_path = '';
      if ($request->hasFile('logo_file')) {
        $logo_file_path = $this->handleSingleFile($request->file('logo_file'), $specification_id, 'logo');
      }

      $graphical_charter_file_path = '';
      if ($request->hasFile('graphical_charter_file')) {
        $graphical_charter_file_path = $this->handleSingleFile($request->file('graphical_charter_file'), $specification_id, 'graphical_charter');
      }

      $wireframe_file_path = '';
      if ($request->hasFile('wireframe_file')) {
        $wireframe_file_path = $this->handleSingleFile($request->file('wireframe_file'), $specification_id, 'wireframe');
      }

      $description_product_services_file_path = '';
      if ($request->hasFile('description_product_services_file')) {
        $description_product_services_file_path = $this->handleSingleFile($request->file('description_product_services_file'), $specification_id, 'description_product_services');
      }

      $record = new DesignContent();
      $record->specification_id = $validatedData['specification_id'];
      $record->logo = $validatedData['logo'];
      $record->logo_file = $logo_file_path;
      $record->graphical_charter = $validatedData['graphical_charter'];
      $record->graphical_charter_file = $graphical_charter_file_path;
      $record->wireframe = $validatedData['wireframe'];
      $record->wireframe_file = $wireframe_file_path;
      $record->typography = $validatedData['typography'];
      $record->typography_text = $validatedData['typography_text'];
      $record->description_product_services = $validatedData['description_product_services'];
      $record->description_product_services_file = $description_product_services_file_path;
      $record->style_graphiques = $validatedData['style_graphiques'];
      $record->style_graphique_autre = $validatedData['style_graphique_autre'];
      $record->number_of_propositions = $validatedData['number_of_propositions'];
      $record->color_palette = $validatedData['color_palette'];
      $record->exemples_sites = $validatedData['exemples_sites'];
      $record->exemples_sites_files = $successFiles_exemples_sites_files ? ($successFiles_exemples_sites_files) : null;
      $record->prompt_iatext_exemples_sites = $validatedData['prompt_iatext_exemples_sites'];
      $record->iatext_exemples_sites = $validatedData['iatext_exemples_sites'];

      $record->save();

      $specification = Specification::find($request->specification_id);

      if ($specification) {
        $specification->step = 4;
        $specification->save();
      }

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
        'budget_from' => 'required|numeric',
        'budget_to' => 'required|numeric',
        'number_of_days_installation_environment' => 'nullable|numeric',
        'unit_amount_installation_environment' => 'nullable|numeric',
        'total_installation_environment' => 'nullable|numeric',
        'number_of_days_integration_structure' => 'nullable|numeric',
        'unit_amount_integration_structure' => 'nullable|numeric',
        'total_integration_structure' => 'nullable|numeric',
        'number_of_days_draft_texts_translations' => 'nullable|numeric',
        'unit_amount_draft_texts_translations' => 'nullable|numeric',
        'total_draft_texts_translations' => 'nullable|numeric',
        'number_of_days_graphic_modeling' => 'nullable|numeric',
        'unit_amount_graphic_modeling' => 'nullable|numeric',
        'total_graphic_modeling' => 'nullable|numeric',
        'number_of_days_web_development_integrations' => 'nullable|numeric',
        'unit_amount_web_development_integrations' => 'nullable|numeric',
        'total_web_development_integrations' => 'nullable|numeric',
        'number_of_days_text_image_integration' => 'nullable|numeric',
        'unit_amount_text_image_integration' => 'nullable|numeric',
        'total_text_image_integration' => 'nullable|numeric',
        'number_of_days_other_pages_integration' => 'nullable|numeric',
        'unit_amount_other_pages_integration' => 'nullable|numeric',
        'total_other_pages_integration' => 'nullable|numeric',
        'number_of_days_mobile_version_optimization' => 'nullable|numeric',
        'unit_amount_mobile_version_optimization' => 'nullable|numeric',
        'total_mobile_version_optimization' => 'nullable|numeric',
        'number_of_days_multilingual_integration' => 'nullable|numeric',
        'unit_amount_multilingual_integration' => 'nullable|numeric',
        'total_multilingual_integration' => 'nullable|numeric',
        'number_of_days_seo_optimisation' => 'nullable|numeric',
        'unit_amount_seo_optimisation' => 'nullable|numeric',
        'total_seo_optimisation' => 'nullable|numeric',
        'number_of_days_testing_tracking' => 'nullable|numeric',
        'unit_amount_testing_tracking' => 'nullable|numeric',
        'total_testing_tracking' => 'nullable|numeric',
        'number_of_days_testing_tracking' => 'nullable|numeric',
        'unit_amount_testing_tracking' => 'nullable|numeric',
        'total_testing_tracking' => 'nullable|numeric',
        'number_of_days_project_management' => 'nullable|numeric',
        'unit_amount_project_management' => 'nullable|numeric',
        'total_project_management' => 'nullable|numeric',
        'exceptional_discount' => 'nullable|numeric',
        'total' => 'nullable|numeric',
        'rest' => 'nullable|numeric',
        'installment_1_percentage' => 'nullable|numeric',
        'installment_1_amount' => 'nullable|numeric',
        'installment_1_title' => 'nullable|string',
        'installment_2_percentage' => 'nullable|numeric',
        'installment_2_amount' => 'nullable|numeric',
        'installment_2_title' => 'nullable|string',
        'installment_3_percentage' => 'nullable|numeric',
        'installment_3_amount' => 'nullable|numeric',
        'installment_3_title' => 'nullable|string',
        'installment_4_percentage' => 'nullable|numeric',
        'installment_4_amount' => 'nullable|numeric',
        'installment_4_title' => 'nullable|string',
        'installment_5_percentage' => 'nullable|numeric',
        'installment_5_amount' => 'nullable|numeric',
        'installment_5_title' => 'nullable|string',
        'installment_6_percentage' => 'nullable|numeric',
        'installment_6_amount' => 'nullable|numeric',
        'installment_6_title' => 'nullable|string',
        'installment_7_percentage' => 'nullable|numeric',
        'installment_7_amount' => 'nullable|numeric',
        'installment_7_title' => 'nullable|string',
        'installment_8_percentage' => 'nullable|numeric',
        'installment_8_amount' => 'nullable|numeric',
        'installment_8_title' => 'nullable|string',
        'installment_9_percentage' => 'nullable|numeric',
        'installment_9_amount' => 'nullable|numeric',
        'installment_9_title' => 'nullable|string',
        'installment_10_percentage' => 'nullable|numeric',
        'installment_10_amount' => 'nullable|numeric',
        'installment_10_title' => 'nullable|string',
        'maintenance_percentage' => 'nullable|string',
        'maintenance_amount' => 'nullable|string',
      ], [
        'required' => 'Le champ :attribute est requis.',
        'numeric' => 'Le champ :attribute doit être numérique.',
        'string' => 'Le champ :attribute doit être une chaîne de caractères.',
      ]);

      ///


      $record = new DeadlineAndBudget();
      $record->specification_id = $validatedData['specification_id'];
      $record->communication = $validatedData['communication'];
      $record->gestion_projet = $validatedData['gestion_projet'];
      $record->deadline = $validatedData['deadline'];
      $record->budget_from = $validatedData['budget_from'];
      $record->budget_to = $validatedData['budget_to'];
      $record->save();

      ///

      $facture = new Facturation();
      $facture->specification_id = $validatedData['specification_id'];
      $facture->number_of_days_installation_environment = $validatedData['number_of_days_installation_environment'];
      $facture->unit_amount_installation_environment = $validatedData['unit_amount_installation_environment'];
      $facture->total_installation_environment = $validatedData['total_installation_environment'];
      $facture->number_of_days_integration_structure = $validatedData['number_of_days_integration_structure'];
      $facture->unit_amount_integration_structure = $validatedData['unit_amount_integration_structure'];
      $facture->total_integration_structure = $validatedData['total_integration_structure'];
      $facture->number_of_days_draft_texts_translations = $validatedData['number_of_days_draft_texts_translations'];
      $facture->unit_amount_draft_texts_translations = $validatedData['unit_amount_draft_texts_translations'];
      $facture->total_draft_texts_translations = $validatedData['total_draft_texts_translations'];
      $facture->number_of_days_graphic_modeling = $validatedData['number_of_days_graphic_modeling'];
      $facture->unit_amount_graphic_modeling = $validatedData['unit_amount_graphic_modeling'];
      $facture->total_graphic_modeling = $validatedData['total_graphic_modeling'];
      $facture->number_of_days_web_development_integrations = $validatedData['number_of_days_web_development_integrations'];
      $facture->unit_amount_web_development_integrations = $validatedData['unit_amount_web_development_integrations'];
      $facture->total_web_development_integrations = $validatedData['total_web_development_integrations'];
      $facture->number_of_days_web_development_integrations = $validatedData['number_of_days_web_development_integrations'];
      $facture->unit_amount_web_development_integrations = $validatedData['unit_amount_web_development_integrations'];
      $facture->total_web_development_integrations = $validatedData['total_web_development_integrations'];
      $facture->number_of_days_text_image_integration = $validatedData['number_of_days_text_image_integration'];
      $facture->unit_amount_text_image_integration = $validatedData['unit_amount_text_image_integration'];
      $facture->total_text_image_integration = $validatedData['total_text_image_integration'];
      $facture->number_of_days_other_pages_integration = $validatedData['number_of_days_other_pages_integration'];
      $facture->unit_amount_other_pages_integration = $validatedData['unit_amount_other_pages_integration'];
      $facture->total_other_pages_integration = $validatedData['total_other_pages_integration'];
      $facture->number_of_days_mobile_version_optimization = $validatedData['number_of_days_mobile_version_optimization'];
      $facture->unit_amount_mobile_version_optimization = $validatedData['unit_amount_mobile_version_optimization'];
      $facture->total_mobile_version_optimization = $validatedData['total_mobile_version_optimization'];
      $facture->number_of_days_multilingual_integration = $validatedData['number_of_days_multilingual_integration'];
      $facture->unit_amount_multilingual_integration = $validatedData['unit_amount_multilingual_integration'];
      $facture->total_multilingual_integration = $validatedData['total_multilingual_integration'];
      $facture->number_of_days_seo_optimisation = $validatedData['number_of_days_seo_optimisation'];
      $facture->unit_amount_seo_optimisation = $validatedData['unit_amount_seo_optimisation'];
      $facture->total_seo_optimisation = $validatedData['total_seo_optimisation'];
      $facture->number_of_days_testing_tracking = $validatedData['number_of_days_testing_tracking'];
      $facture->unit_amount_testing_tracking = $validatedData['unit_amount_testing_tracking'];
      $facture->total_testing_tracking = $validatedData['total_testing_tracking'];
      $facture->number_of_days_project_management = $validatedData['number_of_days_project_management'];
      $facture->unit_amount_project_management = $validatedData['unit_amount_project_management'];
      $facture->total_project_management = $validatedData['total_project_management'];
      $facture->exceptional_discount = $validatedData['exceptional_discount'];
      $facture->total = $validatedData['total'];
      $facture->rest = $validatedData['rest'];
      $facture->installment_1_percentage  = $validatedData['installment_1_percentage'];
      $facture->installment_1_amount      = $validatedData['installment_1_amount'];
      $facture->installment_1_title       = $validatedData['installment_1_title'];
      $facture->installment_2_percentage  = $validatedData['installment_2_percentage'];
      $facture->installment_2_amount      = $validatedData['installment_2_amount'];
      $facture->installment_2_title       = $validatedData['installment_2_title'];
      $facture->installment_3_percentage  = $validatedData['installment_3_percentage'];
      $facture->installment_3_amount      = $validatedData['installment_3_amount'];
      $facture->installment_3_title       = $validatedData['installment_3_title'];
      $facture->installment_4_percentage  = $validatedData['installment_4_percentage'];
      $facture->installment_4_amount      = $validatedData['installment_4_amount'];
      $facture->installment_4_title       = $validatedData['installment_4_title'];
      $facture->installment_5_percentage  = $validatedData['installment_5_percentage'];
      $facture->installment_5_amount      = $validatedData['installment_5_amount'];
      $facture->installment_5_title       = $validatedData['installment_5_title'];
      $facture->installment_6_percentage  = $validatedData['installment_6_percentage'];
      $facture->installment_6_amount      = $validatedData['installment_6_amount'];
      $facture->installment_6_title       = $validatedData['installment_6_title'];
      $facture->installment_7_percentage  = $validatedData['installment_7_percentage'];
      $facture->installment_7_amount      = $validatedData['installment_7_amount'];
      $facture->installment_7_title       = $validatedData['installment_7_title'];
      $facture->installment_8_percentage  = $validatedData['installment_8_percentage'];
      $facture->installment_8_amount      = $validatedData['installment_8_amount'];
      $facture->installment_8_title       = $validatedData['installment_8_title'];
      $facture->installment_9_percentage  = $validatedData['installment_9_percentage'];
      $facture->installment_9_amount      = $validatedData['installment_9_amount'];
      $facture->installment_9_title       = $validatedData['installment_9_title'];
      $facture->installment_10_percentage = $validatedData['installment_10_percentage'];
      $facture->installment_10_amount     = $validatedData['installment_10_amount'];
      $facture->installment_10_title      = $validatedData['installment_10_title'];
      $facture->maintenance_percentage    = $validatedData['maintenance_percentage'];
      $facture->maintenance_amount        = $validatedData['maintenance_amount'];

      $facture->save();

      ///

      $specification = Specification::find($request->specification_id);
      if ($specification) {
        $specification->step = 5;
        $specification->save();
      }

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
