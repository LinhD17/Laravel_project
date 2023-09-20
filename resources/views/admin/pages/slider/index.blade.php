{{-- slider sẽ chứa giao diện là danh sách --}}
{{-- kế thừa nội dung từ admin/main.blade.php --}}
@extends('admin.main')
@php 
    use App\Helpers\Template as Template;
    $xhtmlButtonFilter = Template::showButtonFilter($itemsStatusCount);
@endphp

{{-- section ta tạo ở đây có tên là content, nó sẽ lấy hết toàn bộ nội dung bên trong quăng vào trong vùng có tên là content ta viết bên file main: @yield('content')  --}}
@section('content')
<div class="page-header zvn-page-header clearfix">
   <div class="zvn-page-header-title">
       <h3>Danh sách User</h3>
   </div>
   <div class="zvn-add-new pull-right">
        <a href="/form" class="btn btn-success">
            <i class="fa fa-plus-circle"></i> Thêm mới
        </a>
   </div>
</div>
<div class="row">
   <div class="col-md-12 col-sm-12 col-xs-12">
       <div class="x_panel">
            @include('admin.template.x_title', ['title' => 'Bộ lọc'])
            <div class="x_content">
               <div class="row">
                    <div class="col-md-6">
                        {!! $xhtmlButtonFilter !!}
                    </div>
                    <div class="col-md-6">
                       <div class="input-group">
                           <div class="input-group-btn">
                               <button type="button"
                                       class="btn btn-default dropdown-toggle btn-active-field"
                                       data-toggle="dropdown" aria-expanded="false">
                                   Search by All <span class="caret"></span>
                               </button>
                               <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                   <li><a href="#"
                                          class="select-field" data-field="all">Search by All</a></li>
                                   <li><a href="#"
                                          class="select-field" data-field="id">Search by ID</a></li>
                                   <li><a href="#"
                                          class="select-field" data-field="username">Search by Username</a>
                                   </li>
                                   <li><a href="#"
                                          class="select-field" data-field="fullname">Search by Fullname</a>
                                   </li>
                                   <li><a href="#"
                                          class="select-field" data-field="email">Search by Email</a></li>
                               </ul>
                           </div>
                           <input type="text" class="form-control" name="search_value" value="">
                           <span class="input-group-btn">
                       <button id="btn-clear" type="button" class="btn btn-success"
                               style="margin-right: 0px">Xóa tìm kiếm</button>
                       <button id="btn-search" type="button" class="btn btn-primary">Tìm kiếm</button>
                       </span>
                           <input type="hidden" name="search_field" value="all">
                       </div>
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