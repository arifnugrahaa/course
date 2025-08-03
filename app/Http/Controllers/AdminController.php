<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Material;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
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

    public function users()
    {
        $users = User::where('role', 'user')->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function pendingMaterials()
    {
        $pendingMaterials = Material::with('creator')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.pending-materials', compact('pendingMaterials'));
    }
}
