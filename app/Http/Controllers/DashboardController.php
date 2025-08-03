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
        return view('about');
    }

    public function course(){
        $data = Material::where('status', 'published')->get();
        return view('course', [
            'data'=> $data
        ]);
    }

    public function instruktur(){
        return view('instructors');
    }

    public function contact(){
        return view('contact');
    }
}
