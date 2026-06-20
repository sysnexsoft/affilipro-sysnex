@extends('backEnd.layout.master')
@section('title','Category')

@section('body')

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="mb-0 fw-semibold">Categories</h4>

                <ol class="breadcrumb mb-0">
                    <a href="javascript:void(0)"
                       data-bs-toggle="modal"
                       data-bs-target="#addCategory"
                       class="btn btn-primary btn-sm">
                        Add Category
                    </a>
                </ol>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="mytable" class="table table-bordered">
                    <thead>
                    <tr>

                        <th>SL</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th>Action</th>

                    </tr>
                    </thead>

                    <tbody>

                    @foreach($categories as $item)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>
                                @if($item->image)
                                    <img src="{{ asset($item->image) }}"
                                         width="60">
                                @endif
                            </td>
                            <td class="text-start">
                                <b>{{ $item->name }}</b>
                                <button class="btn btn-success action-btn btn-sm add_sub_cat_btn p-0 m-0"
                                        data-id="{{ $item->id }}" data-name="{{ $item->name }}">
                                    <i class="ri-add-fill"></i>
                                </button>

                                @if ($item->childrenRecursive->count())
                                    <div class="ms-4 mt-1">
                                        @include('backEnd.category.category_row', [
                                            'children' => $item->childrenRecursive,
                                        ])
                                    </div>
                                @endif
                            </td>
                            <td>{{ $item->slug }}</td>
                            <td>
                                @if($item->status)
                                    <span class="badge bg-success">
                                    Active
                                </span>
                                @else
                                    <span class="badge bg-danger">
                                    Inactive
                                </span>
                                @endif
                            </td>

                            <td>

                                <button
                                    class="btn btn-sm btn-primary editBtn"

                                    data-bs-toggle="modal"
                                    data-bs-target="#editCategory"
                                    data-id="{{ $item->id }}"
                                    data-url="{{ route('admin.category.update',$item->id) }}"

                                    data-name="{{ $item->name }}"
                                    data-slug="{{ $item->slug }}"
                                    data-description="{{ $item->description }}"
                                    data-meta_title="{{ $item->meta_title }}"
                                    data-meta_description="{{ $item->meta_description }}"
                                    data-meta_keywords="{{ $item->meta_keywords }}"
                                    data-status="{{ $item->status }}"
                                    data-image="{{ asset($item->image) }}"
                                    data-parent_id="{{ $item->parent_id }}"
                                    data-position="{{ $item->position }}"
                                    data-featured="{{ $item->featured }}"
                                >
                                    Edit
                                </button>

                                <button
                                    class="btn btn-sm btn-danger"
                                    onclick="deleteCategory({{ $item->id }})">
                                    Delete
                                </button>

                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>
            </div>
            {{ $categories->links('backEnd.layout.paginate') }}
        </div>
    </div>
    <!-- Add Modal -->
    <div class="modal fade"
         id="addCategory"
         tabindex="-1">

        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <form action="{{ route('admin.category.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">
                            Add Category
                        </h5>

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Parent Category</label>
                                <select name="parent_id" class="form-select" id="add_parent_id">
                                    <option value="">Main Category</option>
                                    @foreach($allCategories as $cat)
                                        <option value="{{ $cat->id }}">
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Name *</label>
                                <input type="text"
                                       id="name"
                                       name="name"
                                       class="form-control"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Slug *</label>
                                <input type="text"
                                       id="slug"
                                       name="slug"
                                       class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Position</label>
                                <input type="number" name="position" class="form-control" value="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Featured</label>
                                <select name="featured" class="form-select">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Image</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Description</label>
                                <textarea name="description" rows="4" class="form-control"></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Meta Title</label>
                                <input type="text" name="meta_title" class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Meta Description</label>
                                <textarea name="meta_description" rows="3" class="form-control"></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label>Meta Keywords</label>
                                <textarea name="meta_keywords" rows="3" class="form-control"></textarea>
                            </div>
                            <div class="col-md-4">
                                <label>Status</label>
                                <select name="status" class="form-select">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>

                </form>

            </div>
        </div>
    </div>


    <!-- Edit Modal -->
    <div class="modal fade"
         id="editCategory"
         tabindex="-1">

        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label>Parent Category</label>
                                <select name="parent_id" id="edit_parent_id" class="form-select">
                                    <option value="">Main Category</option>
                                    @foreach($allCategories as $cat)
                                        <option value="{{ $cat->id }}">
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Name *</label>
                                <input type="text"
                                       id="edit_name"
                                       name="name"
                                       class="form-control"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Slug *</label>
                                <input type="text"
                                       id="edit_slug"
                                       name="slug"
                                       class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Position</label>
                                <input type="number"
                                       id="edit_position"
                                       name="position"
                                       class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Featured</label>
                                <select name="featured"
                                        id="edit_featured"
                                        class="form-select">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Image</label>
                                <input type="file"
                                       name="image"
                                       class="form-control">

                                <img id="previewImage"
                                     src=""
                                     width="80"
                                     class="mt-2">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Description</label>
                                <textarea id="edit_description"
                                          name="description"
                                          rows="4"
                                          class="form-control"></textarea>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Meta Title</label>
                                <input type="text"
                                       id="edit_meta_title"
                                       name="meta_title"
                                       class="form-control">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Meta Description</label>
                                <textarea id="edit_meta_description"
                                          name="meta_description"
                                          rows="3"
                                          class="form-control"></textarea>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Meta Keywords</label>
                                <textarea id="edit_meta_keywords"
                                          name="meta_keywords"
                                          rows="3"
                                          class="form-control"></textarea>
                            </div>

                            <div class="col-md-4">
                                <label>Status</label>
                                <select id="edit_status"
                                        name="status"
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
                            Update
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>


    <style>
        .action-btn{
            width: 22px;
            height: 22px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-left: 4px;
        }

        .action-btn i{
            font-size: 14px;
        }
    </style>

@endsection


@push('js')

    <script>
        function generateSlug(text) {
            return text
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/--+/g, '-');
        }

        // Add Modal
        $('#name').on('keyup', function () {
            $('#slug').val(generateSlug($(this).val()));
        });

        // Edit Modal
        $('#edit_name').on('keyup', function () {
            $('#edit_slug').val(generateSlug($(this).val()));
        });

        $(document).on('click','.editBtn',function(){

            let btn = $(this);
            let currentId = btn.data('id');

            $('#editCategory form').attr('action', btn.data('url'));

            $('#edit_parent_id').val(btn.data('parent_id'));
            $('#edit_position').val(btn.data('position'));
            $('#edit_featured').val(btn.data('featured'));

            $('#edit_name').val(btn.data('name'));
            $('#edit_slug').val(btn.data('slug'));
            $('#edit_description').val(btn.data('description'));
            $('#edit_meta_title').val(btn.data('meta_title'));
            $('#edit_meta_description').val(btn.data('meta_description'));
            $('#edit_meta_keywords').val(btn.data('meta_keywords'));
            $('#edit_status').val(btn.data('status'));

            $('#previewImage').attr('src', btn.data('image'));

            // Current category hide
            $('#edit_parent_id option').show();
            $('#edit_parent_id option[value="'+currentId+'"]').hide();
        });

        function deleteCategory(id)
        {
            Swal.fire({
                title:'Are you sure?',
                icon:'warning',
                showCancelButton:true
            }).then((result)=>{

                if(result.isConfirmed){

                    $.ajax({

                        url:"{{ route('admin.category.delete') }}",

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
        $(document).on('click', '.add_sub_cat_btn', function () {

            let id = $(this).data('id');
            let name = $(this).data('name');

            $('#add_parent_id').val(id);

            $('#selected_parent_name').text(name);

            $('#addCategory').modal('show');
        });
    </script>

@endpush
