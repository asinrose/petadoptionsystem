@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0">
            <h1 class="display-4 fw-bold text-primary mb-3">{{ $service['title'] }}</h1>
            <p class="lead text-muted mb-4">{{ $service['description'] }}</p>
            
            <h4 class="fw-bold mb-3">Key Features:</h4>
            <ul class="list-unstyled mb-4">
                @foreach($service['features'] as $feature)
                    <li class="mb-2">
                        <i class="fas fa-check-circle text-success me-2"></i> {{ $feature }}
                    </li>
                @endforeach
            </ul>

            <a href="{{ $service['cta_link'] }}" class="btn btn-primary-custom btn-lg shadow-sm">
                {{ $service['cta'] }}
            </a>
            <a href="{{ url('/#services') }}" class="btn btn-outline-secondary btn-lg ms-2 rounded-pill">
                Back to Services
            </a>
        </div>
        <div class="col-lg-6">
            <img src="{{ $service['image'] }}" alt="{{ $service['title'] }}" class="img-fluid rounded-4 shadow-lg w-100" style="object-fit: cover; height: 400px;">
        </div>
    </div>
</div>
@endsection
