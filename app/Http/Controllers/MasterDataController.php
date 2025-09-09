<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    // menampilkan form create
    public function create()
    {
        return view('masterdata.create');
    }

    // menyimpan data baru
    public function store(Request $request)
    {
        // validasi input
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email',
            'role'  => 'required|string',
        ]);

        // contoh: simpan ke database (jika ada model User atau MasterData)
        // MasterData::create($validated);

        // redirect kembali ke halaman lain dengan pesan sukses
        return redirect()->route('masterdata.create')->with('success', 'Data berhasil disimpan!');
    }
}
