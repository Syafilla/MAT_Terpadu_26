@extends('layout.app')
@section('layout.regis')
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
              <h4 class="mb-1">Aktivasi Akun 🚀</h4>
              <p class="mb-6">Jadikan Pengelolan Arsip Anda Mudah dan Efisien</p>
               
                <div id="step1">
                    <input type="text" id="login" class="form-control mb-3"
                        placeholder="Masukkan NIP atau Username">

                    <button class="btn btn-primary w-100" onclick="cekData()">
                        Cek Data
                    </button>

                    <div id="message" class="text-danger mt-3"></div>
                </div>
                
                
                <form id="step2" method="POST" action="/aktivasi/proses" style="display:none">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id">

                    <label>NIP</label>
                    <input class="form-control mb-2" id="nip" readonly>

                    <label>Username</label>
                    <input class="form-control mb-3" id="username" readonly>

                    <input name="email" class="form-control mb-2" placeholder="Email" required>
                    <input name="password" type="password" class="form-control mb-3"
                        placeholder="Password" required>

                    <button class="btn btn-success w-100">
                        Aktifkan Akun
                    </button>
                </form>

            </div>
              <p class="text-center">
                <span>Sudah Punya Akun?</span>
                <a href="{{ route('login') }}">
                  <span>Log in</span>
                </a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
</main>    
@endsection