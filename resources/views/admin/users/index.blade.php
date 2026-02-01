@extends('layout.use')
@section('layoutuser')
    <main>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>
                Manajemen
            </h3>

            <form method="GET" action="{{ route('admin.user') }}">
                <select name="role"
                        class="form-select"
                        onchange="this.form.submit()">
                    <option value="user" {{ $role === 'user' ? 'selected' : '' }}>
                        User
                    </option>
                    <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>
                </select>
            </form>
        </div>
        <a href="/admin/users/create" class="btn btn-primary mb-3">
            Tambah User
        </a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>NIP</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $u)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $u->username }}</td>
                    <td>{{ $u->nip ?? '-' }}</td>
                    <td>{{ ucfirst($u->role) }}</td>
                    <td>
                        <a href="/admin/users/{{ $u->id }}/edit" class="btn btn-warning btn-sm">Edit</a>
                        
                        <form action="{{ route('admin.users.destroy', $u->id) }}"
                            method="POST"
                            class="d-inline delete-user-form">
                            @csrf
                            @method('DELETE')

                            <button type="button" class="btn btn-sm btn-danger btn-delete-user">
                                <i class="bx bx-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-delete-user').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Data user akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endsection