@extends('backEnd.layout.master')
@section('title')
    Edit Role & Permissions
@endsection

@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="mb-0 fw-semibold">Edit Role</h4>
            </div>
        </div>
    </div>
    <div class="row">
            <div class="col-md-12">
                <form action="{{ route('admin.role.permission.update', $role->id) }}" method="POST" id="myForm"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="card floating-card bg-transparent mb-1">
                        <div class="card-body d-flex justify-content-end">
                            <a href="{{ route('admin.role.permission') }}"
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
                    <div class="card card-body p-4">
                        <div class="row mb-3">
                            <label for="role_name" class="col-sm-2 col-form-label"><b>Role
                                    Name</b></label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="role_name"
                                       value="{{ $role->name }}" name="name"
                                       placeholder="Role Name">
                            </div>
                        </div>
                        <fieldset class="row mb-3">
                            <legend class="col-form-label col-sm-12 pt-0 mb-4">
                                <b>Permissions</b>
                            </legend>
                            <div class="col-sm-10 ">
                                <div class="form-check">
                                    <input class="form-check-input all_select" type="checkbox"
                                           id="select_all"
                                           style="height: 15px; width: 15px; margin-right: 5px;">
                                    <label class="form-check-label" for="select_all"
                                           style="font-size: 13px; margin-top: 2px;">
                                        Select All
                                    </label>
                                </div>
                            </div>

                        </fieldset>
                        <div class="row">
                            @foreach ($array as $key => $items)
                                <div class="col-md-4">
                                    <div class="card_check">
                                        <div class="row p-4">
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input manage_check"
                                                           type="checkbox" id="{{ $key }}"
                                                           style="height: 15px; width: 15px; margin-right: 5px;">
                                                    <label class="form-check-label"
                                                           for="{{ $key }}"
                                                           style="font-size: 13px; margin-top: 2px;">
                                                        {{ ucfirst($key) }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-8 mt-2">
                                                @foreach ($items as $permission)
                                                    <div class="form-check">
                                                        <input class="form-check-input ddd item"
                                                               type="checkbox"
                                                               {{ in_array($permission->id, $role_permissions) ? 'checked' : '' }}
                                                               name="permission[]"
                                                               value="{{ $permission->name }}"
                                                               id="{{ $permission->name }}"
                                                               style="height: 15px; width: 15px; margin-right: 5px;">
                                                        <label class="form-check-label"
                                                               for="{{ $permission->name }}"
                                                               style="font-size: 13px; margin-top: 2px;">
                                                            {{ ucwords(str_replace('.', ' ', $permission->name)) }}
                                                        </label>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </form>

            </div>
        </div>
@endsection
@push('js')
    <script src="{{ asset('backEnd/assets/libs/summernote/summernote-lite.min.js') }}"></script>
    <script src="{{ asset('backEnd/assets/js/select2.min.js') }}"></script>

    <!-- Date & Time Picker JS -->
    <script src="{{ asset('backEnd/assets/libs/flatpickr/flatpickr.min.js') }}"></script>


    <script>
        $(document).on('change', '.all_select', function() {
            $('input[type="checkbox"]').prop('checked', $(this).prop('checked'));
        })

        $('.item').click(function() {
            let parent = $(this).closest('.card_check').find('.manage_check');
            console.log(parent)
            var allChecked = $(this).closest('.card_check').find('.item').length === $(this).closest('.card_check')
                .find(
                    '.item:checked').length;
            if (allChecked) {
                parent.prop('checked', true);
            } else {
                parent.prop('checked', false);
            }
        });
        $('.manage_check').click(function() {
            let parent = $(this).closest('.card-body').find('.all_select');
            console.log(parent)
            var allChecked = $(this).closest('.card-body').find('.manage_check').length === $(this).closest(
                '.card-body').find('.manage_check:checked').length;
            console.log(allChecked);
            if (allChecked) {
                console.log('all check')
                parent.prop('checked', true);
            } else {
                console.log('all not check')
                parent.prop('checked', false);
            }
        });


        $(document).on('change', '.manage_check', function() {
            $(this).closest('.card_check').find('input[type="checkbox"]').prop('checked', $(this).prop('checked'));

        });
    </script>
    <script>
        $(document).ready(function() {
            function update_check() {
                $('.manage_check').each(function() {
                    // console.log( $(this).parents('.card_custom').find('.item'))
                    var all_checked = $(this).parents('.card_check').find('.item').length == $(this)
                        .parents('.card_check').find('.item:checked').length;
                    if (all_checked) {
                        $(this).prop('checked', true);
                    } else {
                        $(this).prop('checked', false);
                    }
                })
            }
            update_check();
        })
    </script>
    <script>
        function all_check() {
            let all_select = $('.all_select')
            let check = $('.manage_check:checked').length;
            let total_checkbox = $('.manage_check').length;
            if (check == total_checkbox) {
                all_select.prop('checked', true);
            } else {
                all_select.prop('checked', false);
            }
        }
        $(document).ready(function() {
            all_check();
        })
    </script>
@endpush

