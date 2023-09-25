@php
    $totalItems = $items->total();
    //echo '<h3>'. $totalItems .'</h3>';

    $totalPages = $items->lastPage();   
    //echo '<h3>'. $totalPages .'</h3>';

    $totalItemsPerPage = $items->perPage();
    //echo '<h3>'. $totalItemsPerPage .'</h3>';
@endphp

<div class="x_content">
    <div class="row">
        <div class="col-md-6">
            <p class="m-b-0">
                <span class="label label-info label-pagination">{{ $items->perPage() }} items per page</span>
                <span class="label label-success label-pagination">{{ $items->total() }} items</span>
                <span class="label label-danger label-pagination">{{ $items->lastPage() }} pages</span>
            </p>
        </div>
        <div class="col-md-6">
            {{-- nếu ko viết gì trong link('') nó sẽ ra 1 giao diện mặc định laravel thiết kế --}}
            {{-- {{ $items -> links('') }} --}}

            {{-- custom lại thiết kế của phần phân trang  --}}
            {{ $items -> links('admin.pagination.pagination_backend', ['paginatior' => $items]) }}

            {{-- lấy URL hiện tại appends vào link phân trang để nếu như có bấm vapf trang tiếp theo để xem thì các giá trị đang tìm kiếm cũng bị reload/ xoá đi mất --}}
            {{-- {!! $items->appends(request()->input())->links('pagination.pagination_backend') !!}  --}}
        </div>
    </div>
</div>