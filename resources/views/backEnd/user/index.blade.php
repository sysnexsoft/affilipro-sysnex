@extends('backEnd.layout.master')
@section('title','Users')
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="mb-0 fw-semibold">Users</h4>
                <ol class="breadcrumb mb-0">
                    <a data-bs-target="#addUser" data-bs-toggle="modal" class="btn btn-sm btn-primary" href="{{route('admin.role.permission.create')}}">Add User</a>
                </ol>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal modal-lg fade" id="addUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{route('admin.user.store')}}" method="post">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Add User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label ">Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name"
                                       name="name" placeholder="Name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label">Role <span
                                        class="text-danger">*</span> </label>
                                <select name="role" id="role" class="form-select " required
                                        style="padding:10px ">
                                    <option value="">Select A Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}">{{ $role }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone </label>
                                <input type="text" name="phone" class="form-control"
                                       id="phone" placeholder="Phone">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span
                                        class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control"
                                       id="email" placeholder="Email" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password <span
                                        class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control"
                                       id="password" placeholder="Password" required>
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
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="mytable" class="table align-middle text-nowrap table-hover table-centered mb-0">
                            <thead class="bg-light-subtle">
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $key => $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->phone }}</td>
                                    <td style="text-wrap: wrap;">
                                            @if (!empty($item->getRoleNames()))
                                                @foreach ($item->getRoleNames() as $role)
                                                    <span class="badge bg-primary">{{ $role }}</span>
                                                @endforeach
                                            @endif
                                    </td>

                                    <td>
                                        <div class="d-flex gap-2">
                                            {{--                                            <a href="#!" class="btn btn-light btn-sm"><iconify-icon icon="solar:eye-broken" class="align-middle fs-18"></iconify-icon></a>--}}
                                            <a data-bs-target="#editUser" data-bs-toggle="modal" class="btn btn-soft-primary btn-sm"
                                            data-url="{{route('admin.user.update',$item->id)}}"
                                            data-name="{{$item->name}}"
                                            data-email="{{$item->email}}"
                                            data-phone="{{$item->phone}}"
                                            data-role="{{$item->roles->first()->name}}"
                                            data-image="{{asset($item->image)}}"
                                            >
                                                <iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon>
                                            </a>
                                            <a href="javascript:void(0);" onclick="deleteForm({{ $item->id }})"
                                               title="Delete" class="btn btn-soft-danger btn-sm"><iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div> <!-- end table-responsive -->
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-lg fade" id="editUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Add User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Image</label>
                            <input type="file" name="image" id="image" class="form-control">
                            <!-- Preview -->
                            <img id="previewImage"
                                 src=""
                                 class="mt-2"
                                 style="width: 80px; height: 80px; border-radius: 8px; display:none;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label ">Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name"
                                   name="name" placeholder="Name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="role" class="form-label">Role <span
                                    class="text-danger">*</span> </label>
                            <select name="role" id="role" class="form-select " required
                                    style="padding:10px ">
                                <option value="">Select A Role</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role }}">{{ $role }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone </label>
                            <input type="text" name="phone" class="form-control"
                                   id="phone" placeholder="Phone">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email <span
                                    class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control"
                                   id="email" placeholder="Email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control"
                                   id="password" placeholder="Password">
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
@endsection
@push('js')
    <script>
        $(document).on("click", "a[data-bs-target='#editUser']", function () {
            let url = $(this).data("url");
            let name = $(this).data("name");
            let email = $(this).data("email");
            let phone = $(this).data("phone");
            let image = $(this).data("image");
            let role = $(this).data("role");
            $("#editUser #role").val(role);

            // Form action set
            $("#editUser form").attr("action", url);

            // Input value fill
            $("#editUser #name").val(name);
            $("#editUser #email").val(email);
            $("#editUser #phone").val(phone);

            // Old image preview
            if (image) {
                $("#previewImage").attr("src", image).show();
            } else {
                $("#previewImage").hide();
            }

            // password optional
            $("#editUser #password").prop('required', false);
        });

        // New image select করলে live preview দেখাবে
        $("#image").on("change", function () {
            let reader = new FileReader();
            reader.onload = function (e) {
                $("#previewImage").attr("src", e.target.result).show();
            };
            reader.readAsDataURL(this.files[0]);
        });

    </script>
    <script>
        //department delete
        function deleteForm(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to be delete this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.user.delete') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id
                        },
                        success: function(data) {
                            $("#mytable").load(location.href + ' #mytable>*', "");
                            Swal.fire({
                                icon: 'success',
                                title: 'Role Permission Delete Successfully',
                                showConfirmButton: false,
                                timer: 1000
                            })
                        },
                        error: function() {
                            console.log(data);
                        }
                    });
                }
            })
        }
    </script>
@endpush
