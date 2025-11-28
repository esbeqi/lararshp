@extends('layouts.app')

@section('title', 'Kontak - RSHP')

@push('styles')
<style>
  .kontak-section {
    padding: 100px 0;
    background-color: #fff;
  }

  .kontak-section h1 {
    color: var(--green);
    font-weight: 700;
    text-align: center;
    margin-bottom: 15px;
  }

  .kontak-section p.lead {
    color: #555;
    text-align: center;
    margin-bottom: 50px;
  }

  .form-control:focus {
    border-color: var(--pink);
    box-shadow: 0 0 0 0.2rem rgba(247,132,197,0.25);
  }

  .info-box {
    background-color: #f9f9f9;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
  }

  .info-box h5 {
    color: var(--green);
    font-weight: 600;
    margin-bottom: 15px;
  }

  .info-item {
    margin-bottom: 15px;
  }

  .info-item i {
    color: var(--pink);
    font-size: 1.3rem;
    margin-right: 8px;
  }

  .cta-bottom {
    background-color: #f9f9f9;
    text-align: center;
    padding: 80px 0;
    margin-top: 60px;
  }

  .cta-bottom h3 {
    color: var(--green);
    font-weight: 700;
    margin-bottom: 15px;
  }

  .cta-bottom p {
    color: #555;
    margin-bottom: 25px;
  }
</style>
@endpush

@section('content')
<section class="kontak-section">
  <div class="container">
    <h1>Hubungi Kami</h1>
    <p class="lead">Ada pertanyaan, saran, atau butuh bantuan segera? Tim kami siap membantu Anda dengan senang hati.</p>

    <div class="row g-5 align-items-start">
      <!-- FORM KONTAK -->
      <div class="col-md-6">
        <form method="POST" action="{{ url('/kontak') }}">
          @csrf
          <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" name="nama" placeholder="Masukkan nama Anda" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" placeholder="nama@email.com" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Pesan</label>
            <textarea class="form-control" name="pesan" rows="5" placeholder="Tulis pesan Anda di sini..." required></textarea>
          </div>

          <button type="submit" class="btn-secondary-main">Kirim Pesan</button>
        </form>
      </div>

      <!-- INFO KONTAK -->
      <div class="col-md-6">
        <div class="info-box">
          <h5>Informasi Kontak</h5>

          <div class="info-item">
            <i class="bi bi-geo-alt-fill"></i>
            <span>Jl. Raya Kampus Unair No. 1, Surabaya</span>
          </div>
          <div class="info-item">
            <i class="bi bi-telephone-fill"></i>
            <span>(031) 123-4567</span>
          </div>
          <div class="info-item">
            <i class="bi bi-envelope-fill"></i>
            <span>info@rshp.com</span>
          </div>

          <hr>
          <h5>Jam Operasional</h5>
          <p>Senin – Sabtu: 08.00 - 20.00<br>Minggu & Hari Libur: 09.00 - 17.00</p>

          <h5 class="mt-3">Layanan Darurat</h5>
          <p>Telepon Darurat 24 Jam: <strong style="color:var(--pink)">0812-3456-7890</strong></p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="cta-bottom">
  <div class="container">
    <h3>Butuh Penanganan Cepat?</h3>
    <p>Hubungi tim darurat kami untuk penanganan langsung terhadap hewan kesayangan Anda.</p>
    <a href="tel:081234567890" class="btn-secondary-main">Telepon Sekarang</a>
  </div>
</section>
@endsection
