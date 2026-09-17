@extends('layouts.app')
@section('title', 'Contact Us')
@section('content')
<div class="hero-ssz text-center mb-5">
    <span class="badge badge-role mb-3 px-3 py-2">Get in Touch</span>
    <h1 class="display-6 fw-bold">Contact Seke 1 High School</h1>
    <p class="lead">We'd love to hear from you - reach out with any questions.</p>
</div>

<div class="row g-4 justify-content-center">
    <div class="col-md-4">
        <div class="card card-ssz h-100 text-center">
            <div class="card-body p-4">
                <div class="ssz-icon-circle mx-auto mb-3"><i class="bi bi-geo-alt-fill"></i></div>
                <h6 class="fw-bold">Our Address</h6>
                <p class="text-muted mb-0">Seke 1 High School<br>Seke, Chitungwiza<br>Harare, Zimbabwe</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-ssz h-100 text-center">
            <div class="card-body p-4">
                <div class="ssz-icon-circle mx-auto mb-3"><i class="bi bi-telephone-fill"></i></div>
                <h6 class="fw-bold">Call Us</h6>
                <p class="text-muted mb-1"><a href="tel:+263000000000" class="text-decoration-none" style="color: var(--ssz-brown-dark);">+263 00 000 0000</a></p>
                <p class="text-muted small mb-0">Mon - Fri, 7:30am - 4:00pm</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-ssz h-100 text-center">
            <div class="card-body p-4">
                <div class="ssz-icon-circle mx-auto mb-3"><i class="bi bi-envelope-fill"></i></div>
                <h6 class="fw-bold">Email Us</h6>
                <p class="text-muted mb-0"><a href="mailto:info@{{ config('school.email_domains.school_admin', 'admin.ac.zw') }}" class="text-decoration-none" style="color: var(--ssz-brown-dark);">info@{{ config('school.email_domains.school_admin', 'admin.ac.zw') }}</a></p>
            </div>
        </div>
    </div>
</div>

<div class="card card-ssz mt-5">
    <div class="card-body text-center p-4">
        <h5 class="fw-bold">Ready to join our school?</h5>
        <p class="text-muted">Prospective students can apply online in just a few minutes.</p>
        <a href="{{ route('enrollment.create') }}" class="btn btn-ssz-primary">Submit an Online Application</a>
    </div>
</div>
@endsection
