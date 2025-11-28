@extends('layouts.app')

@section('title', 'Layanan - RSHP')

@push('styles')
<style>
  .layanan-section {
    padding: 100px 0;
    background-color: #fff;
  }

  .layanan-section h1 {
    color: var(--green);
    font-weight: 700;
    text-align: center;
    margin-bottom: 15px;
  }

  .layanan-section p.lead {
    color: #555;
    text-align: center;
    margin-bottom: 50px;
  }

  .layanan-card {
    border: none;
    border-radius: 14px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    transition: 0.3s;
  }

  .layanan-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(247,132,197,0.3);
  }

  .layanan-card img {
    width: 70px;
    margin-bottom: 20px;
  }

  .layanan-card h5 {
    color: var(--green);
    font-weight: 600;
  }

  .layanan-card p {
    color: #555;
    font-size: 0.95rem;
  }

  .cta-bottom {
    background-color: #f9f9f9;
    text-align: center;
    padding: 80px 0;
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
<section class="layanan-section">
  <div class="container">
    <h1>Layanan RSHP</h1>
    <p class="lead">Berbagai layanan kesehatan hewan kami rancang untuk memberikan perawatan terbaik dan menyeluruh bagi hewan kesayangan Anda.</p>

    <div class="row g-4">
      <div class="col-md-3">
        <div class="card layanan-card text-center p-4">
          <div class="card-body">
            <img src="https://img.icons8.com/fluency/96/hospital-room.png" alt="Rawat Inap">
            <h5>Rawat Inap</h5>
            <p>Fasilitas nyaman dan aman bagi hewan yang membutuhkan perawatan intensif.</p>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card layanan-card text-center p-4">
          <div class="card-body">
            <img src="https://img.icons8.com/fluency/96/ambulance.png" alt="UGD">
            <h5>Unit Gawat Darurat</h5>
            <p>Pelayanan darurat 24 jam dengan dokter hewan berpengalaman.</p>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card layanan-card text-center p-4">
          <div class="card-body">
            <img src="https://img.icons8.com/fluency/96/medical-doctor.png" alt="Rawat Jalan">
            <h5>Rawat Jalan</h5>
            <p>Konsultasi, vaksinasi, dan pemeriksaan rutin untuk kesehatan optimal.</p>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card layanan-card text-center p-4">
          <div class="card-body">
            <img src="https://img.icons8.com/fluency/96/online-support.png" alt="Konsultasi Online">
            <h5>Konsultasi Online</h5>
            <p>Layanan praktis untuk konsultasi langsung dengan dokter hewan kami.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="cta-bottom">
  <div class="container">
    <h3>Butuh Bantuan Darurat?</h3>
    <p>Tim kami siap membantu Anda kapan saja, di mana saja.</p>
    <a href="{{ url('/kontak') }}" class="btn-secondary-main">Hubungi Kami</a>
  </div>
</section>
@endsection
