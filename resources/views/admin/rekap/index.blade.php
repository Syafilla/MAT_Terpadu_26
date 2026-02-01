@extends('layout.adm')
@section('layoutmin')
<br/><br>
<div class="container-xxl">
    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <select name="tentang" class="form-select">
                <option value="">Semua Tentang</option>
                @foreach($listTentang as $t)
                    <option value="{{ $t->tentang }}"
                        {{ request('tentang') == $t->tentang ? 'selected' : '' }}>
                        {{ $t->tentang }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <select name="tahun" class="form-select">
                <option value="">Semua Tahun</option>
                @foreach($listTahun as $t)
                    <option value="{{ $t->tahun }}"
                        {{ request('tahun') == $t->tahun ? 'selected' : '' }}>
                        {{ $t->tahun }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <input type="text"
                name="nama"
                value="{{ request('nama') }}"
                class="form-control"
                placeholder="Cari Atas Nama">
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary w-100">
                <i class="bx bx-filter"></i> Filter
            </button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
            <th>Tentang</th>
            <th>Nama</th>
            <th>Tahun</th>
            <th>Total Arsip</th>
            <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekap as $r)
            <tr>
            <td>{{ $r->tentang }}</td>
            <td class="fw-semibold">{{ $r->nama }}</td>
            <td>{{ $r->tahun }}</td>
            <td>
                <span class="badge bg-primary">{{ $r->total_arsip }}</span>
            </td>
            <td>
                <button
                class="btn btn-sm btn-outline-info"
                onclick="lihatDetail('{{ $r->nama }}')">
                Detail
                </button>
            </td>
            </tr>
            @endforeach
        </tbody>
        </table>
    </div>
    <div class="modal fade" id="modalDetail" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Arsip - Atas Nama</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Tentang</th>
                        <th>Tahun</th>
                        <th>Uraian</th>
                        <th>Tanggal Input</th>
                    </tr>
                    </thead>
                    <tbody id="detailBody"></tbody>
                </table>
                </div>
            </div>
            </div>
        </div>
    </div>
    <script>
        function lihatDetail(nama) {
            fetch(`{{ route('admin.rekap.atasnama.detail') }}?nama=${encodeURIComponent(nama)}`)
                .then(res => res.json())
                .then(data => {
                    let html = '';
                    data.forEach(row => {
                        const tanggal = new Date(row.created_at)
                            .toLocaleDateString('id-ID');
                        html += `
                        <tr>
                            <td>${row.nomor_definitif}</td>
                            <td>${row.tentang}</td>
                            <td>${row.tahun}</td>
                            <td>${row.uraian}</td>
                            <td>${row.created_at}</td>
                        </tr>`;
                    });

                    document.getElementById('detailBody').innerHTML = html;
                    new bootstrap.Modal(document.getElementById('modalDetail')).show();
                });
        }
    </script>

   
</div>

@endsection