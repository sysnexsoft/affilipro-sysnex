@extends('backEnd.layout.master')
@section('title', 'Real-time Traffic Logs')

@section('body')
    <div class="">
        <div class="card">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">🌐 Real-time Traffic Logs</h5>
                <span class="badge bg-danger animate-pulse">● Live Tracking</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle fs-5">
                        <thead class="table-light">
                        <tr>
                            <th>Time</th>
                            <th>Target URL</th>
                            <th>IP Address</th>
                            <th>Country</th>
                            <th>Device / Browser</th>
                            <th>Referrer</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($logs as $log)
                        <tr>
                            <td><small class="text-muted">{{ $log->created_at->diffForHumans() }}</small></td>
                            <td><code><a target="_blank" class="text-danger" href="{{$log->url}}">{{ Str::limit($log->url, 40) }}</a></code></td>
                            <td><span class="badge bg-secondary">{{ $log->ip_address }}</span></td>
                            <td>🌍 {{ $log->country }}</td>
                            <td>
                                <small>
                                    <strong>{{ ucfirst($log->device) }}</strong> / {{ $log->browser }}
                                </small>
                            </td>
                            <td>
                                <span class="text-success">{{ $log->referrer ?? 'Direct VIsit' }}</span>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $logs->links('backEnd.layout.paginate') }}
                <div class="d-flex justify-content-end mt-3">

                </div>
            </div>
        </div>
    </div>
@endsection
