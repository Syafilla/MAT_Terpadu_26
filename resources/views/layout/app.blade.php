<!doctype html>

<html
  lang="en"
  class="layout-wide customizer-hide"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Register MAT | BKPSDM</title>

    <meta name="description" content="" />

    <link rel="icon" type="image/png" sizes="16x16"  href={{asset('img/favicon/favicon-16x16.png')}}>
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href={{asset('vendor/fonts/iconify-icons.css')}} >


    <link rel="stylesheet" href= {{asset('vendor/css/core.css')}}>
    <link rel="stylesheet" href={{asset('css/demo.css')}}>



    <link rel="stylesheet" href={{asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}>

    <link rel="stylesheet" href={{asset('vendor/css/pages/page-auth.css')}}>

    <script src={{asset('vendor/js/helpers.js')}}></script>

    <script src={{asset('js/config.js')}}></script>
  </head>

  <body>
    <main class="pb-5 flex-grow-1">
        @yield('layout.regis')
    </main>
    <script>
        function cekData() {
            fetch('/aktivasi/cek', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    login: document.getElementById('login').value
                })
            })
            .then(res => res.json())
            .then(data => {
                const msg = document.getElementById('message');

                if (data.status === 'not_found') {
                    msg.innerText = 'Data tidak terdaftar. Hubungi administrator.';
                }

                if (data.status === 'already_active') {
                    msg.innerText = 'Akun sudah aktif. Silakan login.';
                }

                if (data.status === 'found') {
                    document.getElementById('step1').style.display = 'none';
                    document.getElementById('step2').style.display = 'block';

                    document.getElementById('nip').value = data.nip;
                    document.getElementById('username').value = data.username;
                    document.getElementById('user_id').value = data.id;
                }
            });
        }
    </script>
    <script src={{asset('vendor/libs/jquery/jquery.js')}}></script>

    <script src={{asset('vendor/libs/popper/popper.js')}}></script>
    <script src={{asset('vendor/js/bootstrap.js')}}></script>

    <script src={{asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}></script>

    <script src={{asset("vendor/js/menu.js")}}></script>

    <script src={{asset('js/main.js')}}></script>

    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <style>
    body {
        background-image: url('{{ asset('img/bg-login.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        min-height: 100vh;
    }

    body::before {
        content: "";
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        z-index: -1;
    }

    main {
        position: relative;
        z-index: 1;
    }
</style>
  </body>
</html>


