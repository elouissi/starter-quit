<?php

namespace App\Http\Controllers;

use App\Mail\SpecificationMail;
use App\Models\DeadlineAndBudget;
use App\Models\DesignContent;
use App\Models\ExistingAnalysis;
use App\Models\ExpectedFunction;
use App\Models\Facturation;
use App\Models\Notification;
use App\Models\ObjectifSite;
use App\Models\Specification;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
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
      ->editColumn('step', function (Specification $specification) {

        $specification = Specification::findOrFail($specification->id);
        $relationships = [];
        if (isset($specification->objectif_site)) {
          $relationships[] = 'objectif_site';
        }
        if (isset($specification->existing_analysis)) {
          $relationships[] = 'existing_analysis';
        }
        if (isset($specification->design_content)) {
          $relationships[] = 'design_content';
        }
        if (isset($specification->deadline_and_budget)) {
          $relationships[] = 'deadline_and_budget';
        }
        if (isset($specification->facturation)) {
          $relationships[] = 'facturation';
        }
        $specification = $specification->load($relationships);

        $ia_error_exist =
          ($specification->prompt_description && ($specification->iatext_description == null || $specification->iatext_description == 'error')) ||
          ($specification->prompt_main_activities && ($specification->iatext_main_activities == null || $specification->iatext_main_activities == 'error')) ||
          ($specification->prompt_services_products && ($specification->iatext_services_products == null || $specification->iatext_services_products == 'error')) ||
          ($specification->prompt_target_audience && ($specification->iatext_target_audience == null || $specification->iatext_target_audience == 'error')) ||
          ($specification->objectif_site->prompt_iatext_target_keywords && ($specification->objectif_site->iatext_target_keywords == null || $specification->objectif_site->iatext_target_keywords == 'error')) ||
          ($specification->objectif_site->prompt_expected_client_objectives && ($specification->objectif_site->iatext_expected_client_objectives == null || $specification->objectif_site->iatext_expected_client_objectives == 'error')) ||
          ($specification->objectif_site->prompt_iatext_techniques_specs && ($specification->objectif_site->iatext_techniques_specs == null || $specification->objectif_site->iatext_techniques_specs == 'error')) ||
          ($specification->objectif_site->prompt_iatext_menu && ($specification->objectif_site->iatext_menu == null || $specification->objectif_site->iatext_menu == 'error')) ||
          ($specification->existing_analysis->prompt_iatext_competitors && ($specification->existing_analysis->iatext_competitors == null || $specification->existing_analysis->iatext_competitors == 'error')) ||
          ($specification->existing_analysis->prompt_iatext_constraints && ($specification->existing_analysis->iatext_constraints == null || $specification->existing_analysis->iatext_constraints == 'error')) ||
          ($specification->design_content->prompt_iatext_exemples_sites && ($specification->design_content->iatext_exemples_sites == null || $specification->design_content->iatext_exemples_sites == 'error'));

        if ($specification->step == 1 || $specification->step == 2 || $specification->step == 3 || $specification->step == 4) {
          return '<span class="badge rounded-pill bg-label-danger">' . $specification->step * 20 . ' % ' . '</span>';
        } elseif (($specification->step == 5) && ($ia_error_exist)) {
          return '<span class="badge rounded-pill bg-label-warning">Erreur d\'IA</span>';
        } elseif ($specification->step == 5) {
          return '<span class="badge rounded-pill bg-label-success">Terminé</span>';
        }
      })
      ->addColumn('actions', function (Specification $specification) {
        if ($specification->step == 5) {


          $ia_error_exist =
          ($specification->prompt_description && ($specification->iatext_description == null || $specification->iatext_description == 'error')) ||
          ($specification->prompt_main_activities && ($specification->iatext_main_activities == null || $specification->iatext_main_activities == 'error')) ||
          ($specification->prompt_services_products && ($specification->iatext_services_products == null || $specification->iatext_services_products == 'error')) ||
          ($specification->prompt_target_audience && ($specification->iatext_target_audience == null || $specification->iatext_target_audience == 'error')) ||
          ($specification->objectif_site->prompt_iatext_target_keywords && ($specification->objectif_site->iatext_target_keywords == null || $specification->objectif_site->iatext_target_keywords == 'error')) ||
          ($specification->objectif_site->prompt_expected_client_objectives && ($specification->objectif_site->iatext_expected_client_objectives == null || $specification->objectif_site->iatext_expected_client_objectives == 'error')) ||
          ($specification->objectif_site->prompt_iatext_techniques_specs && ($specification->objectif_site->iatext_techniques_specs == null || $specification->objectif_site->iatext_techniques_specs == 'error')) ||
          ($specification->objectif_site->prompt_iatext_menu && ($specification->objectif_site->iatext_menu == null || $specification->objectif_site->iatext_menu == 'error')) ||
          ($specification->existing_analysis->prompt_iatext_competitors && ($specification->existing_analysis->iatext_competitors == null || $specification->existing_analysis->iatext_competitors == 'error')) ||
          ($specification->existing_analysis->prompt_iatext_constraints && ($specification->existing_analysis->iatext_constraints == null || $specification->existing_analysis->iatext_constraints == 'error')) ||
          ($specification->design_content->prompt_iatext_exemples_sites && ($specification->design_content->iatext_exemples_sites == null || $specification->design_content->iatext_exemples_sites == 'error'));

          if ($ia_error_exist) {
            return '
                <div class="gap-1 row">
                 <!-- <a class="btn btn-sm btn-icon btn-primary text-white" title="Voir" target="_blank" href="specifications/' . $specification->id . '" data-id="' . $specification->id . '">
                      <i class="ti ti-eye"></i>
                  </a>
                  <a class="btn btn-sm btn-icon btn-primary text-white" title="Télécharger" target="_blank" href="specifications/upload/' . $specification->id . '" data-id="' . $specification->id . '">
                      <i class="ti ti-download"></i>
                  </a> -->
                  <a class="btn btn-sm btn-icon btn-primary text-white" title="Modifier" target="_blank" href="specifications/' . $specification->id . '/edit">
                      <i class="ti ti-pencil"></i>
                  </a>
                  <button class="btn btn-sm btn-icon btn-primary text-white rechat" title="Régénérer les textes avec ChatGPT" data-spec-id="' . $specification->id . '" target="_blank">
                      <i class="ti ti-brand-openai"></i>
                  </button>
                </div> ';
          }
          return '
                  <div class="gap-1 row">
                    <a class="btn btn-sm btn-icon btn-primary text-white" title="Voir" target="_blank" href="specifications/' . $specification->id . '" data-id="' . $specification->id . '">
                        <i class="ti ti-eye"></i>
                    </a>
                    <a class="btn btn-sm btn-icon btn-primary text-white" title="Télécharger" target="_blank" href="specifications/upload/' . $specification->id . '" data-id="' . $specification->id . '">
                        <i class="ti ti-download"></i>
                    </a>
                    <a class="btn btn-sm btn-icon btn-primary text-white" title="Modifier" target="_blank" href="specifications/' . $specification->id . '/edit">
                        <i class="ti ti-pencil"></i>
                    </a>
                  </div> ';
        }
        return '
            <div class="gap-1 row">
              <a class="btn btn-sm btn-icon btn-primary text-white" title="Compléter" href="specifications/' . $specification->id . '/edit">
                  <i class="ti ti-arrow-right"></i>
              </a>
            </div>
              ';
      })
      ->rawColumns(['actions', 'step'])
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
      return $pdf->stream($specification->entreprise_name . '_' . date('Y-m-d h-i-s') . '.pdf');
      return view('content.pdf.index', compact('specification'));

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

  public function upload(string $id)
  {
    // try {
    $specification = Specification::with('objectif_site', 'existing_analysis', 'design_content', 'deadline_and_budget', 'facturation')->findOrFail($id);

    if ($specification) {
      $pdf = PDF::loadView('content.pdf.index', compact('specification'));

      // Stream the PDF
      // return $pdf->stream('pdf.pdf');

      // Download the PDF
      return $pdf->download($specification->entreprise_name . '_' . date('Y-m-d h-i-s') . '.pdf');
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
    $expected_functions = ExpectedFunction::orderBy('order')->get();
    $specification = Specification::findOrFail($id);
    $relationships = [];
    if (isset($specification->objectif_site)) {
      $relationships[] = 'objectif_site';
    }
    if (isset($specification->existing_analysis)) {
      $relationships[] = 'existing_analysis';
    }
    if (isset($specification->design_content)) {
      $relationships[] = 'design_content';
    }
    if (isset($specification->deadline_and_budget)) {
      $relationships[] = 'deadline_and_budget';
    }
    if (isset($specification->facturation)) {
      $relationships[] = 'facturation';
    }
    $specification = $specification->load($relationships);

    // return $specification;

    // return view('content.specifications.edit', compact('specification', 'expected_functions'));

    if (request()->ajax()) {
      return response()->json([
        'specification' => $specification
      ]);
    }

    return view('content.specifications.edit', compact('specification', 'expected_functions'));
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
        // 'iatext_description' => 'nullable|string',
        'prompt_main_activities' => 'nullable|string',
        // 'iatext_main_activities' => 'nullable|string',
        'prompt_services_products' => 'nullable|string',
        // 'iatext_services_products' => 'nullable|string',
        'prompt_target_audience' => 'nullable|string',
        // 'iatext_target_audience' => 'nullable|string',
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
      // $specification->iatext_description = $request->iatext_description;
      $specification->prompt_main_activities = $request->prompt_main_activities;
      // $specification->iatext_main_activities = $request->iatext_main_activities;
      $specification->prompt_services_products = $request->prompt_services_products;
      // $specification->iatext_services_products = $request->iatext_services_products;
      $specification->prompt_target_audience = $request->prompt_target_audience;
      // $specification->iatext_target_audience = $request->iatext_target_audience;
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
        // 'iatext_description' => 'nullable|string',
        'prompt_main_activities' => 'nullable|string',
        // 'iatext_main_activities' => 'nullable|string',
        'prompt_services_products' => 'nullable|string',
        // 'iatext_services_products' => 'nullable|string',
        'prompt_target_audience' => 'nullable|string',
        // 'iatext_target_audience' => 'nullable|string',
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
      // $specification->iatext_description = $request->iatext_description;
      $specification->prompt_main_activities = $request->prompt_main_activities;
      // $specification->iatext_main_activities = $request->iatext_main_activities;
      $specification->prompt_services_products = $request->prompt_services_products;
      // $specification->iatext_services_products = $request->iatext_services_products;
      $specification->prompt_target_audience = $request->prompt_target_audience;
      // $specification->iatext_target_audience = $request->iatext_target_audience;
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
    // return $request;
    if ($request->ajax()) {
      $validator = Validator::make($request->all(), [
        'specification_id' => 'required|exists:specifications,id',
        'project_need' => 'nullable|string|max:255',
        'project_type' => 'nullable|string|max:255',
        'payment_options' => 'nullable|array',
        'languages' => 'nullable|array',
        'target_keywords' => 'nullable|string',
        'prompt_iatext_target_keywords' => 'nullable|string',
        // 'iatext_target_keywords' => 'nullable|string',
        'expected_functions' => 'nullable|array',
        'expected_objectives' => 'nullable|string',
        'prompt_expected_client_objectives' => 'nullable|string',
        // 'iatext_expected_client_objectives' => 'nullable|string',
        'techniques_specs' => 'nullable|string',
        'prompt_iatext_techniques_specs' => 'nullable|string',
        // 'iatext_techniques_specs' => 'nullable|string',
        'menu' => 'nullable|string',
        'prompt_iatext_menu' => 'nullable|string',
        // 'iatext_menu' => 'nullable|string',
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
      $objectifSite->prompt_iatext_target_keywords = $request->prompt_iatext_target_keywords;
      // $objectifSite->iatext_target_keywords = $request->iatext_target_keywords;
      $objectifSite->expected_functions = $request->expected_functions;
      $objectifSite->expected_objectives = $request->expected_objectives;
      $objectifSite->prompt_expected_client_objectives = $request->prompt_expected_client_objectives;
      // $objectifSite->iatext_expected_client_objectives = $request->iatext_expected_client_objectives;
      $objectifSite->menu = $request->menu;
      $objectifSite->prompt_iatext_menu = $request->prompt_iatext_menu;
      // $objectifSite->iatext_menu = $request->iatext_menu;
      $objectifSite->techniques_specs = $request->techniques_specs;
      $objectifSite->prompt_iatext_techniques_specs = $request->prompt_iatext_techniques_specs;
      // $objectifSite->iatext_techniques_specs = $request->iatext_techniques_specs;

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
        // 'iatext_target_keywords' => 'nullable|string',
        'prompt_iatext_target_keywords' => 'nullable|string',
        'expected_functions' => 'nullable|array',
        'expected_objectives' => 'nullable|string',
        'prompt_expected_client_objectives' => 'nullable|string',
        // 'iatext_expected_client_objectives' => 'nullable|string',
        'techniques_specs' => 'nullable|string',
        'prompt_iatext_techniques_specs' => 'nullable|string',
        // 'iatext_techniques_specs' => 'nullable|string',
        'menu' => 'nullable|string',
        'prompt_iatext_menu' => 'nullable|string',
        // 'iatext_menu' => 'nullable|string',
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
      // $objectifSite->iatext_target_keywords = $request->iatext_target_keywords;
      $objectifSite->prompt_iatext_target_keywords = $request->prompt_iatext_target_keywords;
      $objectifSite->expected_functions = $request->expected_functions;
      $objectifSite->expected_objectives = $request->expected_objectives;
      $objectifSite->prompt_expected_client_objectives = $request->prompt_expected_client_objectives;
      // $objectifSite->iatext_expected_client_objectives = $request->iatext_expected_client_objectives;
      $objectifSite->menu = $request->menu;
      $objectifSite->prompt_iatext_menu = $request->prompt_iatext_menu;
      // $objectifSite->iatext_menu = $request->iatext_menu;
      $objectifSite->techniques_specs = $request->techniques_specs;
      $objectifSite->prompt_iatext_techniques_specs = $request->prompt_iatext_techniques_specs;
      // $objectifSite->iatext_techniques_specs = $request->iatext_techniques_specs;

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
        // 'iatext_competitors' => 'nullable|string',
        'sample_sites_files' => ['nullable', 'array'],
        'sample_sites_files.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,svg,webp,pdf,doc,docx'],
        'constraints' => 'nullable|string',
        'prompt_iatext_constraints' => 'nullable|string',
        // 'iatext_constraints' => 'nullable|string',
        'constraints_files' => ['nullable', 'array'],
        'constraints_files.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,svg,webp,pdf,doc,docx'],
        'domain' => 'required|string',
        'domain_name' => 'nullable|string',
        // 'logo' => 'required|string',
        // 'logo_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,svg,webp,pdf,doc,docx'],
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
      // $record->iatext_competitors = $request->iatext_competitors;
      $record->sample_sites = $request->sample_sites;
      $record->sample_sites_files = $files_sample_sites_files ? $files_sample_sites_files : null;
      $record->constraints = $request->constraints;
      $record->prompt_iatext_constraints = $request->prompt_iatext_constraints;
      // $record->iatext_constraints = $request->iatext_constraints;
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

  public function updatestep3(Request $request, $id)
  {
    if ($request->ajax()) {
      $validator = Validator::make($request->all(), [
        'specification_id' => 'required|numeric',
        'competitors' => 'required|string',
        'sample_sites' => 'required|string',
        'prompt_iatext_competitors' => 'nullable|string',
        // 'iatext_competitors' => 'nullable|string',
        'sample_sites_files' => ['nullable', 'array'],
        'sample_sites_files.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,svg,webp,pdf,doc,docx'],
        'constraints' => 'nullable|string',
        'prompt_iatext_constraints' => 'nullable|string',
        // 'iatext_constraints' => 'nullable|string',
        'constraints_files' => ['nullable', 'array'],
        'constraints_files.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,svg,webp,pdf,doc,docx'],
        'domain' => 'required|string',
        'domain_name' => 'nullable|string',
        // 'logo' => 'required|string',
        // 'logo_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,svg,webp,pdf,doc,docx'],
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

      $record = ExistingAnalysis::find($id);
      $record->specification_id = $specification_id;
      $record->competitors = $request->competitors;
      $record->prompt_iatext_competitors = $request->prompt_iatext_competitors;
      // $record->iatext_competitors = $request->iatext_competitors;
      $record->sample_sites = $request->sample_sites;
      ///
      $existingSampleSitesFiles = $record->sample_sites_files ? ($record->sample_sites_files) : [];
      $newSampleSitesFiles = array_merge($existingSampleSitesFiles, $files_sample_sites_files);
      $newSampleSitesFilesJson = ($newSampleSitesFiles);
      $record->sample_sites_files = $newSampleSitesFilesJson;
      ///
      $record->constraints = $request->constraints;
      $record->prompt_iatext_constraints = $request->prompt_iatext_constraints;
      // $record->iatext_constraints = $request->iatext_constraints;
      ///
      $existingConstraintsFiles = $record->constraints_files ? ($record->constraints_files) : [];
      $newConstraintsFiles = array_merge($existingConstraintsFiles, $files_constraints_files);
      $newConstraintsFilesJson = ($newConstraintsFiles);
      $record->constraints_files = $newConstraintsFilesJson;
      ///
      // $record->constraints_files = $files_constraints_files ? $files_constraints_files : null;
      $record->domain = $request->domain;
      $record->domain_name = $request->domain_name;
      $record->hosting = $request->hosting;
      $record->hosting_name = $request->hosting_name;
      $record->save();

      return response()->json(['success' => true, 'message' => 'Record updated successfully', 'record_id' => $record->id], 201);
    } else {
      return response()->json(['message' => 'Only AJAX requests are allowed'], 400);
    }
  }

  public function deletefile(Request $request, $id)
  {


    if ($request->type == 'constraints_files') {
      $record = ExistingAnalysis::findOrFail($id);
      $dataArray = $record->constraints_files;
      $normalizedRequestValue = str_replace('\/', '/', $request->href);
      $index = array_search($normalizedRequestValue, $dataArray);
      if ($index !== false) {
        array_splice($dataArray, $index, 1);
        $record->update(['constraints_files' => $dataArray]);
        return response()->json(['success' => true]);
      } else {
        return response()->json(['success' => false, 'message' => 'Item not found in array.']);
      }
    } elseif ($request->type == 'sample_sites_files') {
      $record = ExistingAnalysis::findOrFail($id);
      $dataArray = $record->sample_sites_files;
      $normalizedRequestValue = str_replace('\/', '/', $request->href);
      $index = array_search($normalizedRequestValue, $dataArray);
      if ($index !== false) {
        array_splice($dataArray, $index, 1);
        $record->update(['sample_sites_files' => $dataArray]);
        return response()->json(['success' => true]);
      } else {
        return response()->json(['success' => false, 'message' => 'Item not found in array.']);
      }
    } elseif ($request->type == 'exemples_sites_files') {
      $record = DesignContent::findOrFail($id);
      $dataArray = $record->exemples_sites_files;
      $normalizedRequestValue = str_replace('\/', '/', $request->href);
      $index = array_search($normalizedRequestValue, $dataArray);
      if ($index !== false) {
        array_splice($dataArray, $index, 1);
        $record->update(['exemples_sites_files' => $dataArray]);
        return response()->json(['success' => true]);
      } else {
        return response()->json(['success' => false, 'message' => 'Item not found in array.']);
      }
    }
  }

  public function storestep4(Request $request)
  {

    if ($request->ajax()) {

      $validatedData = $request->validate([
        'specification_id' => 'required|numeric',
        'logo' => 'required|string',
        'logo_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,svg,webp,pdf,doc,docx'],
        'graphical_charter' => 'required|string',
        'graphical_charter_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,svg,webp,pdf,doc,docx'],
        'wireframe' => 'required|string',
        'wireframe_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,svg,webp,pdf,doc,docx'],
        'typography' => 'required|string',
        'typography_text' => 'nullable|string',
        'description_product_services' => 'required|string',
        'description_product_services_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,svg,webp,pdf,doc,docx'],
        'style_graphiques' => 'required|array',
        'style_graphiques.*' => 'required|string',
        'style_graphique_autre' => 'nullable|string',
        'number_of_propositions' => 'required|numeric',
        'color_palette' => 'nullable|string',
        'exemples_sites' => 'nullable|string',
        'exemples_sites_files' => ['nullable', 'array'],
        'exemples_sites_files.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,svg,webp,pdf,doc,docx'],
        'prompt_iatext_exemples_sites' => 'nullable|string',
        // 'iatext_exemples_sites' => 'nullable|string',
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
      // $record->iatext_exemples_sites = $validatedData['iatext_exemples_sites'];

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

  public function updatestep4(Request $request, $id)
  {

    if ($request->ajax()) {

      $validatedData = $request->validate([
        'specification_id' => 'required|numeric',
        'logo' => 'required|string',
        'logo_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,svg,webp,pdf,doc,docx'],
        'graphical_charter' => 'required|string',
        'graphical_charter_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,svg,webp,pdf,doc,docx'],
        'wireframe' => 'required|string',
        'wireframe_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,svg,webp,pdf,doc,docx'],
        'typography' => 'required|string',
        'typography_text' => 'nullable|string',
        'description_product_services' => 'required|string',
        'description_product_services_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,svg,webp,pdf,doc,docx'],
        'style_graphiques' => 'required|array',
        'style_graphiques.*' => 'required|string',
        'style_graphique_autre' => 'nullable|string',
        'number_of_propositions' => 'required|numeric',
        'color_palette' => 'nullable|string',
        'exemples_sites' => 'nullable|string',
        'exemples_sites_files' => ['nullable', 'array'],
        'exemples_sites_files.*' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,svg,webp,pdf,doc,docx'],
        'prompt_iatext_exemples_sites' => 'nullable|string',
        // 'iatext_exemples_sites' => 'nullable|string',
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

      $record = DesignContent::find($id);
      $record->specification_id = $validatedData['specification_id'];
      $record->logo = $validatedData['logo'];
      if ($logo_file_path)
        $record->logo_file = $logo_file_path;
      $record->graphical_charter = $validatedData['graphical_charter'];
      if ($graphical_charter_file_path)
        $record->graphical_charter_file = $graphical_charter_file_path;
      $record->wireframe = $validatedData['wireframe'];
      if ($wireframe_file_path)
        $record->wireframe_file = $wireframe_file_path;
      $record->typography = $validatedData['typography'];
      $record->typography_text = $validatedData['typography_text'];
      $record->description_product_services = $validatedData['description_product_services'];
      if ($description_product_services_file_path)
        $record->description_product_services_file = $description_product_services_file_path;
      $record->style_graphiques = $validatedData['style_graphiques'];
      $record->style_graphique_autre = $validatedData['style_graphique_autre'];
      $record->number_of_propositions = $validatedData['number_of_propositions'];
      $record->color_palette = $validatedData['color_palette'];
      $record->exemples_sites = $validatedData['exemples_sites'];
      //
      $existingExemplesSitesFiles = $record->exemples_sites_files ? ($record->exemples_sites_files) : [];
      $newExemplesSitesFiles = array_merge($existingExemplesSitesFiles, $successFiles_exemples_sites_files);
      $newExemplesSitesFilesJson = ($newExemplesSitesFiles);
      $record->exemples_sites_files = $newExemplesSitesFilesJson;
      // $record->save();

      // $record->exemples_sites_files = $successFiles_exemples_sites_files ? ($successFiles_exemples_sites_files) : null;
      //
      $record->prompt_iatext_exemples_sites = $validatedData['prompt_iatext_exemples_sites'];
      // $record->iatext_exemples_sites = $validatedData['iatext_exemples_sites'];

      $record->save();

      // $specification = Specification::find($request->specification_id);

      // if ($specification) {
      //   $specification->step = 4;
      //   $specification->save();
      // }

      $recordId = $record->id;
      return response()->json(['success' => true, 'message' => 'Record updated successfully', 'record_id' => $recordId], 201);
    } else {
      return response()->json(['message' => 'Only AJAX requests are allowed'], 400);
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

  public function updatestep5(Request $request, $id)
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


      $record = DeadlineAndBudget::find($id);
      $record->specification_id = $validatedData['specification_id'];
      $record->communication = $validatedData['communication'];
      $record->gestion_projet = $validatedData['gestion_projet'];
      $record->deadline = $validatedData['deadline'];
      $record->budget_from = $validatedData['budget_from'];
      $record->budget_to = $validatedData['budget_to'];
      $record->save();

      ///

      $facture = Facturation::find($request->facturation_id);
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

      // $specification = Specification::find($request->specification_id);
      // if ($specification) {
      //   $specification->step = 5;
      //   $specification->save();
      // }

      // $recordId = $record->id;
      return response()->json(['success' => true, 'message' => 'Record updated successfully'], 200);
    } else {
      return response()->json(['message' => 'Only AJAX requests are allowed'], 400);
    }
  }

  public function storestep6(Request $request)
  {
    // return $request;
    if ($request->ajax()) {
      $validatedData = $request->validate([
        'iatext_description' => 'nullable|string',
        'iatext_main_activities' => 'nullable|string',
        'iatext_services_products' => 'nullable|string',
        'iatext_target_audience' => 'nullable|string',
        'iatext_target_keywords' => 'nullable|string',
        'iatext_expected_client_objectives' => 'nullable|string',
        'iatext_menu' => 'nullable|string',
        'iatext_techniques_specs' => 'nullable|string',
        'iatext_competitors' => 'nullable|string',
        'iatext_constraints' => 'nullable|string',
        'iatext_exemples_sites' => 'nullable|string',

      ], [
        'required' => 'Le champ :attribute est requis.',
        'numeric' => 'Le champ :attribute doit être numérique.',
        'string' => 'Le champ :attribute doit être une chaîne de caractères.',
      ]);

      ///


      $specification =  Specification::find($request->specification_id);
      $specification->iatext_description = $validatedData['iatext_description'];
      $specification->iatext_main_activities = $validatedData['iatext_main_activities'];
      $specification->iatext_services_products = $validatedData['iatext_services_products'];
      $specification->iatext_target_audience = $validatedData['iatext_target_audience'];
      $specification->save();

      $objectifSite = ObjectifSite::where('specification_id', $request->specification_id)->first();
      // $objectifSite = ObjectifSite::find($request->objectif_site_id);
      $objectifSite->iatext_target_keywords = $validatedData['iatext_target_keywords'];
      $objectifSite->iatext_expected_client_objectives = $validatedData['iatext_expected_client_objectives'];
      $objectifSite->iatext_menu = $validatedData['iatext_menu'];
      $objectifSite->iatext_techniques_specs = $validatedData['iatext_techniques_specs'];
      $objectifSite->save();

      $existingAnalysis =  ExistingAnalysis::where('specification_id', $request->specification_id)->first();
      // $existingAnalysis =  ExistingAnalysis::find($request->analyse_existants_id);
      $existingAnalysis->iatext_competitors = $validatedData['iatext_competitors'];
      $existingAnalysis->iatext_constraints = $validatedData['iatext_constraints'];
      $existingAnalysis->save();

      $designContent =  DesignContent::where('specification_id', $request->specification_id)->first();
      // $designContent =  DesignContent::find($request->specification_id);
      $designContent->iatext_exemples_sites = $validatedData['iatext_exemples_sites'];
      $designContent->save();



      // return 'Specification email sent successfully!';

      sleep(1);

      $directory = "";
      $filename = "";
      if ($specification) {
        $pdf = PDF::loadView('content.pdf.index', compact('specification'));

        // Specify the directory where you want to save the PDF file
        $directory = 'assets/pdf/specifications/';

        // Generate a unique filename
        $filename = 'pdf' . uniqid() . '.pdf';

        // Save the PDF to the specified directory
        $pdf->save($directory . $filename);

        // Return the path to the saved PDF file
        // return $directory . $filename;
      }

      $specification =  Specification::find($request->specification_id);
      $specification->pdf_link = $directory . $filename;
      $specification->save();

      sleep(1);

      $specification = Specification::with('objectif_site', 'existing_analysis', 'design_content', 'deadline_and_budget', 'facturation')->findOrFail($request->specification_id);

      // Send the email
      $user = auth()->user();
      Mail::to($user->email)->send(new SpecificationMail($specification));

      ///

      // Assuming $notification is an instance of Notification model
      $notification = new Notification();

      //
      $userId = auth()->user()->id;
      $message  = 'Nouveau cahier des charges';
      $pdfLink = $specification->pdf_link;
      $specificationId = $specification->id;

      // Call the sendNotification method
      $notification->sendNotification($userId, $message, $pdfLink, $specificationId);


      return response()->json(['success' => true, 'message' => 'Record created successfully', 'pdf' => $specification->pdf_link], 201);
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
        // $fileName = pathinfo($fileName, PATHINFO_FILENAME) . '_' . uniqid() . '.' . $extension;
        $fileName =  uniqid() . '.' . $extension;
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
      // $fileName = pathinfo($fileName, PATHINFO_FILENAME) . '_' . uniqid() . '.' . $extension;
      $fileName =  uniqid() . '.' . $extension;
      $file->move($destinationPath, $fileName);
      return $destinationPath . '/' . $fileName;
    }

    return '';
  }
}
