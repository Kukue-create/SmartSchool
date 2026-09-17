@extends('layouts.app')
@section('title', 'About Us')
@section('content')
<div class="hero-ssz text-center mb-5">
    <span class="badge badge-role mb-3 px-3 py-2">Explore the School</span>
    <h1 class="display-6 fw-bold">About Seke 1 High School</h1>
    <p class="lead">A place where discipline, academic excellence and community come together.</p>
</div>

<div class="row g-4 mb-5">
    <div class="col-lg-7">
        <div class="card card-ssz h-100">
            <div class="card-header"><i class="bi bi-book-half"></i> Our Story</div>
            <div class="card-body">
                <p>Seke 1 High School is a proud secondary school in Seke, Zimbabwe, offering
                education from Form 1 through to Upper 6. Generations of learners have passed
                through our gates, and our focus remains the same: helping every student reach
                their full potential, academically and beyond.</p>
                <p class="mb-0">We take pride in producing well-rounded learners who go on to
                succeed at tertiary institutions, in the workplace, and in their communities -
                built on a foundation of hard work, respect and discipline.</p>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card card-ssz h-100">
            <div class="card-header"><i class="bi bi-flag-fill"></i> Our Values</div>
            <div class="card-body">
                <ul class="mb-0">
                    <li>Academic excellence for every learner</li>
                    <li>Discipline and strong moral character</li>
                    <li>Respect for one another and our community</li>
                    <li>A love of learning that lasts beyond the classroom</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<h4 class="fw-bold text-center mb-4" style="color: var(--ssz-brown-dark);">School Life</h4>
<div class="row g-4 mb-5">
    <div class="col-md-3 col-6">
        <div class="card card-ssz h-100 text-center">
            <div class="card-body p-3">
                <div class="ssz-icon-circle mx-auto mb-2"><i class="bi bi-calculator-fill"></i></div>
                <h6 class="fw-bold mb-0">Academics</h6>
                <p class="text-muted small mb-0">Sciences, Commercials and Arts across Forms 1-6</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card card-ssz h-100 text-center">
            <div class="card-body p-3">
                <div class="ssz-icon-circle mx-auto mb-2"><i class="bi bi-trophy-fill"></i></div>
                <h6 class="fw-bold mb-0">Sports</h6>
                <p class="text-muted small mb-0">Football, athletics, netball and more</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card card-ssz h-100 text-center">
            <div class="card-body p-3">
                <div class="ssz-icon-circle mx-auto mb-2"><i class="bi bi-music-note-beamed"></i></div>
                <h6 class="fw-bold mb-0">Arts &amp; Culture</h6>
                <p class="text-muted small mb-0">Music, drama and traditional dance</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card card-ssz h-100 text-center">
            <div class="card-body p-3">
                <div class="ssz-icon-circle mx-auto mb-2"><i class="bi bi-people-fill"></i></div>
                <h6 class="fw-bold mb-0">Clubs</h6>
                <p class="text-muted small mb-0">Science club, debate, and student leadership</p>
            </div>
        </div>
    </div>
</div>

<div class="card card-ssz">
    <div class="card-header"><i class="bi bi-building-fill"></i> Our Facilities</div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4"><i class="bi bi-check-circle-fill" style="color: var(--ssz-green-dark);"></i> Well-equipped classrooms</div>
            <div class="col-md-4"><i class="bi bi-check-circle-fill" style="color: var(--ssz-green-dark);"></i> Science laboratories</div>
            <div class="col-md-4"><i class="bi bi-check-circle-fill" style="color: var(--ssz-green-dark);"></i> School library</div>
            <div class="col-md-4"><i class="bi bi-check-circle-fill" style="color: var(--ssz-green-dark);"></i> Sports fields</div>
            <div class="col-md-4"><i class="bi bi-check-circle-fill" style="color: var(--ssz-green-dark);"></i> Computer lab</div>
            <div class="col-md-4"><i class="bi bi-check-circle-fill" style="color: var(--ssz-green-dark);"></i> Assembly hall</div>
        </div>
    </div>
</div>

<div class="text-center mt-5">
    <a href="{{ route('enrollment.create') }}" class="btn btn-ssz-primary btn-lg me-2">Apply for a Place</a>
    <a href="{{ route('contact') }}" class="btn btn-ssz-green btn-lg">Contact Us</a>
</div>
@endsection
