@extends('layouts.app')

@section('title', 'Login - RSHP')

@push('styles')
<style>
  .login-section {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f9f9f9;
    padding: 80px 0;
  }

  .login-card {
    background-color: #fff;
    border-radius: 14px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    padding: 40px 35px;
    max-width: 420px;
    width: 100%;
    text-align: center;
  }

  .login-card h2 {
    color: var(--green);
    font-weight: 700;
    margin-bottom: 20px;
  }

  .login-card p {
    color: #555;
    font-size: 0.95rem;
    margin-bottom: 30px;
  }

  .form-control {
    border-radius: 8px;
  }

  .form-control:focus {
    border-color: var(--pink);
    box-shadow: 0 0 0 0.2rem rgba(247, 132, 197, 0.25);
  }

  .btn-login {
    background-color: var(--pink);
    color: #fff;
    font-weight: 600;
    border: none;
    border-radius: 8px;
    width: 100%;
    padding: 10px 0;
    transition: 0.3s;
  }

  .btn-login:hover {
    background-color: #e26eb2;
  }

  .login-footer {
    margin-top: 25px;
    color: #555;
  }

  .login-footer a {
    color: var(--green);
    text-decoration: none;
    font-weight: 600;
  }

  .login-footer a:hover {
    color: var(--pink);
  }

  @media (max-width: 768px) {
    .login-card {
      padding: 30px 25px;
    }
  }
</style>
@endpush

@section('content')
<section class="login-section">
  <div class="login-card">
    <h2>Selamat Datang Kembali</h2>
    <p>Masuk untuk mengakses layanan Rumah Sakit Hewan Pendidikan</p>

    <form method="POST" action="{{ url('/login') }}">
      @csrf
      <div class="mb-3 text-start">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="Masukkan email Anda" required>
      </div>

      <div class="mb-3 text-start">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
      </div>

      <button type="submit" class="btn-login">Masuk</button>
    </form>

    <div class="login-footer">
      <p class="mt-3">Belum punya akun? <a href="{{ url('/kontak') }}">Hubungi Admin</a></p>
      <a href="{{ url('/') }}">← Kembali ke Beranda</a>
    </div>
  </div>
</section>
@endsection
