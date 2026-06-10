@extends('backEnd.layout.master')
@section('title', 'Access Denied')
@section('body')
    <div class="text-center py-5">
        <h1 class="display-1 text-danger">403</h1>
        <h3 class="mb-3">Access Denied</h3>
        <p class="mb-4">You do not have permission to access this page.</p>

        <a href="{{ url()->previous() }}" class="btn btn-primary">
            Go Back
        </a>
    </div>
@endsection
