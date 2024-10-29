@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Create Contact Entry</h1>

    <!-- Display success message if applicable -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Contact form -->
    <form class="shake" role="form" method="post" id="contactForm" name="contact-form" action="{{ route('contact_us.store') }}">
        @csrf
        <div class="form-group">
            <label for="company_name">Company Name</label>
            <input type="text" name="company_name" id="company_name" class="form-control" required maxlength="255">
        </div>
        <div class="form-group">
            <label for="company_address">Company Address</label>
            <textarea name="company_address" id="company_address" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="company_phone_number">Company Phone Number</label>
            <input type="text" name="company_phone_number" id="company_phone_number" class="form-control" required maxlength="15">
        </div>
        <div class="form-group">
            <label for="company_email">Company Email</label>
            <input type="email" name="company_email" id="company_email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection