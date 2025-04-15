{{-- <div class="d-flex align-items-center justify-content-center">
    <!-- Nút Sửa -->
    <a href="{{ route($editRoute, $row->maAdmin) }}" class="btn btn-warning btn-sm me-2">
        <i class="fas fa-edit"></i> Sửa
    </a>

    <!-- Nút Xóa -->
    <form action="{{ route($deleteRoute, $row->maAdmin) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm">
            <i class="fas fa-trash"></i> Xóa
        </button>
    </form>
</div>
 --}}

 <div class="d-flex align-items-center justify-content-center">
    <!-- Nút Sửa -->
    @if (!empty($editRoute))
    <a href="{{ route($editRoute, $id) }}" class="btn btn-warning btn-sm me-2">
        <i class="fas fa-edit"></i> Sửa
    </a>
    @endif

    <!-- Nút Xóa -->
    <form id="deleteForm{{ $id }}" action="{{ route($deleteRoute, $id) }}" method="POST" >
        @csrf @method('DELETE')
        <button data-form="deleteForm{{ $id }}" class="btn btn-danger btn-sm btn-delete">
            <i class="fas fa-trash"></i> Xóa
        </button>
    </form>
</div>

