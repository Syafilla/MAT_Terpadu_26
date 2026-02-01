@extends('pengguna')

@section('layout')
<main>
          <br/><br/>
          <div class="container-xxl">
            <div class="d-flex justify-content-between align-items-center gap-2 mb-4">
                <h4 class="mb-0">Data Arsip</h4>

                <div class="d-flex gap-2">
                    <button class="btn btn-success"
                        data-bs-toggle="modal"
                        data-bs-target="#importModal">
                        Import Excel
                    </button>

                    <a href="{{ route('arsip.create') }}" class="btn btn-primary">
                        + Tambah Data Arsip
                    </a>
                </div>
            </div>

            <form method="GET" class="row g-2 mb-4">
                <div class="col-md-3">
                <input type="number" name="tahun" class="form-control"
                        placeholder="Filter Tahun"
                        value="{{ request('tahun') }}">
                </div>

                <div class="col-md-5">
                <input type="text" name="tentang" class="form-control"
                        placeholder="Tentang Arsip"
                        value="{{ request('tentang') }}">
                </div>

                <div class="col-md-2">
                <button class="btn btn-secondary w-100">Filter</button>
                </div>

                <div class="col-md-2">
                <a href="{{ route('user.arsip.index') }}" class="btn btn-light w-100">
                    Reset
                </a>
                </div>
            </form>
            @if(request('q'))
                <div class="alert alert-info d-flex align-items-center gap-2 mb-3">
                    <i class="bx bx-search-alt"></i>
                    <div>
                    Menampilkan hasil pencarian untuk:
                    <strong>"{{ request('q') }}"</strong>
                    <span class="text-muted">
                        ({{ $arsips->total() }} data ditemukan)
                    </span>
                    </div>
                </div>
            @endif

            <div class="card">
                <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0 table table-bordered table-striped table-hover">
                    <thead class="table-secondary text-center align-middle">
                    <tr>
                        <th>No</th>
                        <th>Tahun</th>
                        <th>Tentang Arsip</th>
                        <th>Jumlah</th>
                        <th>Petugas</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>

                    <tbody id="arsipRows">
                    @forelse ($arsips as $index => $arsip)
                        <tr>
                            <td>{{ $arsips->firstItem() + $index }}</td>
                            <td>{{ $arsip->tahun }}</td>
                            <td>{{ $arsip->tentang }}</td>
                            <td>{{ $arsip->total_detail }}</td>
                            <td>{{ $arsip->username ?? '-' }}</td>
                            <td>
                            <a href="{{ route('user.arsip.group.form', [$arsip->tahun, $arsip->tentang]) }}"
                                class="btn btn-sm btn-info">
                                    Lihat / Tambah
                            </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                        <td colspan="7" class="text-center">
                            Tidak ada data arsip
                        </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                </div>
            </div>
            <div class="mt-4">
                {{ $arsips->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="importModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('arsip.import') }}"
            method="POST"
            enctype="multipart/form-data"
            class="modal-content">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title">Import Arsip dari Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">

                    <div class="col-12">
                        <label class="form-label">Tentang</label>
                        <input type="text"
                            name="tentang"
                            class="form-control"
                            placeholder="Contoh: BIDANG MUTASI DAN PROMOSI"
                            required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Tahun</label>
                        <input type="number"
                            name="tahun"
                            class="form-control"
                            placeholder="Contoh: 2023"
                            required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">File Excel</label>
                        <input type="file"
                            name="file"
                            class="form-control"
                            accept=".xlsx,.xls"
                            required>

                        <small class="text-muted">
                            Data dibaca mulai baris 9.
                            Kolom: kode klasifikasi, indeks, uraian, kurun waktu,
                            tingkat perkembangan, jumlah, keterangan, nomor boks, rak, baris.
                        </small>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">
                    Import Arsip
                </button>
            </div>
        </form>

    </div>
</div>
</main>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function () {
            const form = this.closest('form');

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Seluruh data arsip akan dihapus permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
<script>
function hapusBaris(btn) {
    btn.closest('tr').remove();
}
</script>

@endsection