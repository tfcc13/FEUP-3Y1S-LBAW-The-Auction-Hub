<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
  public function searchView(Request $request)
  {
    $searchTerm = $request->input('search');

    return view('search.search')->with([
      'searchTerm' => $searchTerm,
      'categories' => $this->getCategories(),
    ]);
  }
}
