@extends('pengguna')
@section('layout')
<main>
          <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                <div class="col-xxl-8 mb-6 order-0">
                  <div class="card">
                    <div class="d-flex align-items-start row">
                      <div class="col-sm-7">
                        <div class="card-body">
                          @auth
                            <h5 class="card-title text-primary mb-3">
                                Selamat Datang {{ auth()->user()->username }}! 🎉
                            </h5>
                            @endauth
                          <p class="mb-6">
                            Selamat Datang Di MAT BKPSDM.<br />Cek Data Arsip Terbaru Anda Di Data Arsip.
                          </p>
                        </div>
                      </div>
                      <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-6">
                          <img
                            src={{asset('img/illustrations/ilustrasi_admin.png')}}
                            height="175"
                            alt="View Badge User" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xxl-4 col-lg-12 col-md-4 order-1">
                  <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-6">
                      <div class="card h-100">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                              <img
                                src={{asset('img/icons/unicons/chart-success.png')}}
                                alt="chart success"
                                class="rounded" />
                            </div>
                            <div class="dropdown"></div>
                          </div>
                          <p class="mb-1">Total Berkas Arsip</p>
                          <h4 class="card-title mb-3">
                            {{ number_format($totalArsipUser, 0, ',', '.') }}
                          </h4>
                            
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-6">
                      <div class="card h-100">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                              <img
                              src="{{ asset('img/icons/unicons/file_date.png') }}"
                              alt="arsip tahun ini"
                              class="rounded" />
                            </div>
                            <div class="dropdown"></div>
                          </div>
                          <p class="mb-1">Data Arsip Minggu Ini</p>
                          <h4 class="card-title mb-3">
                            {{ number_format($weeklyArsipUser, 0, ',', '.') }}
                          </h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-xxl-8 order-2 order-md-3 order-xxl-2 mb-6 total-revenue">
                  <div class="card">
                    <div class="row row-bordered g-0">
                      <div class="col-lg-4">
                        <div class="card-body px-xl-9 py-12 d-flex align-items-center flex-column">
                          <div class="text-center mb-6">
                          </div>
                          <div id="growthChart"></div>
                          <div class="d-flex gap-11 justify-content-between">
                            <div class="d-flex">
                              <div class="avatar me-2">
                                <span class="avatar-initial rounded-2 bg-label-success">
                                  <i class="icon-base bx bx-calendar-check icon-lg text-success"></i>
                                </span>
                              </div>
                              <div class="d-flex flex-column">
                                <small>Hari Ini</small>
                                <h6 class="mb-0">{{ number_format($hariIni) }} Data</h6>
                              </div>
                            </div>
                            <div class="d-flex">
                              <div class="avatar me-2">
                                <span class="avatar-initial rounded-2 bg-label-warning">
                                  <i class="icon-base bx bx-calendar-minus icon-lg text-warning"></i>
                                </span>
                              </div>
                              <div class="d-flex flex-column">
                                <small>Kemarin</small>
                                <h6 class="mb-0">{{ number_format($kemarin) }} Data</h6>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
</main>
<script>
  const persentase = {{ round($persentase, 1) }};
</script> 
@endsection