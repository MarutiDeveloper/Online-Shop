@extends('admin.layouts.app')

@section('content')

<div class="container">
    <h1 class="mt-4"> Company Entries</h1>

    <!-- Success message if needed -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Button to create new contact entry -->
    <a href="{{ route('admin.contact_us.create') }}" class="btn btn-primary mb-3">Create New Company</a>

    <!-- Table to display contact entries -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Company Name</th>
                <th>Company Address</th>
                <th>Company Phone Number</th>
                <th>Company Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($allContactInfo as $contact) <!-- Loop through the records -->
                <tr>
                    <td>{{ $contact->id }}</td>
                    <td>{{ $contact->company_name }}</td>
                    <td>{{ $contact->company_address }}</td>
                    <td>{{ $contact->company_phone_number }}</td>
                    <td>{{ $contact->company_email }}</td>
                    <td>
                        <!-- Edit button -->
                        <a href="{{ route('admin.contact_us.edit', $contact->id) }}" class="btn btn-warning btn-sm">Edit</a>

                        <!-- Delete form -->
                        <form action="{{ route('admin.contact_us.destroy', $contact->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('customJs')

@endsection