<!doctype html>
<html lang="en">
<head>
    @include('layouts.lte.head')
    <title>@yield('title', 'RSHP')</title>
</head>

<body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">

<div class="app-wrapper">

    {{-- ================= NAVBAR ================= --}}
    @include('layouts.lte.navbar')

    {{-- ================= SIDEBAR (SATU FILE) ================= --}}
    @include('layouts.lte.sidebar')

    {{-- ================= MAIN CONTENT ================= --}}
    <main class="app-main">
        @yield('content')
    </main>

    {{-- ================= FOOTER ================= --}}
    @include('layouts.lte.footer')

</div>

{{-- ================= SCRIPT (WAJIB URUTAN INI) ================= --}}

<!-- Bootstrap 5 Bundle (WAJIB untuk dropdown, modal, collapse) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>

<!-- AdminLTE -->
<script src="{{ asset('assets/js/adminlte.js') }}"></script>

{{-- OPTIONAL: OverlayScrollbars (kalau kamu pakai) --}}
<script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
        crossorigin="anonymous"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const sidebarWrapper = document.querySelector('.sidebar-wrapper');
    if (sidebarWrapper && window.OverlayScrollbarsGlobal) {
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

</body>
</html>
