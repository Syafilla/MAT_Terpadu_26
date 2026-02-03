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

    <title>MAT | BKPSDM</title>

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
  </head>

  <body class="bg-light d-flex flex-column min-vh-100">
    
    @include('bar.navbarguna')
    <br/><br/>
    <main class="flex-fill pb-4">
        @yield('layout')
    </main>
            <footer class="content-footer footer bg-footer-theme">
                  <div class="container-xxl py-3 text-center">
                    © {{ date('Y') }} MAT | BKPSDM
                  </div>
                </footer>
            <div class="content-backdrop fade"></div>   
          </div>
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

  <script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnLogout = document.getElementById('btn-logout');

        if (btnLogout) {
            btnLogout.addEventListener('click', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Yakin ingin logout?',
                    text: 'Sesi Anda akan diakhiri.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Logout',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('logout-form').submit();
                    }
                });
            });
        }
    });
  </script>
    <script>
document.querySelectorAll('.togglePwd').forEach(btn => {
    btn.addEventListener('click', function () {
        const input = this.previousElementSibling;
        const icon  = this.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bx-show', 'bx-hide');
        } else {
            input.type = 'password';
            icon.classList.replace('bx-hide', 'bx-show');
        }
    });
});
</script>
<script>
const passwordInput = document.getElementById('new_password');
const bar  = document.getElementById('strengthBar');
const text = document.getElementById('strengthText');

passwordInput.addEventListener('input', function () {
    const val = this.value;
    let score = 0;

    if (val.length >= 6) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    bar.className = 'progress-bar';

    if (score <= 1) {
        bar.style.width = '25%';
        bar.classList.add('bg-danger');
        text.innerText = 'Lemah';
    } else if (score === 2) {
        bar.style.width = '50%';
        bar.classList.add('bg-warning');
        text.innerText = 'Sedang';
    } else if (score === 3) {
        bar.style.width = '75%';
        bar.classList.add('bg-info');
        text.innerText = 'Kuat';
    } else {
        bar.style.width = '100%';
        bar.classList.add('bg-success');
        text.innerText = 'Sangat Kuat';
    }
});
</script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '{{ session('success') }}',
    timer: 2000,
    showConfirmButton: false
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal',
    text: '{{ session('error') }}'
});
</script>
@endif

@if($errors->any())
<script>
Swal.fire({
    icon: 'error',
    title: 'Validasi Gagal',
    html: `{!! implode('<br>', $errors->all()) !!}`
});
</script>
@endif
  </body>
</html>
