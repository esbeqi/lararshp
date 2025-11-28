@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <!-- Header Dashboard -->
                <div class="card-header bg-primary text-white fw-bold">
                    {{ __('Dashboard') }} - {{ session('user_name') }}
                </div>

                <!-- Isi Dashboard -->
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success text-center" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p class="text-center mb-4">
                        {{ __('You are logged in as: ') }}
                        <strong>{{ session('user_role_name') }}</strong>
                    </p>

                    <!-- Menu khusus untuk Administrator -->
                    @if (session('user_role_name') == 'Administrator')
                        <hr>
                        <div class="d-grid gap-3">
                            <a href="{{ route('admin.jenis-hewan.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-paw"></i> Kelola Jenis Hewan
                            </a>
                            <a href="{{ route('admin.pemilik.index') }}" class="btn btn-outline-success">
                                <i class="fas fa-users"></i> Kelola Pemilik
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection