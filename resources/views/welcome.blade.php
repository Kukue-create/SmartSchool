@extends('layouts.app')
@section('title', 'Welcome')
@section('content')
<div class="hero-ssz text-center mb-5">
    <span class="badge badge-role mb-3 px-3 py-2">Seke 1 High School</span>
    <h1 class="display-5 fw-bold">SmartSchool Zimbabwe</h1>
    <p class="lead"></p>
    <div class="mt-4">
        <a href="{{ route('register') }}" class="btn btn-ssz-accent btn-lg me-2">Register</a>
        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">Login</a>
    </div>
</div>

<div class="ssz-icon-strip mb-5">
    <div class="ssz-icon-circle"><i class="bi bi-mortarboard-fill"></i></div>
    <div class="ssz-icon-divider"></div>
    <div class="ssz-icon-circle"><i class="bi bi-journal-bookmark-fill"></i></div>
    <div class="ssz-icon-divider"></div>
    <div class="ssz-icon-circle ssz-icon-circle-lg"><i class="bi bi-building-fill"></i></div>
    <div class="ssz-icon-divider"></div>
    <div class="ssz-icon-circle"><i class="bi bi-clipboard-check-fill"></i></div>
    <div class="ssz-icon-divider"></div>
    <div class="ssz-icon-circle"><i class="bi bi-people-fill"></i></div>
</div>

<div class="text-center mb-5 mx-auto" style="max-width: 720px;">
    <h2 class="fw-bold" style="color: var(--ssz-brown-dark);">A tradition of excellence</h2>
    <p class="lead" style="color: var(--ssz-brown-soft);">
        Seke 1 High School has built its reputation on strong academic results, disciplined
        learners and a vibrant school life - from ZIMSEC O' and A' Level achievers to
        thriving sports teams and cultural clubs. SmartSchool Zimbabwe brings that same
        standard of excellence online, keeping students, teachers and parents connected
        every step of the way.
    </p>
</div>

<div class="card card-ssz mt-5">
    <div class="card-body text-center p-4">
        <h5 class="fw-bold">Applying for a place at Seke 1 High School?</h5>
        <p class="text-muted">Prospective students are welcome to apply online - upload your most recent results and we'll take it from there.</p>
        <a href="{{ route('enrollment.create') }}" class="btn btn-ssz-primary">Submit an Online Application</a>
    </div>
</div>

<div class="row g-4 mt-1">
    <div class="col-md-6">
        <div class="card card-ssz h-100">
            <div class="card-body p-4 text-center">
                <i class="bi bi-compass fs-3" style="color: var(--ssz-green-dark);"></i>
                <h6 class="fw-bold mt-2">Want to know more about us?</h6>
                <p class="text-muted small">Explore our story, facilities and school life.</p>
                <a href="{{ route('about') }}" class="btn btn-ssz-green btn-sm">Explore the School</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-ssz h-100">
            <div class="card-body p-4 text-center">
                <i class="bi bi-telephone-fill fs-3" style="color: var(--ssz-green-dark);"></i>
                <h6 class="fw-bold mt-2">Have a question?</h6>
                <p class="text-muted small">Get in touch with the school office.</p>
                <a href="{{ route('contact') }}" class="btn btn-ssz-green btn-sm">Contact Us</a>
            </div>
        </div>
    </div>
</div>
@endsection
