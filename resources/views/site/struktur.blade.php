@extends('layouts.app')

@section('title', 'Struktur Organisasi - RSHP')

@push('styles')
<style>
  .struktur-section {
    padding: 100px 0;
    background-color: #fff;
  }

  .struktur-section h1 {
    color: var(--green);
    font-weight: 700;
    text-align: center;
    margin-bottom: 15px;
  }

  .struktur-section p.lead {
    color: #555;
    text-align: center;
    margin-bottom: 60px;
  }

  .team-card {
    background-color: #f9f9f9;
    border: none;
    border-radius: 14px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    transition: 0.3s;
  }

  .team-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 25px rgba(247,132,197,0.3);
  }

  .team-card img {
    border-radius: 14px 14px 0 0;
    height: 280px;
    object-fit: cover;
    width: 100%;
  }

  .team-card .card-body {
    text-align: center;
    padding: 20px;
  }

  .team-card h5 {
    color: var(--green);
    font-weight: 700;
    margin-top: 10px;
  }

  .team-card small {
    color: var(--pink);
    font-weight: 500;
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
<section class="struktur-section">
  <div class="container">
    <h1>Struktur Organisasi RSHP</h1>
    <p class="lead">Tim profesional kami terdiri dari tenaga medis hewan berpengalaman yang bekerja sama untuk memberikan pelayanan terbaik bagi hewan kesayangan Anda.</p>

    <div class="row g-4">
      <div class="col-md-3">
        <div class="card team-card">
          <img src="https://cdn.pixabay.com/photo/2016/08/11/08/57/doctor-1584462_1280.jpg" alt="Direktur">
          <div class="card-body">
            <small>Direktur RSHP</small>
            <h5>Drh. Siti Rahmawati</h5>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card team-card">
          <img src="https://cdn.pixabay.com/photo/2016/03/27/19/31/veterinarian-1285208_1280.jpg" alt="Koordinator Medis">
          <div class="card-body">
            <small>Koordinator Medis</small>
            <h5>Drh. Ahmad Setiawan</h5>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card team-card">
          <img src="https://cdn.pixabay.com/photo/2017/08/06/14/46/veterinarian-2596469_1280.jpg" alt="Koordinator Operasional">
          <div class="card-body">
            <small>Koordinator Operasional</small>
            <h5>Drh. Rina Kartika</h5>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="card team-card">
          <img src="https://cdn.pixabay.com/photo/2017/03/16/20/10/veterinarian-2156990_1280.jpg" alt="Staff Medis">
          <div class="card-body">
            <small>Staff Medis</small>
            <h5>Drh. Bambang Prasetyo</h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="cta-bottom">
  <div class="container">
    <h3>Bergabung dengan Tim RSHP</h3>
    <p>Ingin menjadi bagian dari pelayanan kesehatan hewan terbaik? Mari bergabung bersama kami.</p>
    <a href="{{ url('/kontak') }}" class="btn-secondary-main">Hubungi HRD RSHP</a>
  </div>
</section>
@endsection
