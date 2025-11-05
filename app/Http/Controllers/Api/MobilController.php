<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MobilController extends Controller
{
    /**
     * Display a listing of mobil
     */
    public function index(Request $request): JsonResponse
    {
        $query = Mobil::with(['hargaSewa.jenisSewa']);

        // Filter by availability
        if ($request->has('available')) {
            $query->where('status', 'tersedia');
        }

        // Filter by capacity
        if ($request->has('kapasitas')) {
            $query->where('kapasitas', '>=', $request->kapasitas);
        }

        // Search by name/merk
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_mobil', 'like', "%{$search}%")
                  ->orWhere('merk', 'like', "%{$search}%");
            });
        }

        $mobil = $query->get();

        return response()->json([
            'status' => 'success',
            'data' => $mobil
        ]);
    }
}
