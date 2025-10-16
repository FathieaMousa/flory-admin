@extends('layouts.master')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
<div class="row g-4">

    <!-- 🛍️ Products -->
    <div class="col-md-3 col-sm-6">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <div class="fs-2 fw-bold text-primary">{{ $stats['products'] }}</div>
                <div class="text-muted">Products</div>
            </div>
        </div>
    </div>

    <!-- 📦 Orders -->
    <div class="col-md-3 col-sm-6">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <div class="fs-2 fw-bold text-success">{{ $stats['orders'] }}</div>
                <div class="text-muted">Orders</div>
            </div>
        </div>
    </div>

    <!-- 👥 Customers -->
    <div class="col-md-3 col-sm-6">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <div class="fs-2 fw-bold text-info">{{ $stats['customers'] }}</div>
                <div class="text-muted">Customers</div>
            </div>
        </div>
    </div>

    <!-- 💸 Sales -->
    <div class="col-md-3 col-sm-6">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <div class="fs-2 fw-bold text-warning">
                    ${{ number_format($stats['sales'], 2) }}
                </div>
                <div class="text-muted">Total Sales</div>
            </div>
        </div>
    </div>
</div>

<hr class="my-4">

<!-- 🔔 Notifications -->
<div class="card mb-4 shadow-sm">
    <div class="card-header bg-light">
        <h5 class="mb-0">Latest Notifications</h5>
    </div>
    <div class="card-body">
        <p>Total Notifications: <strong>{{ $stats['notifications'] }}</strong></p>
        <a href="{{ route('notifications.index') }}" class="btn btn-outline-primary btn-sm">
            View All Notifications
        </a>
    </div>
</div>

<hr class="my-4">

<div class="row">
    <!-- 📊 المبيعات الشهرية -->
    <div class="col-lg-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Monthly Sales Overview</h5>
                <div class="d-flex gap-2 align-items-center">
                    <select id="salesFilter" class="form-select w-auto">
                        <option value="month" selected>This Month</option>
                        <option value="3months">Last 3 Months</option>
                        <option value="6months">Last 6 Months</option>
                        <option value="year">This Year</option>
                    </select>
                    <button id="exportPDF" class="btn btn-sm btn-danger">📄 Export PDF</button>
                    <button id="exportExcel" class="btn btn-sm btn-success">📊 Export Excel</button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- 🏆 أعلى المنتجات مبيعًا -->
    <div class="col-lg-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">Top Selling Products</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @forelse($topProducts as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $item->product->title ?? 'Deleted Product' }}</span>
                            <span class="badge bg-primary rounded-pill">{{ $item->total_qty }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted text-center">No sales data yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- 🧾 آخر الطلبات -->
<div class="card shadow-sm">
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Recent Orders</h5>
        <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-secondary">View All</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($latestOrders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->customer->name ?? 'Unknown' }}</td>
                        <td>
                            <span class="badge bg-{{
                                $order->status === 'Delivered' ? 'success' :
                                ($order->status === 'Pending' ? 'warning' : 'info')
                            }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td>${{ number_format($order->total, 2) }}</td>
                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">No recent orders found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<!-- Chart.js + jsPDF + SheetJS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>

<script>
    const baseUrl = "{{ route('dashboard') }}";
    let salesChart;

    // رسم المخطط
    function renderChart(labels, data) {
        const ctx = document.getElementById('salesChart').getContext('2d');
        if (salesChart) salesChart.destroy();
        salesChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Sales ($)',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    borderRadius: 5
                }]
            },
            options: {
                scales: { y: { beginAtZero: true } },
                plugins: { legend: { display: false } }
            }
        });
    }

    // البيانات الأولية
    @php
        $labels = array_map(function($m) {
            return date('M', mktime(0, 0, 0, $m, 1));
        }, array_keys($monthlySales));
    @endphp
    const initialLabels = @json($labels);
    const initialData = @json(array_values($monthlySales));
    renderChart(initialLabels, initialData);

    // التبديل بين الفترات الزمنية
    document.getElementById('salesFilter').addEventListener('change', function() {
        fetch(`${baseUrl}?filter=${this.value}`)
            .then(res => res.json())
            .then(data => renderChart(data.labels, data.sales));
    });

    // تصدير PDF
    document.getElementById('exportPDF').addEventListener('click', () => {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF();
        pdf.text("Monthly Sales Report", 14, 15);
        pdf.addImage(salesChart.toBase64Image(), 'PNG', 10, 25, 180, 90);
        pdf.save("sales-report.pdf");
    });

    // تصدير Excel
    document.getElementById('exportExcel').addEventListener('click', () => {
        const ws = XLSX.utils.json_to_sheet(initialLabels.map((label, i) => ({
            Month: label,
            Sales: initialData[i]
        })));
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Sales");
        XLSX.writeFile(wb, "sales-report.xlsx");
    });
</script>
@endpush
