@extends('backEnd.layout.master')
@section('title','Subscribers')
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="mb-0 fw-semibold">Subscribers</h4>

                <ol class="breadcrumb mb-0">
                    {{-- এখানে ব্র্যান্ডের মতো এক্সট্রা কোনো বাটন সাধারণত লাগে না, তবে টোটাল কাউন্ট দেখানো যেতে পারে --}}
                    <span class="badge bg-primary fs-6">Total Subscribers: {{ $subscribers->total() }}</span>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle text-wrap w-100">
                            <thead>
                            <tr>
                                <th width="80">SL</th>
                                <th>Email Address</th>
                                <th>Subscribed At</th>
                                <th width="150">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($subscribers as $key => $subscriber)
                                <tr>
                                    <td>{{ $subscribers->firstItem() + $key }}</td>
                                    <td class="fw-medium">{{ $subscriber->email }}</td>
                                    <td>{{ $subscriber->created_at->format('d M, Y - h:i A') }}</td>
                                    <td>
                                        {{-- আপনার ব্র্যান্ডের ডিলিট বাটনের মতো সেম ডিজাইন --}}
                                        <button class="btn btn-sm btn-danger" onclick="deleteSubscriber({{ $subscriber->id }})">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{-- আপনার কাস্টম পেজিনেশন লিংক --}}
                    {{ $subscribers->links('backEnd.layout.paginate') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        // ব্র্যান্ডের ডিলিট ফাংশনের সাথে হুবহু ম্যাচ করা সুইটঅ্যালার্ট কোড
        function deleteSubscriber(id)
        {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result)=>{
                if(result.isConfirmed){
                    $.ajax({
                        url: "{{ route('admin.subscribers.destroy') }}", // আপনার রাউট নাম অনুযায়ী মিলিয়েনিবেন
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id
                        },
                        success: function(){
                            location.reload();
                        }
                    });
                }
            });
        }
    </script>
@endpush
