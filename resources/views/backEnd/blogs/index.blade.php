@extends('backEnd.layout.master')
@section('title', 'All Blog Posts')

@section('body')
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Blogs</h5>
            <a href="{{ route('admin.blogs.create') }}" class="btn btn-sm btn-light">+ Add New Blog</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Thumbnail</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Views</th>
                        <th>Featured</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($blogs as $key => $blog)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                @if($blog->thumbnail)
                                    <img src="{{ asset($blog->thumbnail) }}" width="60" class="rounded">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>{{ \Illuminate\Support\Str::limit($blog->title, 40) }}</td>
                            <td><span class="badge bg-secondary">{{ $blog->category->name }}</span></td>
                            <td><i class="ri-eye-line"></i> {{ $blog->views }}</td>
                            <td><span class="badge {{ $blog->featured ? 'bg-warning text-dark' : 'bg-light text-muted' }}">{{ $blog->featured ? 'Yes' : 'No' }}</span></td>
                            <td><span class="badge {{ $blog->status ? 'bg-success' : 'bg-danger' }}">{{ $blog->status ? 'Active' : 'Inactive' }}</span></td>
                            <td>
                                <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="btn btn-sm btn-info text-white">Edit</a>
                                <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No blogs found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            {{ $blogs->links('backEnd.layout.paginate') }}
        </div>
    </div>
@endsection
