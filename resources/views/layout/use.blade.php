<!doctype html>

<html
  lang="en"
  class="layout-menu-fixed layout-compact"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Data User - MAT | BKPSDM</title>

    <meta name="description" content="" />
    <link rel="icon" type="image/png" sizes="16x16"  href={{asset('img/favicon/favicon-16x16.png')}}>
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href={{asset('vendor/fonts/iconify-icons.css')}}>

    <link rel="stylesheet" href={{asset('vendor/css/core.css')}}>
    <link rel="stylesheet" href={{asset('css/demo.css')}}>

    <link rel="stylesheet" href={{asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}>

    <link rel="stylesheet" href= {{asset('vendor/libs/apex-charts/apex-charts.css')}}>

    <script src={{asset('vendor/js/helpers.js')}}></script>
    <script src={{asset('js/config.js')}}></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </head>

  <body class="bg-light d-flex flex-column min-vh-100">
    <div class="flex-grow-1">
        @include('bar.navbar')

        <div class="container-xxl px-3 px-md-4 px-lg-5 pt-4">
            @yield('layoutuser')
        </div>
        <footer class="content-footer footer bg-footer-theme mt-auto">
          <div class="container-xxl py-3 text-center">
            © {{ date('Y') }} MAT | BKPSDM
          </div>
        </footer>
      <div class="content-backdrop fade"></div>
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <script src={{asset('vendor/libs/jquery/jquery.js')}}></script>

    <script src={{asset('vendor/libs/popper/popper.js')}}></script>
    <script src={{asset('vendor/js/bootstrap.js')}}></script>

    <script src={{asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}></script>

    <script src={{asset('vendor/js/menu.js')}}></script>

    <script src={{asset('vendor/libs/apex-charts/apexcharts.js')}}></script>

    <script src={{asset('js/main.js')}}></script>

    <script src={{asset('js/dashboards-analytics.js')}}></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  @stack('scripts')
  <style>
  body,
    .bg-light,
    .layout-page,
    .content-wrapper,
    .container-xxl,
    .card {
        background-color: #f8f8f869 !important;
    }
  </style>
  @if(session('success'))
  <script>
  Swal.fire({
      icon: 'success',
      title: 'Berhasil',
      text: '{{ session('success') }}',
      timer: 2500,
      showConfirmButton: false
  });
  </script>
  @endif

  @if(session('error'))
  <script>
  Swal.fire({
      icon: 'error',
      title: 'Gagal',
      html: `<small>{{ session('error') }}</small>`,
      timer: 10000,
      showConfirmButton: false
  });
  </script>
  @endif

  @if($errors->any())
  <script>
  Swal.fire({
      icon: 'error',
      title: 'Validasi Gagal',
      html: `
          <ul style="text-align:left">
              @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      `,
      timer: 10000,
      showConfirmButton: false
  });
  </script>
  @endif
  <script>
    function updateNavbarDateTime() {
      const now = new Date();
      const pad = n => n.toString().padStart(2, '0');

      const formatted =
        pad(now.getDate()) + '-' +
        pad(now.getMonth() + 1) + '-' +
        now.getFullYear() + ' ' +
        pad(now.getHours()) + ':' +
        pad(now.getMinutes()) + ':' +
        pad(now.getSeconds());

      const el = document.getElementById('navbar-datetime');
      if (el) el.textContent = formatted;
    }

    updateNavbarDateTime();
    setInterval(updateNavbarDateTime, 1000);
  </script>
  <style>
  .navbar-datetime {
    font-size: 14px;
    line-height: 1.3;
    letter-spacing: 0.3px;
    white-space: nowrap;
  }
  </style>
  </body>
</html>
