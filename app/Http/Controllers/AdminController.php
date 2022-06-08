<?php

namespace App\Http\Controllers;

use App\Models\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    public function index()
    {
        View::share('title', 'Home');
        return view('admin.index')->with([
            'providers'=>ServiceProvider::all()->toArray(),
            ]);
    }
}
