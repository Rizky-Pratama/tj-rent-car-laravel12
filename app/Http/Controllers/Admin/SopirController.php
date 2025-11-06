<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sopir;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SopirController extends Controller
{
    public function index(Request $request)
    {
        $query = Sopir::query();

        // Search functionality
        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%")
                  ->orWhere('no_sim', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $sopirs = $query->orderBy('created_at', 'desc')->paginate(10);

        // Get stats
        $stats = [
            'total' => Sopir::count(),
            'available' => Sopir::where('status', 'tersedia')->count(),
            'assigned' => Sopir::where('status', 'ditugaskan')->count(),
            'on_leave' => Sopir::where('status', 'libur')->count()
        ];

        return view('admin.sopir.index', compact('sopirs', 'stats'));
    }

    public function show(Sopir $sopir)
    {
        return view('admin.sopir.show', compact('sopir'));
    }

    public function create()
    {
        return view('admin.sopir.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:30',
            'no_sim' => 'required|string|max:50|unique:sopir',
            'status' => 'required|in:tersedia,ditugaskan,libur',
            'catatan' => 'nullable|string',
        ]);

        Sopir::create($validated);

        return redirect()->route('admin.sopir.index')
            ->with('success', 'Sopir berhasil dibuat!');
    }

    public function edit(Sopir $sopir)
    {
        return view('admin.sopir.edit', compact('sopir'));
    }

    public function update(Request $request, Sopir $sopir)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:30',
            'no_sim' => ['required', 'string', 'max:50', Rule::unique('sopir')->ignore($sopir->id)],
            'status' => 'required|in:tersedia,ditugaskan,libur',
            'catatan' => 'nullable|string',
        ]);

        $sopir->update($validated);

        return redirect()->route('admin.sopir.index')
            ->with('success', 'Sopir berhasil diperbarui!');
    }

    public function destroy(Sopir $sopir)
    {
        $sopir->delete();

        return redirect()->route('admin.sopir.index')
            ->with('success', 'Sopir berhasil dihapus!');
    }
}
