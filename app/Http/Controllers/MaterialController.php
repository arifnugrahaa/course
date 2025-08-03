<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $query = Material::with('creator');

        if (auth()->user()->isAdmin()) {
            $materials = $query->orderBy('created_at', 'desc')->paginate(10);
        } else {
            $materials = $query->where(function($q) {
                $q->where('created_by', auth()->id());
                //   ->orWhere('status', 'published');
            })->orderBy('created_at', 'desc')->paginate(10);
        }

        return view('materials.index', compact('materials'));
    }

    public function create()
    {
        return view('materials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'type' => 'required|in:article,image,pdf,audio,video',
            'file' => 'nullable|file|max:102400', // 100MB max
            'fileThumbnail' => 'required|file|max:102400', // 100MB max
            'action' => 'required|in:save_draft,submit_review',
        ]);

        $material = new Material();
        $material->title = $validated['title'];
        $material->description = $validated['description'];
        $material->content = $validated['content'];
        $material->type = $validated['type'];
        $material->created_by = auth()->id();

        if (auth()->user()->isAdmin()) {
            $material->status = $validated['action'] === 'submit_review' ? 'published' : 'draft';
            if ($material->status === 'published') {
                $material->approved_by = auth()->id();
                $material->approved_at = now();
            }
        } else {
            $material->status = $validated['action'] === 'submit_review' ? 'pending' : 'draft';
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . Str::slug($validated['title']) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('materials', $fileName, 'public');

            $material->file_path = $filePath;
            $material->file_name = $file->getClientOriginalName();
            $material->file_size = $file->getSize();

            // if ($validated['type'] === 'image') {
            //     $material->thumbnail = $filePath;
            // }
        }
        if ($request->hasFile('fileThumbnail')) {
            $file = $request->file('fileThumbnail');
            $fileName = time() . '_' . Str::slug($validated['title']) . '_thumbnail.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('materials', $fileName, 'public');

            $material->thumbnail = $filePath;
        }

        $material->save();

        $message = match($material->status) {
            'draft' => 'Material saved as draft.',
            'pending' => 'Material submitted for review. Admin will review it soon.',
            'published' => 'Material published successfully!',
            default => 'Material created successfully!'
        };

        return redirect()->route('materials.index')->with('success', $message);
    }

    public function show(Material $material)
    {
        if ($material->status === 'draft' && $material->created_by !== auth()->id()) {
            abort(403, 'You cannot view this draft material.');
        }

        if ($material->status === 'pending' && $material->created_by !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'This material is pending review.');
        }

        if ($material->status === 'rejected' && $material->created_by !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'This material has been rejected.');
        }

        return view('materials.show', compact('material'));
    }

    public function edit(Material $material)
    {
        if ($material->created_by !== auth()->id()) {
            abort(403);
        }

        return view('materials.edit', compact('material'));
    }

    public function update(Request $request, Material $material)
    {
        if ($material->created_by !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'type' => 'required|in:article,image,pdf,audio,video',
            'file' => 'nullable|file|max:102400',
            'fileThumbnail' => 'required|file|max:102400',
            'action' => 'required|in:save_draft,submit_review',
        ]);

        $material->title = $validated['title'];
        $material->description = $validated['description'];
        $material->content = $validated['content'];
        $material->type = $validated['type'];

        if (auth()->user()->isAdmin()) {
            $material->status = $validated['action'] === 'submit_review' ? 'published' : 'draft';
            if ($material->status === 'published' && !$material->approved_at) {
                $material->approved_by = auth()->id();
                $material->approved_at = now();
            }
        } else {
            if ($material->status === 'rejected' && $validated['action'] === 'submit_review') {
                $material->status = 'pending';
                $material->rejection_reason = null;
            } else {
                $material->status = $validated['action'] === 'submit_review' ? 'pending' : 'draft';
            }
        }

        if ($request->hasFile('file')) {
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . Str::slug($validated['title']) . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('materials', $fileName, 'public');

            $material->file_path = $filePath;
            $material->file_name = $file->getClientOriginalName();
            $material->file_size = $file->getSize();
        }
        if ($request->hasFile('fileThumbnail')) {
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }

            $file = $request->file('fileThumbnail');
            $fileName = time() . '_' . Str::slug($validated['title']) . '_thumbnail.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('materials', $fileName, 'public');

            $material->thumbnail = $filePath;
        }

        $material->save();

        $message = match($material->status) {
            'draft' => 'Material updated and saved as draft.',
            'pending' => 'Material updated and submitted for review.',
            'published' => 'Material updated and published!',
            default => 'Material updated successfully!'
        };

        return redirect()->route('materials.index')->with('success', $message);
    }

    public function destroy(Material $material)
    {
        if ($material->created_by !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return redirect()->route('materials.index')->with('success', 'Material berhasil dihapus!');
    }

    public function approve(Request $request, Material $material)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $material->update([
            'status' => 'published',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejection_reason' => null,
        ]);

        return back()->with('success', 'Material has been approved and published!');
    }

    public function reject(Request $request, Material $material)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        Material::where('id', $request->id)
                ->update([
                    'status' => 'rejected',
                    'rejection_reason' => $request->rejection_reason,
                ]);

        return back()->with('success', 'Material has been rejected with feedback.');
    }
}
