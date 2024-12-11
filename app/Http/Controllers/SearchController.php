<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
  public function searchView(Request $request)
  {
    $searchTerm = $request->input('search');
    if (Auth::check()) {
      if (!Auth::user()->is_admin) {
        return view('search.search')->with([
          'searchTerm' => $searchTerm,
          'categories' => $this->getCategories(),
        ]);
      } else {
        return view('pages.admin.search.search')->with([
          'searchTerm' => $searchTerm,
          'categories' => $this->getCategories(),
        ]);
      }
    } else {
      return view('pages.admin.search.search')->with([
        'searchTerm' => $searchTerm,
        'categories' => $this->getCategories(),
      ]);
    }
  }
}
