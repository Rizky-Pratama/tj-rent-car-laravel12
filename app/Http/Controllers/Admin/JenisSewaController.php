<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisSewa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JenisSewaController extends Controller
{
    public function index(Request $request)
    {
        $query = JenisSewa::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_jenis', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        // Calculate stats
        $stats = [
            'total' => JenisSewa::count(),
            'aktif' => JenisSewa::whereHas('hargaSewa', function($q) {
                $q->where('aktif', true);
            })->count(),
            'dengan_denda' => JenisSewa::whereNotNull('tarif_denda_per_hari')->count(),
            'tanpa_denda' => JenisSewa::whereNull('tarif_denda_per_hari')->count(),
        ];

        $jenisSewa = $query->withCount(['hargaSewa as total_mobil' => function($q) {
            $q->where('aktif', true);
        }])->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.jenis-sewa.index', compact('jenisSewa', 'stats'));
    }

    public function show(JenisSewa $jenisSewa)
    {
        $jenisSewa->load(['hargaSewa.mobil']);
        return view('admin.jenis-sewa.show', compact('jenisSewa'));
    }

    public function create()
    {
        return view('admin.jenis-sewa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jenis' => 'required|string|max:255|unique:jenis_sewa',
            'deskripsi' => 'nullable|string',
            'tarif_denda_per_hari' => 'nullable|integer|min:0',
        ]);

        // Generate slug from nama_jenis
        $validated['slug'] = Str::slug($validated['nama_jenis']);

        // Ensure slug is unique
        $counter = 1;
        $originalSlug = $validated['slug'];
        while (JenisSewa::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $originalSlug . '-' . $counter++;
        }

        JenisSewa::create($validated);

        return redirect()->route('admin.jenis-sewa.index')
            ->with('success', 'Jenis sewa berhasil ditambahkan!');
    }

    public function edit(JenisSewa $jenisSewa)
    {
        return view('admin.jenis-sewa.edit', compact('jenisSewa'));
    }

    public function update(Request $request, JenisSewa $jenisSewa)
    {
        $validated = $request->validate([
            'nama_jenis' => 'required|string|max:255|unique:jenis_sewa,nama_jenis,' . $jenisSewa->id,
            'deskripsi' => 'nullable|string',
            'tarif_denda_per_hari' => 'nullable|integer|min:0',
        ]);

        // Update slug if nama_jenis changed
        if ($validated['nama_jenis'] !== $jenisSewa->nama_jenis) {
            $validated['slug'] = Str::slug($validated['nama_jenis']);

            // Ensure slug is unique
            $counter = 1;
            $originalSlug = $validated['slug'];
            while (JenisSewa::where('slug', $validated['slug'])->where('id', '!=', $jenisSewa->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter++;
            }
        }

        $jenisSewa->update($validated);

        return redirect()->route('admin.jenis-sewa.index')
            ->with('success', 'Jenis sewa berhasil diperbarui!');
    }

    public function destroy(JenisSewa $jenisSewa)
    {
        // Check if jenis sewa has active pricing
        if ($jenisSewa->hargaSewa()->where('aktif', true)->count() > 0) {
            return redirect()->route('admin.jenis-sewa.index')
                ->with('error', 'Tidak dapat menghapus jenis sewa yang masih memiliki harga aktif!');
        }

        $jenisSewa->delete();

        return redirect()->route('admin.jenis-sewa.index')
            ->with('success', 'Jenis sewa berhasil dihapus!');
    }
}
