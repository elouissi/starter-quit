<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
    return view('content.users.index');

  }

  public function indexDataTable()
  {
    //
    // $users = User::get();

    // return DataTables::of($users)->make(true);
    return DataTables::of(User::query())
      ->addColumn('status_icon', function (User $user) {
        if ($user->status) {
          return '<p><i class="fs-2 text-success ti ti-shield-check"></i></p>';
        }
        if (!$user->status) {
          return '<p><i class="fs-2 text-danger ti ti-shield-x"></i></p>';
        }
        // if ($specification->step == 1 || $specification->step == 2 || $specification->step == 3 || $specification->step == 4) {
        //   return '<span class="badge rounded-pill bg-label-danger">' . $specification->step * 20 . ' %</span>';
        // } elseif ($specification->step == 5) {
        //   return '<span class="badge rounded-pill bg-label-success">terminé</span>';
        // }
      })
      ->rawColumns(['status_icon'])
      ->make(true);
  }

  public function suspend(Request $request, User $user)
  {
    // Logic to suspend the user
    $user->update(['status' => false]);

    if ($request->ajax()) {
      return response()->json(['success' => true, 'message' => 'User suspended successfully.']);
    } else {
      return redirect()->back()->with('success', 'User suspended successfully.');
    }
  }

  public function unsuspend(Request $request, User $user)
  {
    // Logic to suspend the user
    $user->update(['status' => true]);

    if ($request->ajax()) {
      return response()->json(['success' => true, 'message' => 'User unsuspended successfully.']);
    } else {
      return redirect()->back()->with('success', 'User suspended successfully.');
    }
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
    return view('content.users.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
    // Validation des données du formulaire
    $messages = [
      'required' => 'Le champ :attribute est requis.',
      'string' => 'Le champ :attribute doit être une chaîne de caractères.',
      'email' => 'Le champ :attribute doit être une adresse email valide.',
      'unique' => 'La valeur du champ :attribute est déjà utilisée.',
      'confirmed' => 'La confirmation du champ :attribute ne correspond pas.',
      'min' => [
          'string' => 'Le champ :attribute doit contenir au moins :min caractères.',
      ],
      'max' => [
          'string' => 'Le champ :attribute ne peut pas dépasser :max caractères.',
      ],
  ];

  $validatedData = $request->validate([
      'username' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|string|min:6|confirmed',
  ], $messages);

    // Création d'un nouvel utilisateur
    $user = User::create([
      'name' => $validatedData['username'],
      'email' => $validatedData['email'],
      'password' => bcrypt($validatedData['password']),
    ]);

    // Redirection vers une page appropriée après la création
    return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
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
}
