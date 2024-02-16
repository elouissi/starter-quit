<?php

namespace App\Http\Controllers;

use App\Models\Prompt;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PromptController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
    return view('content.config.prompts.index');
  }

  public function indexDataTable()
  {
    //
    $prompts = Prompt::get();

    return DataTables::of($prompts)
      ->addColumn('actions', function ($prompt) {
        return '<button class="btn btn-icon btn-primary edit-function" data-id="' . $prompt->id . '"
          type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEditRecord" aria-controls="offcanvasEditRecord"
          ">
                    <i class="ti ti-pencil"></i>
                </button>
                <button class="btn btn-icon btn-danger delete-function"  data-id="' . $prompt->id . '">
                    <i class="ti ti-trash"></i>
                </button>';
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
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
    if ($request->ajax()) {
      // Validate the incoming request data
      $validatedData = $request->validate([
        'name' => 'required|string|min:2|max:255',
        'order' => 'required|numeric',
        'type' => 'required|string',
      ], [
        'name.required' => 'Le champ nom est requis.',
        'name.string' => 'Le champ nom doit être une chaîne de caractères.',
        'name.min' => 'Le champ nom doit contenir au moins :min caractères.',
        'name.max' => 'Le champ nom ne doit pas dépasser :max caractères.',
        'order.required' => 'Le champ ordre est requis.',
        'order.numeric' => 'Le champ ordre doit être numérique.',
        'type.required' => 'Le champ type est requis.',
      ]);

      // Create a new instance of your model with the validated data
      $record = new Prompt();
      $record->name = $validatedData['name'];
      $record->order = $validatedData['order'];
      $record->type = $validatedData['type'];
      // Set other fields as needed

      // Save the record
      try {
        $record->save();
        // Return a response to indicate success
        return response()->json(['success' => true, 'message' => 'Record created successfully'], 201);
      } catch (\Exception $e) {
        // Handle any exceptions (e.g., database errors)
        return response()->json(['success' => false, 'message' => 'Error creating record', 'e' => $e], 200);
      }
    } else {
      // Handle non-AJAX requests
      return response()->json(['message' => 'Only AJAX requests are allowed'], 400);
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(Prompt $prompt)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Request $request)
  {
    //
    if ($request->ajax()) {
      $prompt = Prompt::find($request->id);
      return response()->json(['result' => $prompt]);
    }
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    //
    if ($request->ajax()) {
      // Validate the incoming request data
      $validatedData = $request->validate([
        'name' => 'required|string|min:2|max:255',
        'order' => 'required|numeric|min:1',
        'type' => 'required|string',
      ], [
        'name.required' => 'Le champ nom est requis.',
        'name.string' => 'Le champ nom doit être une chaîne de caractères.',
        'name.min' => 'Le champ nom doit contenir au moins :min caractères.',
        'name.max' => 'Le champ nom ne doit pas dépasser :max caractères.',
        'order.required' => 'Le champ ordre est requis.',
        'order.numeric' => 'Le champ ordre doit être numérique.',
        'order.min' => 'Le champ ordre doit être supérieur à 0.',
        'type.required' => 'Le champ type est requis.',
      ]);

      try {
        // Find the record with the given ID
        $record = Prompt::findOrFail($id);

        // Update the record with the validated data
        $record->name = $validatedData['name'];
        $record->order = $validatedData['order'];
        // Update other fields as needed

        $record->save();

        // Return a response to indicate success
        return response()->json(['success' => true, 'message' => 'Record updated successfully'], 200);
      } catch (\Exception $e) {
        // Handle any exceptions (e.g., database errors or record not found)
        return response()->json(['success' => false, 'message' => 'Error updating record', 'e' => $e], 200);
      }
    } else {
      // Handle non-AJAX requests
      return response()->json(['message' => 'Only AJAX requests are allowed'], 400);
    }
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request)
  {
    //
    if ($request->ajax()) {
      $prompt = Prompt::findOrFail($request->id);
      $prompt->delete(); // Soft delete
      return response()->json(['success' => true]);
    }
  }
}
