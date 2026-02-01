@extends('layout.use')
@section('layoutuser')
    <main>
        <form method="POST" action="/admin/users/{{ $user->id }}">
        @csrf
        @method('PUT')
        <input class="form-control mb-2" name="username" value="{{ $user->username }}" required>
        <input class="form-control mb-2" name="nip" value="{{ $user->nip }}">

        <input class="form-control mb-2" type="password" name="password"
            placeholder="Password baru (kosongkan jika tidak diubah)">

        <select class="form-control mb-3" name="role">
            <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Administrator</option>
            <option value="user" {{ $user->role=='user'?'selected':'' }}>User</option>
        </select>
        <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
            <a href="{{ route('admin.user') }}" class="btn btn-outline-secondary">
                ← Kembali ke Data User
            </a>
            <div class="d-flex gap-2">
                <button class="btn btn-primary">
                    Simpan User Data
                </button>
            </div>
        </div>
        </form>
    </main>
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
