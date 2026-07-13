@extends('backEnd.layout.master')
@section('title', 'Advanced Performance Reports')

@section('body')
    <div class="">

        <!-- 📅 টপ হেডার এবং ফিল্টার সেকশন -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">📊 Performance & Traffic Reports</h4>
            <form action="{{ route('admin.logs.reports') }}" method="GET" id="filterForm">
                <select name="filter" class="form-select" onchange="document.getElementById('filterForm').submit()">
                    <option value="today" {{ $filter == 'today' ? 'selected' : '' }}>Today</option>
                    <option value="yesterday" {{ $filter == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                    <option value="last_7_days" {{ $filter == 'last_7_days' ? 'selected' : '' }}>Last 7 Days</option>
                    <option value="last_30_days" {{ $filter == 'last_30_days' ? 'selected' : '' }}>Last 30 Days</option>
                    <option value="lifetime" {{ $filter == 'lifetime' ? 'selected' : '' }}>Lifetime</option>
                </select>
            </form>
        </div>

        <div class="row mb-4">
            <div class="col-6 col-md-3 col-lg-2">
                <div class="card bg-primary text-white p-3">
                    <span>Real Traffic</span>
                    <h3>{{ number_format($totalRealClicks) }}</h3>
                </div>
            </div>
            <div class="col-6 col-md-3 col-lg-2">
                <div class="card bg-warning text-dark p-3">
                    <span>Bot/Fake Traffic</span>
                    <h3>{{ number_format($totalFakeClicks) }}</h3>
                </div>
            </div>
            <div class="col-6 col-md-3 col-lg-2">
                <div class="card bg-success text-white p-3">
                    <span>Unique Visitors</span>
                    <h3>{{ number_format($uniqueVisitors) }}</h3>
                </div>
            </div>
            <div class="col-6 col-md-3 col-lg-2">
                <div class="card bg-info-subtle shadow-lg text-dark p-3">
                    <span>Organic Visitors</span>
                    <h3>{{ $totalOrganicClicks }}</h3>
                </div>
            </div>
            <div class="col-6 col-md-3 col-lg-2">
                <div class="card bg-danger text-white p-3">
                    <span>Real Bounce Rate</span>
                    <h3>{{ $bounceRateEstimate }}%</h3>
                </div>
            </div>

        </div>

        <!-- 📉 নতুন ফিচার: Hourly Traffic Trend (Line Chart) -->
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header text-dark bg-white py-3 fw-bold border-bottom">⏰ Hourly Traffic Trend (24-Hour Distribution)</div>
            <div class="card-body">
                <div style="height: 300px; width: 100%;">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- 🔥 Top 5 Pages -->
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header text-dark bg-white py-3 fw-bold">🔥 Top 10 Visited Pages</div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0 align-middle">
                            <tbody>
                            @foreach($topPages as $page)
                                <tr>
                                    <td class="ps-3"><code class="text-primary">{{ Str::limit($page->url, 45) }}</code></td>
                                    <td class="text-end pe-3"><span class="badge bg-light text-dark">{{ $page->total }} hits</span></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 🌐 Top Traffic Sources (Referrers) -->
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header text-dark bg-white py-3 fw-bold">📣 Top Referral Channels</div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0 align-middle">
                            <tbody>
                            @foreach($topReferrers as $ref)
                                <tr>
                                    <td class="ps-3">🌐 <span class="fw-semibold">{{ $ref->referrer }}</span></td>
                                    <td class="text-end pe-3"><span class="badge bg-soft-success bg-secondary text-dark">{{ $ref->total }} sessions</span></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- 📱 Device Breakdown -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header text-dark bg-white py-3 fw-bold">📱 Platform Distribution</div>
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <div style="width: 350px; height: 350px;">
                            <canvas id="deviceChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 🌍 Browser Breakdown -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header text-dark bg-white py-3 fw-bold">🌐 Preferred Browsers</div>
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <div style="width: 350px; height: 350px;">
                            <canvas id="browserChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0" style="overflow-y: scroll; max-height: 500px">
                    <div class="card-header bg-white py-3 fw-bold">🌍 Top Visitor Countries</div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0 align-middle">
                            <tbody>
                            @foreach($countryData as $cData)
                                <tr>
                                    <td class="ps-3">📍 <span class="fw-semibold">{{ $cData->country }}</span></td>
                                    <td class="text-end pe-3"><span class="badge bg-info text-white">{{ $cData->total }} clicks</span></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- চার্ট সেকশন (JS অংশ) -->
        <script>
            // Real vs Fake Chart
            new Chart(document.getElementById('trafficTypeChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Real', 'Bots'],
                    datasets: [{
                        data: [{{ $totalRealClicks }}, {{ $totalFakeClicks }}],
                        backgroundColor: ['#0d6efd', '#ffc107']
                    }]
                }
            });
        </script>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {

            // ১. ⏰ Hourly Trend (Line Chart Script)
            let hourlyData = {!! json_encode($hourlyTicks) !!};
            const ctxTrend = document.getElementById('trendChart').getContext('2d');
            new Chart(ctxTrend, {
                type: 'line',
                data: {
                    labels: Array.from({length: 24}, (_, i) => `${i}:00`),
                    datasets: [{
                        label: 'Hourly Page Views',
                        data: hourlyData,
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, 0.08)',
                        fill: true,
                        tension: 0.3,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true } }
                }
            });

            // ২. 📱 Device Chart
            let deviceLabels = {!! json_encode($deviceData->pluck('device')) !!};
            let deviceCounts = {!! json_encode($deviceData->pluck('total')) !!};
            const ctxDevice = document.getElementById('deviceChart').getContext('2d');
            new Chart(ctxDevice, {
                type: 'doughnut',
                data: {
                    labels: deviceLabels.map(l => l ? l.toUpperCase() : 'UNKNOWN'),
                    datasets: [{
                        data: deviceCounts,
                        backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e']
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
            });

            // ৩. 🌐 Browser Chart
            let browserLabels = {!! json_encode($browserData->pluck('browser')) !!};
            let browserCounts = {!! json_encode($browserData->pluck('total')) !!};
            const ctxBrowser = document.getElementById('browserChart').getContext('2d');
            new Chart(ctxBrowser, {
                type: 'pie',
                data: {
                    labels: browserLabels,
                    datasets: [{
                        data: browserCounts,
                        backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe', '#ffce56', '#4bc0c0']
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
            });

        });
    </script>
@endpush
