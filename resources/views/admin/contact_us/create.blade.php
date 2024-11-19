@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Create Company Information</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.contact_us.store') }}" method="POST">
                        @csrf

                        <!-- Company Name -->
                        <div class="mb-3">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input 
                                type="text" 
                                name="company_name" 
                                id="company_name" 
                                class="form-control" 
                                placeholder="Enter company name" 
                                required 
                                maxlength="255">
                        </div>

                        <!-- Company Address -->
                        <div class="mb-3">
                            <label for="company_address" class="form-label">Company Address</label>
                            <textarea 
                                name="company_address" 
                                id="company_address" 
                                class="form-control" 
                                placeholder="Enter company address" 
                                rows="3" 
                                required></textarea>
                        </div>

                        <!-- Company Phone Number -->
                        <div class="mb-3">
                            <label for="company_phone_number" class="form-label">Company Phone Number</label>
                            <input 
                                type="text" 
                                name="company_phone_number" 
                                id="company_phone_number" 
                                class="form-control" 
                                placeholder="Enter phone number" 
                                required 
                                maxlength="15">
                        </div>

                        <!-- Company Email -->
                        <div class="mb-3">
                            <label for="company_email" class="form-label">Company Email</label>
                            <input 
                                type="email" 
                                name="company_email" 
                                id="company_email" 
                                class="form-control" 
                                placeholder="Enter email address" 
                                required>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between pt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create
                            </button>
                            <a href="{{ route('admin.contact_us.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
