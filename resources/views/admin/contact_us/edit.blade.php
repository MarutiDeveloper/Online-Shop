@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h1>Edit  Company Information</h1>
    <form action="{{ route('admin.contact_us.update', $contactInfo->id) }}" method="POST">
    @csrf
    @method('POST') <!-- Method to use PUT for updates -->

    <div class="form-group">
        <label for="company_name">Company Name</label>
        <input type="text" name="company_name" id="company_name" class="form-control" value="{{ old('company_name', $contactInfo->company_name) }}" required maxlength="255">
    </div>

    <div class="form-group">
        <label for="company_address">Company Address</label>
        <textarea name="company_address" id="company_address" class="form-control" required>{{ old('company_address', $contactInfo->company_address) }}</textarea>
    </div>

    <div class="form-group">
        <label for="company_phone_number">Company Phone Number</label>
        <input type="text" name="company_phone_number" id="company_phone_number" class="form-control" value="{{ old('company_phone_number', $contactInfo->company_phone_number) }}" required maxlength="15">
    </div>

    <div class="form-group">
        <label for="company_email">Company Email</label>
        <input type="email" name="company_email" id="company_email" class="form-control" value="{{ old('company_email', $contactInfo->company_email) }}" required>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>
</div>
@endsection