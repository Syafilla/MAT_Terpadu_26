@extends('layout.use')
@section('layoutuser')
<main>
    <form method="POST" action="/admin/users">
    @csrf
        <div class="mb-3">
            <label class="form-label">NIP (Opsional)</label>
            <input 
                type="text"
                name="nip"
                class="form-control"
                value="{{ old('nip') }}"
                placeholder="Kosongkan jika tidak ada"
            >
        </div>
        <input class="form-control mb-2" name="username" value="{{ old('username') }}" placeholder="Username" required>

        <select name="role" class="form-control mb-3" required>
            <option value="">Pilih Role</option>
            <option value="user">User</option>
            <option value="admin">Administrator</option>
        </select>
        <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
            <a href="{{ route('admin.user') }}" class="btn btn-outline-secondary">
                ← Kembali ke Data User
            </a>
            <div class="d-flex gap-2">
                <button class="btn btn-primary">
                    Simpan Data User
                </button>
            </div>
        </div>
    </form>
</main>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if($errors->any())
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal',
    text: 'Periksa kembali data yang Anda input',
});
</script>
@endif

    
@endsection

