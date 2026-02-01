    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="#" class="app-brand-link">
              <span class="app-brand-logo demo">
                <span class="text-primary">
                    <div class="app-brand d-flex align-items-center justify-content-start">
                        <a href="index.html" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">
                                <img
                                    src="{{ asset('img/logo_MAT.png') }}"
                                    alt="Logo MAT"
                                    style="height: 50px; width: auto;"
                                >
                            </span>
                        </a>
                    </div>
                </span>
            </a>
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
              <i class="bx bx-chevron-left d-block d-xl-none align-middle"></i>
            </a>
          </div>

          <div class="menu-divider mt-0"></div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            
            <li class="menu-item">
              <a href="{{ route('user.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-smile"></i>
                <div class="text-truncate" data-i18n="Basic">Dashboards</div>
              </a>
            </li>

            <li class="menu-item">
              <a href="{{ route('user.arsip.index') }}" class="menu-link">
                <i class="menu-icon bx bx-archive"></i>
                <div>Data Arsip</div>
              </a>
            </li>
          </ul>
        </aside>

        <div class="layout-page">
          <nav
            class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
            id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                <i class="icon-base bx bx-menu icon-md"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
              <div class="navbar-nav align-items-center me-auto">
                <div class="nav-item d-flex align-items-center">
                  <form action="{{ route('arsip.index') }}" method="GET" class="nav-item d-flex align-items-center">
                    <span class="w-px-22 h-px-22">
                      <i class="icon-base bx bx-search icon-md"></i>
                    </span>
                    <input
                      type="text"
                      name="q"
                      value="{{ request('q') }}"
                      class="form-control border-0 shadow-none ps-1 ps-sm-2 d-md-block d-none"
                      placeholder="Cari arsip, nama, nomor, tahun..."
                      aria-label="Search" />
                  </form>
                </div>
              </div>
              <ul class="navbar-nav">
                <div class="nav-item me-4 d-flex align-items-center">
                  <span
                    id="navbar-datetime"
                    class="fw-semibold text-dark navbar-datetime">
                    -- -- ---- --:--:--
                  </span>
                </div>
              </ul>
              <ul class="navbar-nav">
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a
                    class="nav-link dropdown-toggle hide-arrow p-0"
                    href="javascript:void(0);"
                    data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="/img/avatars/magang.png" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="/img/avatars/magang.png" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                            @auth
                            <div class="flex-grow-1">
                                <h6 class="mb-0">{{ auth()->user()->username }}</h6>
                                <small class="text-body-secondary">
                                    {{ ucfirst(auth()->user()->role) }}
                                </small>
                            </div>
                            @endauth
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider my-1"></div>
                    </li>

                    <li>
                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                            <i class="bx bx-lock-alt me-2"></i>
                            Ubah Password
                        </button>
                    </li>

                    <li>
                      <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item" type="submit">
                          <i class="icon-base bx bx-power-off icon-md me-3"></i> 
                          <span>Log Out</span>
                        </button>
                      </form>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
          <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                  <form method="POST" action="{{ route('password.change') }}" class="modal-content">
                      @csrf

                      <div class="modal-header">
                          <h5 class="modal-title">Ubah Password</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>

                      <div class="modal-body">

                          <div class="mb-3">
                              <label>Password Lama</label>
                              <div class="input-group">
                                  <input type="password" name="current_password" class="form-control pwd" required>
                                  <button class="btn btn-outline-secondary togglePwd" type="button">
                                      <i class="bx bx-show"></i>
                                  </button>
                              </div>
                          </div>

                          <div class="mb-3">
                              <label>Password Baru</label>
                              <div class="input-group">
                                  <input type="password" name="new_password" id="new_password" class="form-control pwd" required>
                                  <button class="btn btn-outline-secondary togglePwd" type="button">
                                      <i class="bx bx-show"></i>
                                  </button>
                              </div>

                              <div class="progress mt-2" style="height:6px">
                                  <div id="strengthBar" class="progress-bar"></div>
                              </div>
                              <small id="strengthText"></small>
                          </div>

                          <div class="mb-3">
                              <label>Konfirmasi Password Baru</label>
                              <div class="input-group">
                                  <input type="password" name="new_password_confirmation" class="form-control pwd" required>
                                  <button class="btn btn-outline-secondary togglePwd" type="button">
                                      <i class="bx bx-show"></i>
                                  </button>
                              </div>
                          </div>

                      </div>

                      <div class="modal-footer">
                          <button type="submit" class="btn btn-primary w-100">
                              Simpan Perubahan
                          </button>
                      </div>
                  </form>
              </div>
          </div>
