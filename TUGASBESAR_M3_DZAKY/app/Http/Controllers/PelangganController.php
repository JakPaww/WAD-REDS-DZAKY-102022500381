<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pelanggan::query();

        if ($request->filled('cari')) {
            $query->where('nama', 'like', '%' . $request->cari . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('level_member')) {
            $query->where('level_member', $request->level_member);
        }

        $pelanggans = $query->get();
        $totalPelanggan = Pelanggan::count();

        return view(
            'pelanggan.index',compact('pelanggans', 'totalPelanggan')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pelanggan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'level_member' => 'required|in:Basic,Gold,VIP',
        ]);

        $data['status'] = 'Aktif';

        Pelanggan::create($data);

        return redirect()
            ->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $semuaPelanggan = Pelanggan::all();

        return view(
            'pelanggan.show',
            compact('pelanggan', 'semuaPelanggan')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        return view('pelanggan.edit', compact('pelanggan'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'level_member' => 'required|in:Basic,Gold,VIP',
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update($data);

        return redirect()
            ->route('pelanggan.index')
            ->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        return redirect()
            ->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil dihapus.');
    }

    public function toggleStatus(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $statusBaru = $pelanggan->status === 'Aktif'
            ? 'Tidak Aktif'
            : 'Aktif';

        $pelanggan->update([
            'status' => $statusBaru,
        ]);

        return redirect()
            ->route('pelanggan.index')
            ->with('success', 'Status pelanggan berhasil diperbarui.');
    }
}
