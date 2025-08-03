<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {

        $data = Material::where('status', 'published')->limit(6)->get();

        return view('Dashboard', [
            'data' => $data
        ]);
    }

    public function about() {
        return view('About');
    }

    public function course(){
        $data = Material::where('status', 'published')->get();
        return view('Course', [
            'data'=> $data
        ]);
    }

    public function instruktur(){
        return view('Instructors');
    }

    public function contact(){
        return view('Contact');
    }
}
