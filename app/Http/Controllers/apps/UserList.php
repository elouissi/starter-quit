<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserList extends Controller
{
  public function index()
  {
    return view('content.users.index');
  }
}
