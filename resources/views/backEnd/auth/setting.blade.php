@extends('backEnd.layout.master')
@section('title','Setting')
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="mb-0 fw-semibold">Company Settings</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form action="{{route('admin.setting.update')}}" method="post" enctype="multipart/form-data">
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
                            <button type="submit" class="btn btn-primary btn-sm custom_btn d-flex align-items-center">
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
                        <label for="simpleinput" class="form-label">Company Name</label>
                        <input type="text" id="simpleinput" class="form-control" name="company_name" value="{{$web_setting->company_name}}" placeholder="Company Name">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="company_title" class="form-label">Company Title</label>
                        <input type="text" id="company_title" name="company_title" value="{{$web_setting->company_title}}" placeholder="Company Title" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="example-email" class="form-label">Email</label>
                        <input type="email" id="example-email" value="{{$web_setting->email}}" name="email" class="form-control" placeholder="Email">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="example-email_2" class="form-label">Email 2</label>
                        <input type="email" id="example-email_2" value="{{$web_setting->email_2}}" name="email_2" class="form-control" placeholder="Email">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="example-phone" class="form-label">Phone</label>
                        <input type="tel" id="example-phone" value="{{$web_setting->phone}}" name="phone" class="form-control" placeholder="Phone">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="example-phone_2" class="form-label">Phone 2</label>
                        <input type="tel" id="example-phone_2" value="{{$web_setting->phone_2}}" name="phone_2" class="form-control" placeholder="phone 2">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="example-header_logo" class="form-label">Header Logo</label>
                        <input type="file" id="example-header_logo" name="header_logo" value="{{$web_setting->header_logo}}" class="form-control">
                        <img src="{{asset($web_setting->header_logo)}}" alt="" class="img-fluid w-25 mt-1">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="example-footer_logo" class="form-label">Footer Logo</label>
                        <input type="file" id="example-footer_logo" name="footer_logo" value="{{$web_setting->footer_logo}}" class="form-control">
                        <img src="{{asset($web_setting->footer_logo)}}" alt="" class="img-fluid w-25 mt-1">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="example-favicon_logo" class="form-label">Favicon Logo</label>
                        <input type="file" id="example-favicon_logo" name="favicon_logo" value="{{$web_setting->favicon_logo}}" class="form-control">
                        <img src="{{asset($web_setting->favicon_logo)}}" alt="" class="mt-1" style="width: 100px">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="example-address" class="form-label">address</label>
                        <textarea class="form-control" id="example-address" name="address" rows="5"> {{$web_setting->address}} </textarea>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection
