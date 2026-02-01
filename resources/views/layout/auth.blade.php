<!doctype html>

<html
  lang="en"
  class="layout-wide customizer-hide"
  data-asset-path="/"
  data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Login MAT | Bkpsdm</title>

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


    <link rel="stylesheet" href={{asset('vendor/css/core.css')}} >
    <link rel="stylesheet" href={{asset('css/demo.css')}} >


    <link rel="stylesheet" href={{asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}} >

    <link rel="stylesheet" href={{asset('vendor/css/pages/page-auth.css')}}>

    <script src={{asset('vendor/js/helpers.js')}}></script>
   
    <script src={{ asset('js/config.js')}}></script>
  </head>

  <body>
    <main class="pb-5 flex-grow-1">
        @yield('layout.auth')
    </main>
    <style>
      .rotating-text {
          min-height: 20px;
          line-height: 1.2;
          font-size: 0.95rem;
          margin-bottom: 4px;
          transition: opacity 0.8s ease;
      }

    </style>
    <script>
    document.addEventListener("DOMContentLoaded", function () {

        const texts = [
            "Sistem Arsip Digital Terintegrasi BKPSDM",
            "Manajemen Arsip Terpadu",
            "Cepat, aman, dan terstruktur",
            "Solusi digital pengelolaan arsip",
            "Mendukung pengarsipan modern"
        ];

        const el = document.querySelector(".rotating-text");
        if (!el) return;

        let index = 0;

        function rotateText() {
            el.style.opacity = 0;

            setTimeout(() => {
                el.textContent = texts[index];
                el.style.opacity = 1;
                index = (index + 1) % texts.length;
            }, 400);
        }

        rotateText();
        setInterval(rotateText, 3000);
    });
    </script>

    <script src={{asset('vendor/libs/jquery/jquery.js')}}></script>

    <script src={{asset('vendor/libs/popper/popper.js')}}></script>
    <script src={{asset('vendor/js/bootstrap.js')}}></script>

    <script src={{asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}></script>

    <script src={{asset('vendor/js/menu.js')}}></script>

    <script src={{asset('js/main.js')}}></script>

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
    .authentication-inner .card {
        background: rgb(255, 255, 255);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        border: 1px solid rgb(255, 255, 255);
        border-radius: 14px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.58);
    }

    
  </style>
</body>
</html>

    