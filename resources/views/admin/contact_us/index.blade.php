@extends('admin.layouts.app')

@section('content')

<div class="container mt-5">
    <h1 class="mb-4">Company Entries</h1>

    <!-- Success message if needed -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Button to create new contact entry -->
    <div class="mb-3">
        <a href="{{ route('admin.contact_us.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-3"></i> <span>Create New Company</span>
        </a>
    </div>

    <!-- Table to display contact entries -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($allContactInfo as $contact) <!-- Loop through the records -->
                    <tr>
                        <td>{{ $contact->id }}</td>
                        <td>{{ $contact->company_name }}</td>
                        <td>{{ $contact->company_address }}</td>
                        <td>{{ $contact->company_phone_number }}</td>
                        <td>{{ $contact->company_email }}</td>
                        <td>
                            <!-- Edit button -->
                            <a href="{{ route('admin.contact_us.edit', $contact->id) }}" 
                               class="btn btn-warning btn-sm me-2">
                                <i class="fas fa-edit"></i> Edit
                            </a>

                            <!-- Delete form -->
                            <form action="{{ route('admin.contact_us.destroy', $contact->id) }}" 
                                  method="POST" style="display:inline;" 
                                  onsubmit="return confirm('Are you sure you want to delete this company?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No company entries found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('customJs')
<!-- Include any custom JS here -->
@endsection
