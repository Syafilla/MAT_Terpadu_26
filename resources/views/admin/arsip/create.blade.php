@extends('layout.siarsip')
@section('layoutsi')
    <main>
        <br/><br/>
        <div class="container-xxl px-3 px-md-4 px-lg-5">

            <form method="POST" action="{{ route('arsip.store') }}">
            @csrf
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Tahun Arsip</label>
                            <input type="number" name="tahun" class="form-control" required>
                        </div>

                        <div class="col-md-9">
                            <label class="form-label">Tentang Arsip</label>
                            <input type="text" name="tentang" class="form-control" required>
                        </div>
                        </div>
                    </div>
                </div>

                <table class="table table-bordered table-hover align-middle text-center"
                        id="arsipTable"
                        style="table-layout: fixed; width: 100%;">
                        <colgroup>
                            <col style="width: 45px;">
                            <col style="width: 120px;">
                            <col style="width: 90px;">
                            <col style="width: 420px;">
                            <col style="width: 90px;">
                            <col style="width: 130px;">
                            <col style="width: 70px;">
                            <col style="width: 70px;">
                            <col style="width: 95px;">
                            <col style="width: 80px;">
                            <col style="width: 70px;">
                            <col style="width: 70px;">
                        </colgroup>
                        <thead class="table-info">
                            <tr>
                            <th>No</th>
                            <th>Kode Klasifikasi</th>
                            <th>Indeks</th>
                            <th>Uraian</th>
                            <th>Kurun Waktu</th>
                            <th>Tingkat Perkembangan</th>
                            <th>Jumlah</th>
                            <th>Ket</th>
                            <th>No Definitif</th>
                            <th>No Boks</th>
                            <th>Rak</th>
                            <th>Baris</th>
                            </tr>
                        </thead>
                        <tbody id="arsipBody">
                            <tr>
                                <td>1</td>
                                <td><input name="details[0][kode_klasifikasi]" class="form-control"></td>
                                <td><input name="details[0][indeks]" class="form-control"></td>
                                <td><input name="details[0][uraian]" class="form-control"></td>
                                <td><input name="details[0][kurun_waktu]" class="form-control"></td>
                                <td><input name="details[0][tingkat_perkembangan]" class="form-control"></td>
                                <td><input name="details[0][jumlah]" type="number" class="form-control"></td>
                                <td><input name="details[0][keterangan]" class="form-control"></td>
                                <td class="text-muted">Auto</td>
                                <td><input name="details[0][nomor_boks]" class="form-control"></td>
                                <td><input name="details[0][rak]" class="form-control"></td>
                                <td><input name="details[0][baris]" class="form-control"></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
                 
                    <a href="{{ route('arsip.index') }}" class="btn btn-outline-secondary">
                        ← Kembali ke Data Arsip
                    </a>

                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-secondary" onclick="addRow()">
                            + Tambah Baris
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Simpan Arsip
                        </button>
                    </div>
                </div>
                </div>
            </form>
        
    </main>
    <style>
        #arsipTable td {
            white-space: nowrap;
        }

        #arsipTable th {
            white-space: normal;
            line-height: 1.2;
        }

    </style>
    <style>
        .card {
            border-radius: 12px;
        }

        .table th {
            background-color: #e9f2ff;
            font-weight: 600;
        }

        @media (max-width: 576px) {
            h4 {
                font-size: 1.2rem;
            }
        }
    </style>
    <script>
        function addRow() {
            const tbody = document
                .getElementById('arsipTable')
                .getElementsByTagName('tbody')[0];

            const tr = document.createElement('tr');

            tr.innerHTML = `
                <td>${row + 1}</td>
                <td><input name="details[${row}][kode_klasifikasi]" class="form-control"></td>
                <td><input name="details[${row}][indeks]" class="form-control"></td>
                <td><input name="details[${row}][uraian]" class="form-control"></td>
                <td><input name="details[${row}][kurun_waktu]" class="form-control"></td>
                <td><input name="details[${row}][tingkat_perkembangan]" class="form-control"></td>
                <td><input name="details[${row}][jumlah]" type="number" class="form-control"></td>
                <td><input name="details[${row}][keterangan]" class="form-control"></td>
                <td class="text-muted">Auto</td>
                <td><input name="details[${row}][nomor_boks]" class="form-control"></td>
                <td><input name="details[${row}][rak]" class="form-control"></td>
                <td><input name="details[${row}][baris]" class="form-control"></td>
            `;

            tbody.appendChild(tr);
            row++;
        }
    </script>
    <style>
        #arsipTable th,
        #arsipTable td {
            padding: 4px;
            vertical-align: middle;
        }

        #arsipTable input {
            width: 100%;
            font-size: 12px;
            padding: 2px 4px;
        }

        #arsipTable td:nth-child(4) input {
            white-space: normal;
            line-height: 1.2;
            min-height: 38px;
        }

    </style>
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
@endsection
