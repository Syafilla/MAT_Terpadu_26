@extends('layout.adm')
@section('layoutmin')
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
                            {{ number_format($totalBerkas, 0, ',', '.') }}
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
                          <p class="mb-1">Data Arsip Tahun Ini</p>
                          <h4 class="card-title mb-3">
                            {{ number_format($totalArsipTahunIni, 0, ',', '.') }}
                          </h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-xxl-8 order-2 order-md-3 order-xxl-2 mb-6 total-revenue">
                  <div class="card">
                    <div class="row row-bordered g-0">
                      <div class="col-lg-8">
                        <div class="card-header d-flex align-items-center justify-content-between">
                          <div class="card-title mb-0">
                            <h5 class="m-0 me-2">Rekap Arsip Per Tahun</h5>
                          </div>
                        </div>
                        <div id="totalRevenueChart" class="px-3"></div>
                      </div>
                      <div class="col-lg-4">
                        <div class="card-body px-xl-9 py-12 d-flex align-items-center flex-column">
                          <div class="text-center mb-6">
                            <form method="GET">
                              <div class="btn-group">
                                <button type="button" class="btn btn-outline-primary">
                                  {{ $userId ? optional($users->find($userId))->username : 'Semua Petugas' }}
                                </button>
                                <button
                                  type="button"
                                  class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split"
                                  data-bs-toggle="dropdown"
                                  aria-expanded="false">
                                  <span class="visually-hidden">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu">
                                  <li>
                                    <a class="dropdown-item" href="{{ request()->url() }}">
                                      Semua Petugas
                                    </a>
                                  </li>
                                  @foreach($users as $user)
                                    <li>
                                      <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['user_id' => $user->id]) }}">
                                        {{ $user->username }}
                                      </a>
                                    </li>
                                  @endforeach
                                </ul>
                              </div>
                            </form>
                          </div>
                          <div class="growth-chart-wrapper">
                              <div id="growthChart"></div>
                          </div>
                          <div class="d-flex gap-11 justify-content-between">
                            <div class="d-flex">
                              <div class="avatar me-2">
                                <span class="avatar-initial rounded-2 bg-label-success">
                                  <i class="icon-base bx bx-calendar-check icon-lg text-success"></i>
                                </span>
                              </div>
                              <div class="d-flex flex-column">
                                <small>Hari Ini</small>
                                <h6 class="mb-0">{{ number_format($totalHariIni) }} Data</h6>
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
                                <h6 class="mb-0">{{ number_format($totalKemarin) }} Data</h6>
                              </div>
                            </div>

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 col-md-8 col-lg-12 col-xxl-4 order-3 order-md-2 profile-report">
                  <div class="row">
                    <div class="col-6 mb-6 payments">
                      <div class="card h-100">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                              <img src={{asset('img/icons/unicons/file_one.png')}} alt="paypal" class="rounded" />
                            </div>
                            <div class="dropdown"></div>
                          </div>
                          <p class="mb-1">Total Rekap Per_index</p>
                          <h4 class="card-title mb-3">
                            {{ number_format($totalIndex, 0, ',', '.') }}
                          </h4>
                        </div>
                      </div>
                    </div>
                    <div class="col-6 mb-6 transactions">
                      <div class="card h-100">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                              <img src={{asset('img/icons/unicons/active_user.png')}} alt="Credit Card" class="rounded" />
                            </div>
                            <div class="dropdown"></div>
                          </div>
                          <p class="mb-1">Total User Aktif</p>
                          <h4 class="card-title mb-3">{{ $onlineUsers }}</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-6">
                  <div class="card h-100">

                    <div class="card-header d-flex justify-content-between align-items-center">
                      <div class="card-title mb-0">
                        <h5 class="mb-1 me-2">Hasil Rekap Per Petugas</h5>
                      </div>
                    </div>

                    <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex flex-column align-items-center gap-1">
                          <h3 class="mb-0" id="totalArsip">
                            {{ $totalInputMingguan }}
                          </h3>
                          <small class="text-muted">Total Arsip (Mingguan)</small>
                        </div>
                        <div id="orderStatisticsChart"></div>
                      </div>

                      <ul class="p-0 m-0" id="petugasList">
                        @forelse ($petugasData as $petugas)
                          <li class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center gap-3">
                              <div class="avatar avatar-sm bg-label-primary rounded-circle">
                                {{ strtoupper(substr($petugas->name, 0, 1)) }}
                              </div>
                              <span class="fw-semibold">{{ $petugas->name }}</span>
                            </div>

                            <span class="badge bg-primary rounded-pill">
                              {{ $petugas->total }}
                            </span>
                          </li>
                        @empty
                          <li class="text-center text-muted">
                            Belum ada input arsip minggu ini
                          </li>
                        @endforelse
                      </ul>
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
<script>
const weeklyNow = {{ $weeklyNow }};        
const weeklyLast = {{ $weeklyLast }};      
const petugasData = @json($petugasData);

</script>
<style>
  .growth-chart-wrapper {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  #growthChart {
    margin: 0 auto;
  }

  @media (min-width: 992px) {
    #growthChart {
      max-width: 260px;
    }
  }


</style>  
<script>
document.addEventListener('DOMContentLoaded', function () {

  const chartData = @json($chartData);

  if (chartData.length === 0) return;

  const series = chartData.map(item => item.total);
  const labels = chartData.map(item => item.name);

  const options = {
    chart: {
      type: 'donut',
      height: 240
    },
    labels: labels,
    series: series,
    legend: {
      position: 'bottom'
    },
    dataLabels: {
      formatter: function (val) {
        return val.toFixed(1) + '%';
      }
    },
    tooltip: {
      y: {
        formatter: function (value) {
          return value + ' input';
        }
      }
    },
    colors: [
      '#696cff',
      '#03c3ec',
      '#71dd37',
      '#ffab00',
      '#ff3e1d',
      '#8592a3'
    ]
  };

  new ApexCharts(
    document.querySelector("#orderStatisticsChart"),
    options
  ).render();

});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {

  const tahun = @json($chartTahun);
  const total = @json($chartTotal);

  if (tahun.length === 0) return;

  const options = {
    chart: {
      type: 'bar',
      height: Math.max(300, tahun.length * 40),
      toolbar: { show: false }
    },
    series: [{
      name: 'Total Arsip',
      data: total
    }],
    xaxis: {
      categories: tahun,
      title: { text: 'Tahun Arsip' }
    },
    plotOptions: {
      bar: {
        horizontal: true,
        borderRadius: 6,
        barHeight: '60%'
      }
    },
    dataLabels: {
      enabled: true
    },
    colors: ['#696cff'],
    tooltip: {
      y: {
        formatter: val => val + ' arsip'
      }
    }
  };

  new ApexCharts(
    document.querySelector("#totalRevenueChart"),
    options
  ).render();

});
</script>
@endsection