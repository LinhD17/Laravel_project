{{-- slider sẽ chứa giao diện là danh sách --}}
{{-- kế thừa nội dung từ admin/main.blade.php --}}
@extends('admin.main')
@php 
    use App\Helpers\Template as Template;
    $xhtmlButtonFilter = Template::showButtonFilter($controllerName, $itemsStatusCount, $params['filter']['status'], $params['search']);
    $xhtmlAreaSearch  = Template::showAreaSearch($controllerName, $params['search']);
@endphp

{{-- section ta tạo ở đây có tên là content, nó sẽ lấy hết toàn bộ nội dung bên trong quăng vào trong vùng có tên là content ta viết bên file main: @yield('content')  --}}
@section('content')
    @include('admin.template.page_header', ['pageIndex' => true])

    {{-- hiển thị thông báo (alert) đã hoàn thành cập nhật...  --}}
    @include('admin.template.zvn_notify')

    <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
                @include('admin.template.x_title', ['title' => 'Bộ lọc'])
                <div class="x_content">
                <div class="row">
                        <div class="col-md-7">
                            {!! $xhtmlButtonFilter !!}
                        </div>
                        <div class="col-md-5">
                        {!! $xhtmlAreaSearch !!}
                        </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!--box-lists-->
    <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
                @include('admin.template.x_title', ['title' => 'Danh sách'])
                @include('admin.pages.slider.list')
        </div>
    </div>
    </div>
    <!--box-pagination-->
    @if (count($items) > 0)
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                        @include('admin.template.x_title', ['title' => 'Phân trang'])
                        @include('admin.template.pagination')
                </div>
            </div>
        </div>
    @endif
@endsection