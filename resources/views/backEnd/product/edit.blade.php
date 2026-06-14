@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')

    <div class="container-fluid">

        <div class="card">

            <div class="card-header d-flex justify-content-between">

                <h4>Edit Product</h4>

                <a href="{{ route('admin.product.index') }}"
                   class="btn btn-secondary">
                    Back
                </a>

            </div>

            <div class="card-body">

                <form action="{{ route('admin.product.update',$product->id) }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    {{-- create page er same form --}}

                    {{-- value="{{ old('title',$product->title) }}" use korba --}}
                    {{-- category selected korba --}}
                    {{-- brand selected korba --}}
                    {{-- checkbox checked korba --}}
                    {{-- image preview show korba --}}

                </form>

            </div>

        </div>

    </div>

@endsection
