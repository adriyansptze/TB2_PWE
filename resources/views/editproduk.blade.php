<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="{{ asset('/css/styles.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Dashboard Penjualan</h2>
        <ul>
            <li><a href="{{ url(Auth::user()->role . '/home') }}">Home</a></li>
            <li><a href="{{ url(Auth::user()->role . '/produk') }}">Produk</a></li>
            <li><a href="#">Penjualan</a></li>
            <li><a href="{{ url(Auth::user()->role . '/laporan') }}">Laporan</a></li>
            <li>
                <form action="{{ url('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-decoration-none bg-transparent border-0 text-white" style="font-size: 18px;">
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            <h1>Edit Produk</h1>

            <!-- Form untuk mengedit produk -->
            <<form action="{{ url(Auth::user()->role . '/produk/update/' . $ubahproduk->kode_produk) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Nama Produk -->
                <div class="form-group">
                    <label for="nama_produk">Nama Produk</label>
                    <input type="text" name="nama_produk" class="form-control" required value="{{ $ubahproduk->nama_produk }}">
                </div>

                <!-- Deskripsi Produk -->
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <input type="text" name="deskripsi" class="form-control" required value="{{ $ubahproduk->deskripsi }}">
                </div>

                <!-- Harga Produk -->
                <div class="form-group">
                    <label for="harga">Harga</label>
                    <input type="number" name="harga" class="form-control" required value="{{ $ubahproduk->harga }}">
                </div>

                <!-- Jumlah Produk -->
                <div class="form-group">
                    <label for="jumlah_produk">Jumlah Produk</label>
                    <input type="number" name="jumlah_produk" class="form-control" required value="{{ $ubahproduk->jumlah_produk }}">
                </div>

                <!-- Gambar Produk -->
                <div class="form-group">
                    <label for="image">Gambar</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Edit Produk</button>
            </form>
        </div>
    </div>
</body>
</html>
