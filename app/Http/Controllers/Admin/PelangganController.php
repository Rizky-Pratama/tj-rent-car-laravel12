<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelanggan::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%")
                  ->orWhere('no_ktp', 'like', "%{$search}%");
            });
        }

        // Filter by jenis kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // Calculate stats
        $stats = [
            'total' => Pelanggan::count(),
            'pria' => Pelanggan::where('jenis_kelamin', 'L')->count(),
            'wanita' => Pelanggan::where('jenis_kelamin', 'P')->count(),
            'aktif' => Pelanggan::whereHas('transaksi', function($q) {
                $q->whereIn('status', ['berlangsung', 'selesai']);
            })->count(),
        ];

        $pelanggan = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.pelanggan.index', compact('pelanggan', 'stats'));
    }

    public function show(Pelanggan $pelanggan)
    {
        $pelanggan->load('transaksi.mobil');
        return view('admin.pelanggan.show', compact('pelanggan'));
    }

    public function create()
    {
        return view('admin.pelanggan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:pelanggan',
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
            'no_ktp' => 'required|string|max:20|unique:pelanggan',
            'no_sim' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        Pelanggan::create($validated);

        return redirect()->route('admin.pelanggan.index')
            ->with('success', 'Pelanggan berhasil dibuat!');
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view('admin.pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('pelanggan')->ignore($pelanggan->id)],
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
            'no_ktp' => ['required', 'string', 'max:20', Rule::unique('pelanggan')->ignore($pelanggan->id)],
            'no_sim' => 'required|string|max:20',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        $pelanggan->update($validated);

        return redirect()->route('admin.pelanggan.index')
            ->with('success', 'Pelanggan berhasil diperbarui!');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        // Check if pelanggan has transactions
        if ($pelanggan->transaksi()->count() > 0) {
            return redirect()->route('admin.pelanggan.index')
                ->with('error', 'Tidak dapat menghapus pelanggan yang memiliki riwayat transaksi!');
        }

        $pelanggan->delete();

        return redirect()->route('admin.pelanggan.index')
            ->with('success', 'Pelanggan berhasil dihapus!');
    }
}
