@extends('backEnd.layout.master')
@section('title','Brands')
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="mb-0 fw-semibold">Brands</h4>

                <ol class="breadcrumb mb-0">
                    <a href="javascript:void(0)"
                       data-bs-toggle="modal"
                       data-bs-target="#addBrand"
                       class="btn btn-primary btn-sm">
                        Add Brand
                    </a>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Logo</th>
                                    <th>Name</th>
                                    <th>Website</th>
                                    <th>Status</th>
                                    <th width="150">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($brands as $brand)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if($brand->logo)
                                                <img src="{{ asset($brand->logo) }}" width="100">
                                            @endif
                                        </td>
                                        <td>{{ $brand->name }}</td>
                                        <td>{{ $brand->website }}</td>
                                        <td>
                                            @if($brand->status)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-primary editBrandBtn"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editBrand"
                                                data-id="{{ $brand->id }}"
                                                data-url="{{ route('admin.brand.update',$brand->id) }}"
                                                data-name="{{ $brand->name }}"
                                                data-slug="{{ $brand->slug }}"
                                                data-description="{{ $brand->description }}"
                                                data-website="{{ $brand->website }}"
                                                data-meta_title="{{ $brand->meta_title }}"
                                                data-meta_description="{{ $brand->meta_description }}"
                                                data-status="{{ $brand->status }}"
                                                data-logo="{{ $brand->logo ? asset($brand->logo) : '' }}">Edit</button>
                                            <button class="btn btn-sm btn-danger" onclick="deleteBrand({{ $brand->id }})">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $brands->links('backEnd.layout.paginate') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addBrand">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <form action="{{ route('admin.brand.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <div class="modal-header">
                        <h5>Add Brand</h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label>Name</label>
                                <input type="text"
                                       name="name"
                                       class="form-control"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Website</label>
                                <input type="url"
                                       name="website"
                                       class="form-control">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Logo</label>
                                <input type="file"
                                       name="logo"
                                       class="form-control">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Description</label>
                                <textarea name="description"
                                          rows="4"
                                          class="form-control"></textarea>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Meta Title</label>
                                <input type="text"
                                       name="meta_title"
                                       class="form-control">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Meta Description</label>
                                <textarea name="meta_description"
                                          rows="3"
                                          class="form-control"></textarea>
                            </div>

                            <div class="col-md-12">
                                <label>Status</label>

                                <select name="status"
                                        class="form-select">

                                    <option value="1">
                                        Active
                                    </option>

                                    <option value="0">
                                        Inactive
                                    </option>

                                </select>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary">
                            Save Brand
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
    <div class="modal fade" id="editBrand">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <form id="editBrandForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5>Edit Brand</h5>
                        <button  type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Name</label>
                                <input type="text"
                                       name="name"
                                       id="edit_name"
                                       class="form-control"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Website</label>
                                <input type="url"
                                       name="website"
                                       id="edit_website"
                                       class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Logo</label>
                                <input type="file"
                                       name="logo"
                                       class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <img id="edit_logo_preview"
                                     class="img-thumbnail"
                                     style="max-height:100px;display:none;">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Description</label>
                                <textarea name="description"
                                          id="edit_description"
                                          rows="4"
                                          class="form-control"></textarea>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Meta Title</label>
                                <input type="text"
                                       name="meta_title"
                                       id="edit_meta_title"
                                       class="form-control">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Meta Description</label>
                                <textarea name="meta_description"
                                          id="edit_meta_description"
                                          rows="3"
                                          class="form-control"></textarea>
                            </div>

                            <div class="col-md-12">
                                <label>Status</label>

                                <select name="status"
                                        id="edit_status"
                                        class="form-select">

                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>

                                </select>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal">
                            Close
                        </button>

                        <button type="submit"
                                class="btn btn-primary">
                            Update Brand
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        function deleteBrand(id)
        {
            Swal.fire({
                title:'Are you sure?',
                icon:'warning',
                showCancelButton:true
            }).then((result)=>{
                if(result.isConfirmed){
                    $.ajax({
                        url:"{{ route('admin.brand.delete') }}",
                        type:"POST",
                        data:{
                            _token:"{{ csrf_token() }}",
                            id:id
                        },
                        success:function(){
                            location.reload();
                        }
                    });
                }
            });
        }

        $(document).on('change', '.editImageInput', function () {
            let input = this;
            let preview = $(this).closest('.row').find('.editPreviewImage');
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    preview.attr('src', e.target.result);
                    preview.show();
                }
                reader.readAsDataURL(input.files[0]);
            }
        });
        $(document).on('click', '.editBrandBtn', function () {
            let btn = $(this);
            $('#editBrandForm').attr('action', btn.data('url'));
            $('#edit_name').val(btn.data('name'));
            $('#edit_website').val(btn.data('website'));
            $('#edit_description').val(btn.data('description'));
            $('#edit_meta_title').val(btn.data('meta_title'));
            $('#edit_meta_description').val(btn.data('meta_description'));
            $('#edit_status').val(btn.data('status'));
            let logo = btn.data('logo');
            if (logo) {
                $('#edit_logo_preview').attr('src', logo).show();
            } else {
                $('#edit_logo_preview').hide();
            }
        });
    </script>
@endpush
