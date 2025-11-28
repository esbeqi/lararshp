<!doctype html>
<html lang="en">
<!-- begin::Head -->
@include('layouts.lte.head')
<!-- end::Head -->

<!-- begin::Body -->
<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">

<div class="app-wrapper">

    <!-- begin::Navbar -->
    @include('layouts.lte.navbar')
    <!-- end::Navbar -->

    <!-- begin::Sidebar -->
    @php
    $role = DB::table('role_user')
        ->join('role', 'role_user.idrole', '=', 'role.idrole')
        ->where('role_user.iduser', auth()->id())
        ->value('role.nama_role');
    @endphp

    @if($role === 'Admin')
        @include('layouts.lte.sidebar')
    @endif

    @if($role === 'Dokter')
        @include('layouts.lte.sidebar-dokter')
    @endif

    @if($role === 'Resepsionis')
        @include('layouts.lte.sidebar-resepsionis')
    @endif

    @if($role === 'Perawat')
        @include('layouts.lte.sidebar-perawat')
    @endif

    @if($role === 'Pemilik')
        @include('layouts.lte.sidebar-pemilik')
    @endif

    <!-- end::Sidebar -->

    <!-- begin::App Main -->
    <main class="app-main">
        @yield('content')
    </main>
    <!-- end::App Main -->

    <!-- begin::Footer -->
    @include('layouts.lte.footer')
    <!-- end::Footer -->

</div>
<!--end::App Wrapper-->

<!--begin::Script-->
<!-- OverlayScrollbars -->
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>

<!-- Popper.js for Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>

<!-- Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>

<!-- AdminLTE -->
<script src="{{ asset('assets/js/adminlte.js') }}"></script>

<!-- OverlayScrollbars Configure -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const sidebarWrapper = document.querySelector('.sidebar-wrapper');
    if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined) {
        OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
                theme: 'os-theme-light',
                autoHide: 'leave',
                clickScroll: true,
            },
        });
    }
});
</script>

<!-- SortableJS -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js" crossorigin="anonymous"></script>
<script>
new Sortable(document.querySelector('.connectedSortable'), {
    group: 'shared',
    handle: '.card-header',
});
document.querySelectorAll('.connectedSortable .card-header').forEach(el => el.style.cursor = 'move');
</script>

<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js" crossorigin="anonymous"></script>

<script>
const sales_chart_options = {
    series: [
        { name: 'Digital Goods', data: [28, 48, 40, 19, 86, 27, 90] },
        { name: 'Electronics', data: [65, 59, 80, 81, 56, 55, 40] }
    ],
    chart: { height: 300, type: 'area', toolbar: { show: false } },
    legend: { show: false },
    colors: ['#0d6efd', '#20c997'],
    dataLabels: { enabled: false },
    stroke: { curve: 'smooth' },
    xaxis: {
        type: 'datetime',
        categories: ['2023-01-01','2023-02-01','2023-03-01','2023-04-01','2023-05-01','2023-06-01','2023-07-01']
    },
    tooltip: { x: { format: 'MMMM yyyy' } }
};
new ApexCharts(document.querySelector('#revenue-chart'), sales_chart_options).render();
</script>

<!-- jsVectorMap -->
<script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js" crossorigin="anonymous"></script>
<script>
new jsVectorMap({ selector: '#world-map', map: 'world' });
</script>

<!-- Sparklines -->
<script>
const sparklineOptions = (selector, data) => ({
    series: [{ data }],
    chart: { type: 'area', height: 50, sparkline: { enabled: true } },
    stroke: { curve: 'straight' },
    fill: { opacity: 0.3 },
    yaxis: { min: 0 },
    colors: ['#DCE6EC']
});

new ApexCharts(document.querySelector('#sparkline-1'), sparklineOptions('#sparkline-1', [1000,1200,920,927,931,1027,819,930,1021])).render();
new ApexCharts(document.querySelector('#sparkline-2'), sparklineOptions('#sparkline-2', [515,519,520,522,652,810,370,627,319,630,921])).render();
new ApexCharts(document.querySelector('#sparkline-3'), sparklineOptions('#sparkline-3', [15,19,20,22,33,27,31,27,19,30,21])).render();
</script>
<!--end::Script-->

</body>
</html>