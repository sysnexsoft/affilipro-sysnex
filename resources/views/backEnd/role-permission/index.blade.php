@extends('backEnd.layout.master')
@section('title','Role Permission')
@section('body')

    <!-- ========== Page Title Start ========== -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="mb-0 fw-semibold">Role & Permissions</h4>
                <ol class="breadcrumb mb-0">
                    <a class="btn btn-sm btn-primary" href="{{route('admin.role.permission.create')}}">Add Role</a>
                </ol>
            </div>
        </div>
    </div>
    <!-- ========== Page Title End ========== -->

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
                                <th>Permissions</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($role_permissions as $key => $item)
                                <?php
                                $rolePermissions = \Illuminate\Support\Facades\DB::table('role_has_permissions')
                                    ->where('role_has_permissions.role_id', $item->id)
                                    ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                                    ->all();
                                ?>
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $item->name }}</td>
                                    <td style="text-wrap: wrap;">
                                        @foreach ($item->permissions as $permission)
                                            <span
                                                class="badge bg-primary">{{ ucwords(str_replace('.', ' ',$permission->name)) }}
                                                </span>
                                        @endforeach
                                    </td>

                                    <td>
                                        <div class="d-flex gap-2">
{{--                                            <a href="#!" class="btn btn-light btn-sm"><iconify-icon icon="solar:eye-broken" class="align-middle fs-18"></iconify-icon></a>--}}
                                            <a href="{{ route('admin.role.permission.edit', $item->id) }}" class="btn btn-soft-primary btn-sm"><iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon></a>
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

@endsection
@push('js')
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
                        url: "{{ route('admin.role.permission.delete') }}",
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
