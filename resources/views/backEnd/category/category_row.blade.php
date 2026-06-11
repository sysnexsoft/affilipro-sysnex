@foreach ($children as $child)
    <div class="d-flex align-items-center mb-1">
        <svg style="margin-top: -5px;" xmlns="http://www.w3.org/2000/svg"
             class="icon icon-tabler icon-tabler-corner-down-right"
             width="15" height="15" viewBox="0 0 24 24" stroke-width="1.5"
             stroke="currentColor" fill="none" stroke-linecap="round"
             stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
            <path d="M6 6v6a3 3 0 0 0 3 3h10l-4 -4m0 8l4 -4"></path>
        </svg>

        <div class="border p-1 shadow">
            <span>
            <strong>Name : </strong>{{ $child->name }} <br>
            <strong>Slug : </strong>{{ $child->slug }}
        </span>

            {{-- Add Sub --}}
            <button class="btn btn-success btn-sm action-btn add_sub_cat_btn ms-1"
                    data-id="{{ $child->id }}"
                    data-name="{{ $child->name }}">
                <i class="ri-add-fill"></i>
            </button>

            {{-- Edit --}}
            <a href="javascript:void(0)"
               class="btn btn-primary btn-sm action-btn editBtn ms-1"

               data-bs-toggle="modal"
               data-bs-target="#editCategory"
               data-id="{{ $child->id }}"
               data-url="{{ route('admin.category.update',$child->id) }}"

               data-parent_id="{{ $child->parent_id }}"
               data-position="{{ $child->position }}"
               data-featured="{{ $child->featured }}"

               data-name="{{ $child->name }}"
               data-slug="{{ $child->slug }}"
               data-description="{{ $child->description }}"
               data-meta_title="{{ $child->meta_title }}"
               data-meta_description="{{ $child->meta_description }}"
               data-meta_keywords="{{ $child->meta_keywords }}"
               data-status="{{ $child->status }}"
               data-image="{{ asset('uploads/category/'.$child->image) }}">

                <i class="ri-edit-2-line"></i>
            </a>

            {{-- Delete --}}
            <button
                type="button"
                class="btn btn-danger btn-sm action-btn ms-1"
                onclick="deleteCategory({{ $child->id }})">

                <i class="ri-delete-bin-2-line"></i>

            </button>
        </div>

    </div>

    {{-- Recursive children --}}
    @if ($child->childrenRecursive->count())
        <div class="ms-4 mt-1">
            @include('backEnd.category.category_row', ['children' => $child->childrenRecursive])
        </div>
    @endif

@endforeach
