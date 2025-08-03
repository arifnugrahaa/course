<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {

            $totalUsers = User::where('role', 'user')->count();
            $totalAdmins = User::where('role', 'admin')->count();
            $totalMaterials = Material::count();
            $publishedMaterials = Material::where('status', 'published')->count();
            $pendingMaterials = Material::where('status', 'pending')->count();
            $rejectedMaterials = Material::where('status', 'rejected')->count();

            return view('admin.dashboard', compact(
                'totalUsers',
                'totalAdmins',
                'totalMaterials',
                'publishedMaterials',
                'pendingMaterials',
                'rejectedMaterials'
            ));
        }

        return view('user.dashboard');
    }
}
