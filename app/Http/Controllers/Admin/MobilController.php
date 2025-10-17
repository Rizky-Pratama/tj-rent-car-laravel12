<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use App\Models\JenisSewa;
use App\Models\HargaSewa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class MobilController extends Controller
{
    public function index(Request $request)
    {
        $query = Mobil::query();

        // Search functionality
        if ($search = $request->get('search')) {
            $query->where(function($q) use ($search) {
                $q->where('nama_mobil', 'like', "%{$search}%")
                  ->orWhere('merk', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('plat_nomor', 'like', "%{$search}%")
                  ->orWhere('warna', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        // Filter by brand
        if ($brand = $request->get('brand')) {
            $query->where('merk', $brand);
        }

        // Filter by transmission
        if ($transmisi = $request->get('transmisi')) {
            $query->where('transmisi', $transmisi);
        }

        $mobils = $query->with(['hargaSewa.jenisSewa'])->orderBy('created_at', 'desc')->paginate(10);

        // Get brands for filter dropdown
        $brands = Mobil::distinct('merk')->orderBy('merk')->pluck('merk');

        // Get stats
        $stats = [
            'total' => Mobil::count(),
            'available' => Mobil::where('status', 'tersedia')->count(),
            'rented' => Mobil::where('status', 'disewa')->count(),
            'maintenance' => Mobil::where('status', 'perawatan')->count(),
            'inactive' => Mobil::where('status', 'nonaktif')->count()
        ];

        return view('admin.mobil.index', compact('mobils', 'brands', 'stats'));
    }

    public function show(Mobil $mobil)
    {
        $mobil->load('transaksi.pelanggan');
        return view('admin.mobil.show', compact('mobil'));
    }

    public function create()
    {
        return view('admin.mobil.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_mobil' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'plat_nomor' => 'required|string|max:50|unique:mobil',
            'warna' => 'required|string|max:50',
            'kapasitas_penumpang' => 'required|integer|min:1|max:50',
            'transmisi' => 'required|in:manual,automatic,cvt',
            'jenis_bahan_bakar' => 'required|in:bensin,diesel,listrik,hybrid',
            'status' => 'required|in:tersedia,disewa,perawatan,nonaktif',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('mobil', 'public');
        }

        Mobil::create($validated);

        return redirect()->route('admin.mobil.index')
            ->with('success', 'Mobil berhasil ditambahkan!');
    }

    public function edit(Mobil $mobil)
    {
        return view('admin.mobil.edit', compact('mobil'));
    }

    public function update(Request $request, Mobil $mobil)
    {
        $validated = $request->validate([
            'nama_mobil' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'plat_nomor' => ['required', 'string', 'max:50', Rule::unique('mobil')->ignore($mobil->id)],
            'warna' => 'required|string|max:50',
            'kapasitas_penumpang' => 'required|integer|min:1|max:50',
            'transmisi' => 'required|in:manual,automatic,cvt',
            'jenis_bahan_bakar' => 'required|in:bensin,diesel,listrik,hybrid',
            'status' => 'required|in:tersedia,disewa,perawatan,nonaktif',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($mobil->foto && \Storage::disk('public')->exists($mobil->foto)) {
                \Storage::disk('public')->delete($mobil->foto);
            }
            $validated['foto'] = $request->file('foto')->store('mobil', 'public');
        }

        $mobil->update($validated);

        return redirect()->route('admin.mobil.index')
            ->with('success', 'Mobil berhasil diperbarui!');
    }

    public function destroy(Mobil $mobil)
    {
        // Check if mobil has transactions
        if ($mobil->transaksi()->count() > 0) {
            return redirect()->route('admin.mobil.index')
                ->with('error', 'Tidak dapat menghapus mobil yang memiliki riwayat transaksi!');
        }

        // Delete photo if exists
        if ($mobil->foto && Storage::disk('public')->exists($mobil->foto)) {
            Storage::disk('public')->delete($mobil->foto);
        }

        $mobil->delete();

        return redirect()->route('admin.mobil.index')
            ->with('success', 'Mobil berhasil dihapus!');
    }

    /**
     * Pricing management for specific mobil
     */
    public function pricing(Mobil $mobil)
    {
        $mobil->load(['hargaSewa.jenisSewa']);
        $jenisSewa = JenisSewa::orderBy('nama_jenis')->get();

        // Get existing pricing
        $existingPricing = $mobil->hargaSewa->keyBy('jenis_sewa_id');

        // Calculate pricing statistics
        $stats = [
            'total_jenis' => $jenisSewa->count(),
            'aktif' => $existingPricing->where('aktif', true)->count(),
            'nonaktif' => $existingPricing->where('aktif', false)->count(),
            'belum_diatur' => $jenisSewa->count() - $existingPricing->count(),
            'harga_terendah' => $existingPricing->where('aktif', true)->min('harga_per_hari'),
            'harga_tertinggi' => $existingPricing->where('aktif', true)->max('harga_per_hari'),
            'rata_rata_harga' => $existingPricing->where('aktif', true)->avg('harga_per_hari'),
        ];

        return view('admin.mobil.pricing', compact('mobil', 'jenisSewa', 'existingPricing', 'stats'));
    }

    /**
     * Update pricing for specific mobil
     */
    public function updatePricing(Request $request, Mobil $mobil)
    {
        // Custom validation to ensure prices are provided for active items
        $request->validate([
            'pricing' => 'required|array',
            'pricing.*.jenis_sewa_id' => 'required|exists:jenis_sewa,id',
        ]);

        $pricingData = $request->input('pricing', []);
        $activeCount = 0;
        $errors = [];

        // Validate each pricing item
        foreach ($pricingData as $index => $pricing) {
            $isActive = isset($pricing['aktif']) && $pricing['aktif'] == '1';

            if ($isActive) {
                $activeCount++;

                // Validate required price for active items
                if (empty($pricing['harga_per_hari']) || $pricing['harga_per_hari'] < 50000) {
                    $jenisSewaId = $pricing['jenis_sewa_id'];
                    $jenisSewa = JenisSewa::find($jenisSewaId);
                    $errors[] = "Harga untuk {$jenisSewa->nama_jenis} minimal Rp 50.000";
                }

                // Validate notes length
                if (isset($pricing['catatan']) && strlen($pricing['catatan']) > 500) {
                    $jenisSewaId = $pricing['jenis_sewa_id'];
                    $jenisSewa = JenisSewa::find($jenisSewaId);
                    $errors[] = "Catatan untuk {$jenisSewa->nama_jenis} maksimal 500 karakter";
                }
            }
        }

        // Check if at least one pricing is active
        if ($activeCount === 0) {
            return redirect()->back()
                ->withErrors(['pricing' => 'Minimal satu jenis sewa harus diaktifkan'])
                ->withInput();
        }

        // Return validation errors if any
        if (!empty($errors)) {
            return redirect()->back()
                ->withErrors(['pricing' => $errors])
                ->withInput();
        }

        // Process and save the pricing data
        $updatedCount = 0;

        foreach ($pricingData as $pricing) {
            $isActive = isset($pricing['aktif']) && $pricing['aktif'] == '1';

            if ($isActive && !empty($pricing['harga_per_hari'])) {
                HargaSewa::updateOrCreate(
                    [
                        'mobil_id' => $mobil->id,
                        'jenis_sewa_id' => $pricing['jenis_sewa_id']
                    ],
                    [
                        'harga_per_hari' => (int) $pricing['harga_per_hari'],
                        'aktif' => true,
                        'catatan' => $pricing['catatan'] ?? null,
                    ]
                );
                $updatedCount++;
            } else {
                // Deactivate if exists
                HargaSewa::where([
                    'mobil_id' => $mobil->id,
                    'jenis_sewa_id' => $pricing['jenis_sewa_id']
                ])->update(['aktif' => false]);
            }
        }

        $message = "Berhasil mengatur {$updatedCount} jenis sewa untuk {$mobil->merk} {$mobil->model}";

        return redirect()->route('admin.mobil.pricing', $mobil)
            ->with('success', $message);
    }

    /**
     * Delete specific pricing
     */
    public function deletePricing(Mobil $mobil, HargaSewa $hargaSewa)
    {
        // Ensure the pricing belongs to this mobil
        if ($hargaSewa->mobil_id !== $mobil->id) {
            abort(403, 'Unauthorized action.');
        }

        $hargaSewa->delete();

        return redirect()->route('admin.mobil.pricing', $mobil)
            ->with('success', 'Harga sewa berhasil dihapus!');
    }
}
