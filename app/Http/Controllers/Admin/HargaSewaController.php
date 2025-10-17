<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HargaSewa;
use App\Models\JenisSewa;
use App\Models\Mobil;
use Illuminate\Http\Request;

class HargaSewaController extends Controller
{
    public function index(Request $request)
    {
        $query = HargaSewa::with(['jenisSewa', 'mobil']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('jenisSewa', function ($subQ) use ($search) {
                    $subQ->where('nama_jenis', 'like', "%{$search}%");
                })
                ->orWhereHas('mobil', function ($subQ) use ($search) {
                    $subQ->where('merk', 'like', "%{$search}%")
                         ->orWhere('model', 'like', "%{$search}%")
                         ->orWhere('no_plat', 'like', "%{$search}%");
                });
            });
        }

        // Filter by jenis sewa
        if ($request->filled('jenis_sewa_id')) {
            $query->where('jenis_sewa_id', $request->jenis_sewa_id);
        }

        // Filter by mobil
        if ($request->filled('mobil_id')) {
            $query->where('mobil_id', $request->mobil_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('aktif', true);
            } else {
                $query->where('aktif', false);
            }
        }

        $hargaSewa = $query->orderBy('created_at', 'desc')->paginate(10);
        $jenisSewa = JenisSewa::all();
        $mobils = Mobil::orderBy('merk')->orderBy('model')->get();

        return view('admin.harga-sewa.index', compact('hargaSewa', 'jenisSewa', 'mobils'));
    }

    public function show(HargaSewa $hargaSewa)
    {
        $hargaSewa->load(['jenisSewa', 'mobil']);
        return view('admin.harga-sewa.show', compact('hargaSewa'));
    }

    public function create()
    {
        $jenisSewa = JenisSewa::all();
        $mobils = Mobil::orderBy('merk')->orderBy('model')->get();
        return view('admin.harga-sewa.create', compact('jenisSewa', 'mobils'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mobil_id' => 'required|exists:mobil,id',
            'jenis_sewa_id' => 'required|exists:jenis_sewa,id|unique:harga_sewa,jenis_sewa_id,NULL,id,mobil_id,' . $request->mobil_id,
            'harga_per_hari' => 'required|integer|min:0',
            'aktif' => 'boolean',
            'catatan' => 'nullable|string|max:500',
        ]);

        $validated['aktif'] = $request->has('aktif');

        HargaSewa::create($validated);

        return redirect()->route('admin.harga-sewa.index')
            ->with('success', 'Harga sewa berhasil dibuat!');
    }

    public function edit(HargaSewa $hargaSewa)
    {
        $jenisSewa = JenisSewa::all();
        $mobils = Mobil::orderBy('merk')->orderBy('model')->get();
        return view('admin.harga-sewa.edit', compact('hargaSewa', 'jenisSewa', 'mobils'));
    }

    public function update(Request $request, HargaSewa $hargaSewa)
    {
        $validated = $request->validate([
            'mobil_id' => 'required|exists:mobil,id',
            'jenis_sewa_id' => 'required|exists:jenis_sewa,id|unique:harga_sewa,jenis_sewa_id,' . $hargaSewa->id . ',id,mobil_id,' . $request->mobil_id,
            'harga_per_hari' => 'required|integer|min:0',
            'aktif' => 'boolean',
            'catatan' => 'nullable|string|max:500',
        ]);

        $validated['aktif'] = $request->has('aktif');

        $hargaSewa->update($validated);

        return redirect()->route('admin.harga-sewa.index')
            ->with('success', 'Harga sewa berhasil diperbarui!');
    }

    public function destroy(HargaSewa $hargaSewa)
    {
        $hargaSewa->delete();

        return redirect()->route('admin.harga-sewa.index')
            ->with('success', 'Harga sewa berhasil dihapus!');
    }
}
