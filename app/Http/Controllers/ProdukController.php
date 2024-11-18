<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    /**
     * Menampilkan daftar produk berdasarkan peran pengguna.
     */
    public function ViewProduk()
    {
        $isAdmin = Auth::user()->role == 'admin';
        $produk = $isAdmin ? Produk::all() : Produk::where('user_id', Auth::user()->id)->get();
        return view('produk', ['produk' => $produk]);
    }

    /**
     * Menampilkan form untuk menambah produk.
     */
    public function ViewAddProduk()
    {
        return view('addproduk');
    }

    /**
     * Membuat produk baru.
     */
    public function CreateProduk(Request $request)
    {
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageName = time() . '_' . $imageFile->getClientOriginalName();
            $imageFile->storeAs('public/images', $imageName);
        }

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'jumlah_produk' => $request->jumlah_produk,
            'image' => $imageName,
            'user_id' => Auth::user()->id
        ]);

        return redirect(Auth::user()->role.'/produk');
    }

    /**
     * Menampilkan form untuk mengedit produk.
     */
    public function ViewEditProduk($kode_produk)
    {
        $ubahproduk = Produk::where('kode_produk', $kode_produk)->first();
        return view('editproduk', compact('ubahproduk'));
    }

    /**
     * Memperbarui produk.
     */
    public function UpdateProduk(Request $request, $kode_produk)
    {
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageName = time() . '_' . $imageFile->getClientOriginalName();
            $imageFile->storeAs('public/images', $imageName);
        }
        Produk::where('kode_produk', $kode_produk)->update([
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'jumlah_produk' => $request->jumlah_produk,
            'image' => $imageName
        ]);

        return redirect(Auth::user()->role.'/produk');
    }

    /**
     * Menghapus produk.
     */
    public function DeleteProduk($kode_produk)
    {
        Produk::where('kode_produk', $kode_produk)->delete();
        return redirect(Auth::user()->role.'/produk');
    }

    /**
     * Menampilkan laporan produk berdasarkan peran pengguna.
     */
    public function ViewLaporan()
    {
        $isAdmin = Auth::user()->role == 'admin';
        $products = $isAdmin ? Produk::all() : Produk::where('user_id', Auth::user()->id)->get();
        return view('laporan', ['products' => $products]);
    }

    /**
     * Cetak laporan produk dalam bentuk PDF berdasarkan peran pengguna.
     */
    public function print()
    {
        $isAdmin = Auth::user()->role == 'admin';
        $products = $isAdmin ? Produk::all() : Produk::where('user_id', Auth::user()->id)->get();
        $pdf = Pdf::loadView('report', compact('products'));
        return $pdf->stream('laporan-produk.pdf');
    }
}
