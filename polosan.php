<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Penilaian Mahasiswa</title> <!--Judul Dokumen -->
  <!-- Mengimpor file CSS Bootstrap dari CDN agar tampilan lebih menarik -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- CSS tambahan untuk mengatur warna dan layout -->
  <style>
    body {
      background-color: #f8f9fa;
    }
    .card-header {
      background-color: #007bff;
      color: white;
    }
    .form-label {
      font-weight: bold;
    }
  </style>
</head>
<body>
  <!-- Container utama -->
  <div class="container mt-4 mb-5 px-4">
    <div class="card shadow-sm">
      <div class="card-header text-center">
        <h1 class="h4 mb-0">Form Penilaian Mahasiswa</h1>
      </div>
      <div class="card-body">
        <?php
        // Variabel untuk menyimpan error jika ada field yang belum diisi
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          $nama = trim($_POST['nama']);
          $nim = trim($_POST['nim']);
          $kehadiran = $_POST['kehadiran'];
          $tugas = $_POST['tugas'];
          $uts = $_POST['uts'];
          $uas = $_POST['uas'];

           // Validasi: jika ada input kosong, tampilkan pesan error
          if (
            empty($nama) || empty($nim) ||
            $kehadiran === '' || $tugas === '' || $uts === '' || $uas === ''
          ) {
            $error = "Semua kolom harus diisi!";
          }
        }
        ?>

        <!-- Form input nilai mahasiswa -->
        <form method="POST" action="">
          <div class="mb-3">
            <label class="form-label" for="nama">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" placeholder="Agus" value="<?= $_POST['nama'] ?? '' ?>">
          </div>
          <div class="mb-3">
            <label class="form-label" for="nim">NIM</label>
            <input type="text" class="form-control" id="nim" name="nim" placeholder="202332xxx" value="<?= $_POST['nim'] ?? '' ?>">
          </div>
          <div class="mb-3">
            <label class="form-label" for="kehadiran">Nilai Kehadiran (10%)</label>
            <input type="number" class="form-control" id="kehadiran" name="kehadiran" min="0" max="100" value="<?= $_POST['kehadiran'] ?? '' ?>">
          </div>
          <div class="mb-3">
            <label class="form-label" for="tugas">Nilai Tugas (20%)</label>
            <input type="number" class="form-control" id="tugas" name="tugas" min="0" max="100" value="<?= $_POST['tugas'] ?? '' ?>">
          </div>
          <div class="mb-3">
            <label class="form-label" for="uts">Nilai UTS (30%)</label>
            <input type="number" class="form-control" id="uts" name="uts" min="0" max="100" value="<?= $_POST['uts'] ?? '' ?>">
          </div>
          <div class="mb-3">
            <label class="form-label" for="uas">Nilai UAS (40%)</label>
            <input type="number" class="form-control" id="uas" name="uas" min="0" max="100" value="<?= $_POST['uas'] ?? '' ?>">
          </div>
          <div class="d-grid gap-2">
            <button type="submit" name="proses" class="btn btn-primary">Proses</button>
          </div>
          
           <!-- Tampilkan pesan error jika ada -->
          <?php if ($error): ?>
            <div class="alert alert-danger mt-3" role="alert">
              <?= $error ?>
            </div>
          <?php endif; ?>
        </form>

        <?php
        if (isset($_POST['proses']) && !$error) {
          $nilai_akhir = ($kehadiran * 0.1) + ($tugas * 0.2) + ($uts * 0.3) + ($uas * 0.4); // Hitung nilai akhir sesuai bobot komponen

          // Grade
          if ($nilai_akhir >= 85) {
            $grade = "A";
          } elseif ($nilai_akhir >= 70) {
            $grade = "B";
          } elseif ($nilai_akhir >= 55) {
            $grade = "C";
          } elseif ($nilai_akhir >= 40) {
            $grade = "D";
          } else {
            $grade = "E";
          }

          // Status kelulusan
          // Syarat: nilai akhir ≥ 60, kehadiran > 70, semua komponen tugas, uts, uas ≥ 40
          if (
            $nilai_akhir >= 60 &&
            $kehadiran > 70 &&
            $tugas >= 40 &&
            $uts >= 40 &&
            $uas >= 40
          ) {
            $status = "LULUS";
            $warna = "success"; // warna hijau untuk sukses
          } else {
            $status = "TIDAK LULUS";
            $warna = "danger";  // warna merah untuk gagal
          }

          // Tampilkan hasil
          echo "<div class='card mt-4 border border-$warna'>";
          echo "<div class='card-header bg-$warna text-white fw-bold'>Hasil Penilaian</div>";
          echo "<div class='card-body'>";
          echo "<div class='d-flex justify-content-between mb-3'>";
          echo "<p class='mb-0'><strong>Nama:</strong> $nama</p>";
          echo "<p class='mb-0'><strong>NIM:</strong> $nim</p>";
          echo "</div>";
          echo "<p><strong>Nilai Kehadiran:</strong> $kehadiran%</p>";
          echo "<p><strong>Nilai Tugas:</strong> $tugas</p>";
          echo "<p><strong>Nilai UTS:</strong> $uts</p>";
          echo "<p><strong>Nilai UAS:</strong> $uas</p>";
          echo "<p><strong>Nilai Akhir:</strong> " . number_format($nilai_akhir, 2) . "</p>";
          echo "<p><strong>Grade:</strong> $grade</p>";
          echo "<p><strong>Status:</strong> $status</p>";
          echo "<div class='d-grid mt-3'>";
          echo "<a href='' class='btn btn-$warna'>Selesai</a>";
          echo "</div></div></div>";
        }
        ?>
      </div>
    </div>
  </div>
</body>
</html>
