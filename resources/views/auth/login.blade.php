@extends('layout.auth')
@section('layout.auth')
<main>
    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <div class="card px-sm-6 px-0">
            <div class="card-body">
              <div class="app-brand justify-content-center flex-column text-center">
                  <a href="index.html" class="app-brand-link gap-2">
                      <span class="app-brand-logo demo">
                          <img
                              src="{{ asset('img/logo_MAT.png') }}"
                              alt="Logo MAT"
                              style="height: 100px; width: auto;"
                          >
                      </span>
                  </a>
                  <p class="text-muted mt-2 rotating-text"></p>
              </div>

              <h4 class="mt-2 mb-1">Selamat Datang Di Mat! 👋</h4>
              <p class="mb-3">Silahkan login terlebih dahulu untuk memulai pengarsipan</p>
              @if ($errors->any())
                <div class="alert alert-danger">
                  {{ $errors->first() }}
                </div>
              @endif
              <form method="POST" action="/login">
                @csrf
                <div class="mb-6">
                  <label class="form-label">NIP or Username</label>
                  <input
                    type="text"
                    class="form-control"
                    id="login"
                    name="login"
                    placeholder="Enter your nip or username"
                    autofocus />
                </div>
                <div class="mb-6 form-password-toggle">
                  <label class="form-label" for="password">Password</label>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password" />
                    <span class="input-group-text cursor-pointer"><i class="icon-base bx bx-hide"></i></span>
                  </div>
                </div>
                <div class="mb-8">
                  <div class="d-flex justify-content-between">
                    <div class="form-check mb-0">
                      <input class="form-check-input" type="checkbox" id="remember-me" />
                      <label class="form-check-label" for="remember-me"> Remember Me </label>
                    </div>
                  </div>
                </div>
                <div class="mb-6">
                  <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
                </div>
              </form>

              <p class="text-center">
                <span>Baru Pertama Di Web site?</span>
                <a href="{{ route('aktivasi') }}">
                  <span>Regiter</span>
                </a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
</main>    
@endsection