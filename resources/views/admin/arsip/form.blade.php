@extends('layout.siarsip')

@section('layoutsi')
<div class="container-xxl mt-4">

    <input type="number" name="tahun"
    class="form-control"
    value="{{ $header->tahun }}"
    readonly>

<input type="text" name="tentang"
    class="form-control"
    value="{{ $header->tentang }}"
    readonly>
<div class="table-responsive mt-4">
            <form action="{{ route('arsip.group.store', [
                    'tahun' => $header->tahun,
                    'tentang' => $header->tentang
                ]) }}"
                method="POST">
                @csrf

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
                        <tbody>
                            @forelse ($details as $i => $d)
                            <tr>
                                <td>
                                    <input type="hidden"
                                        name="details[{{ $i }}][id]"
                                        value="{{ $d->id }}">
                                    {{ $i + 1 }}
                                </td>
                                <td><input name="details[{{ $i }}][kode_klasifikasi]" value="{{ $d->kode_klasifikasi }}" class="form-control"></td>
                                <td><input name="details[{{ $i }}][indeks]" value="{{ $d->indeks }}" class="form-control"></td>
                                <td><input name="details[{{ $i }}][uraian]" value="{{ $d->uraian }}" class="form-control"></td>
                                <td><input name="details[{{ $i }}][kurun_waktu]" value="{{ $d->kurun_waktu }}" class="form-control"></td>
                                <td><input name="details[{{ $i }}][tingkat_perkembangan]" value="{{ $d->tingkat_perkembangan }}" class="form-control"></td>
                                <td><input name="details[{{ $i }}][jumlah]" value="{{ $d->jumlah }}" type="number" class="form-control"></td>
                                <td><input name="details[{{ $i }}][keterangan]" value="{{ $d->keterangan }}" class="form-control"></td>
                                <td class="text-muted">{{ $d->nomor_definitif }}</td>
                                <td><input name="details[{{ $i }}][nomor_boks]" value="{{ $d->nomor_boks }}" class="form-control"></td>
                                <td><input name="details[{{ $i }}][rak]" value="{{ $d->rak }}" class="form-control"></td>
                                <td><input name="details[{{ $i }}][baris]" value="{{ $d->baris }}" class="form-control"></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="12" class="text-center text-muted">
                                    Belum ada data arsip
                                </td>
                            </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>
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
            </form>
        </div>
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
        let row = {{ $details->count() }};

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
