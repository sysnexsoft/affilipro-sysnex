@extends('backEnd.layout.master')
@section('title','Profile')
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="mb-0 fw-semibold">Profile Update</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form action="{{route('admin.profile.update')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card floating-card bg-transparent mb-1">
                    <div class="card-body d-flex justify-content-end">
                        <div class="d-flex">
                            <a href="{{url()->previous()}}"
                               class="btn btn-sm btn-dark me-2 d-flex align-items-center custom_btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M15 6l-6 6l6 6"/>
                                </svg>
                                BACK
                            </a>
                            <button type="submit" class="btn btn-success btn-sm custom_btn d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                     stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"/>
                                    <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/>
                                    <path d="M14 4l0 4l-6 0l0 -4"/>
                                </svg>
                                SAVE
                            </button>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" class="form-control" name="name" value="{{ auth()->user()->name}}" placeholder="Name">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" value="{{ auth()->user()->email}}" placeholder="Email" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="example-avatar" class="form-label">Profile Image</label>
                        <input type="file" id="example-avatar" name="avatar" class="form-control">
                        <img src="{{asset(auth()->user()->avatar)}}" alt="" class="img-fluid mt-1" width="100">
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection
