@extends('layouts.app')

@section('title', 'Home - RSHP')

@push('styles')
<style>
  .hero {
    background-color: #f9f9f9;
    padding: 90px 0;
  }

  .hero h1 {
    color: var(--green);
    font-weight: 700;
    font-size: 2.5rem;
  }

  .hero p {
    color: #555;
    margin-top: 10px;
    margin-bottom: 25px;
  }

  .fitur {
    background-color: #fff;
    padding: 80px 0;
  }

  .fitur h2 {
    text-align: center;
    color: var(--green);
    font-weight: 700;
    margin-bottom: 40px;
  }

  .fitur .card {
    border: none;
    border-radius: 14px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    transition: 0.3s;
  }

  .fitur .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(247,132,197,0.3);
  }

  .fitur h5 {
    color: var(--green);
    font-weight: 600;
  }

  .tentang {
    background-color: #f9f9f9;
    padding: 80px 0;
  }

  .cta {
    background-color: var(--green);
    color: white;
    text-align: center;
    padding: 70px 0;
  }
</style>
@endpush

@section('content')
<!-- HERO -->
<section class="hero">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 mb-4 mb-md-0">
        <h1>Pelayanan Hewan Modern dan Profesional</h1>
        <p>RSHP memberikan perawatan terbaik melalui tenaga medis hewan berpengalaman serta fasilitas lengkap untuk kenyamanan hewan kesayangan Anda.</p>
        <a href="{{ url('/layanan') }}" class="btn-secondary-main">Lihat Layanan Kami</a>
      </div>
      <div class="col-md-6 text-center">
        <img src="{{ asset('images/veterinary1.jpg') }}" 
     alt="Veterinary Clinic" 
     class="img-fluid rounded-3 shadow">
      </div>
    </div>
  </div>
</section>

<!-- LAYANAN -->
<section class="fitur">
  <div class="container">
    <h2>Layanan Unggulan Kami</h2>
    <div class="row g-4">
      <div class="col-md-3">
        <div class="card p-3 text-center">
          <div class="card-body">
            <img src="https://img.icons8.com/fluency/48/medical-hospital.png" alt="">
            <h5 class="mt-3">Rawat Inap</h5>
            <p>Perawatan intensif dengan pengawasan medis hewan 24 jam.</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card p-3 text-center">
          <div class="card-body">
            <img src="https://img.icons8.com/fluency/48/ambulance.png" alt="">
            <h5 class="mt-3">Unit Gawat Darurat</h5>
            <p>Siaga setiap waktu untuk kondisi darurat hewan kesayangan Anda.</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card p-3 text-center">
          <div class="card-body">
            <img src="https://img.icons8.com/fluency/48/clinic.png" alt="">
            <h5 class="mt-3">Rawat Jalan</h5>
            <p>Pemeriksaan rutin, vaksinasi, dan konsultasi medis ringan.</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card p-3 text-center">
          <div class="card-body">
            <img src="https://img.icons8.com/fluency/48/medical-doctor.png" alt="">
            <h5 class="mt-3">Konsultasi Online</h5>
            <p>Konsultasi cepat dan praktis dengan dokter hewan kami.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- TENTANG -->
<section class="tentang">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 mb-4 mb-md-0">
        <img src="{{ asset('images/veterinary2.jpg') }}" 
     alt="Tentang RSHP" 
     class="img-fluid rounded-3 shadow">
      </div>
      <div class="col-md-6">
        <h2>Tentang RSHP</h2>
        <p>Rumah Sakit Hewan Pendidikan (RSHP) adalah fasilitas kesehatan hewan dengan pendekatan modern dan teknologi terkini untuk memastikan kesejahteraan hewan peliharaan Anda.</p>
        <a href="{{ url('/struktur') }}" class="btn-primary-main">Pelajari Lebih Lanjut</a>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta">
  <div class="container">
    <h3>Siap untuk Merawat Hewan Anda?</h3>
    <p>Bergabunglah dengan kami dan nikmati layanan terbaik dari RSHP.</p>
    <a href="{{ url('/login') }}" class="btn-secondary-main">Mulai Sekarang</a>
  </div>
</section>
@endsection
