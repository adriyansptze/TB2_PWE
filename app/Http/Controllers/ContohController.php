<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContohController extends Controller
{
    /**
     * Menampilkan halaman home dengan grafik penjualan dan data produk.
     */
    public function TampilContoh()
    {
        // Cek apakah user adalah admin
        $isAdmin = Auth::user()->role === 'admin';

        // Ambil produk dari database dan kelompokkan berdasarkan tanggal
        $produkPerHariQuery = Produk::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->groupBy('date')
            ->orderBy('date', 'asc');

        // Filter by user_id jika user bukan admin
        if (!$isAdmin) {
            $produkPerHariQuery->where('user_id', Auth::id());
        }

        $produkPerHari = $produkPerHariQuery->get();

        // Memisahkan data untuk grafik
        $dates = [];
        $totals = [];
        foreach ($produkPerHari as $item) {
            $dates[] = Carbon::parse($item->date)->format('Y-m-d'); // Format tanggal
            $totals[] = $item->total;
        }

        // Membuat grafik menggunakan data yang diambil
        $chart = LarapexChart::barChart()
            ->setTitle('Produk Ditambahkan Per Hari')
            ->setSubtitle('Data Penambahan Produk Harian')
            ->addData('Jumlah Produk', $totals)
            ->setXAxis($dates);

        // Data tambahan untuk view
        $data = [
            'totalProducts' => $isAdmin ? Produk::count() : Produk::where('user_id', Auth::id())->count(), // Total produk sesuai role
            'salesToday' => 130, // Contoh data lainnya
            'totalRevenue' => 'Rp 75,000,000',
            'registeredUsers' => 350,
            'chart' => $chart // Pass chart ke view
        ];

        // Menampilkan view dengan data
        return view('contoh', $data);
    }
}