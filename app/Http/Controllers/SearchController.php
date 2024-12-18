<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function searchDash(Request $request)
    {
        return app(AdminController::class)->dashboardUsers($request);
    }
    public function searchAuctions(Request $request)
    {
        return app(AdminController::class)->dashboardAuctions($request);
    }
}
