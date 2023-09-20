{{-- thay thế cho cách viét <?php echo ... ?>  trên ta cũng có cách viết thay thế để in ra 1 giá trị nào đó mà ngắn gọn hơn --}}
{{-- {{ asset("admin/asset/bootstrap/dist/css/bootstrap.min.css") }} --}}

{{-- kế thừa nội dung từ admin/main.blade.php --}}
@extends('admin.main')
{{-- section ta tạo ở đây có tên là content, nó sẽ lấy hết toàn bộ nội dung bên trong quăng vào trong vùng có tên là content ta viết bên file main: @yield('content')  --}}
@section('content')
<div class="page-header zvn-page-header clearfix">
   <div class="zvn-page-header-title">
       <h3>Dashboard</h3>
   </div>
</div>
<div class="row">
   <div class="col-md-12 col-sm-12 col-xs-12">
       <div class="x_panel">
           <div class="x_title">
               <h2>Dashboard</h2>
               <ul class="nav navbar-right panel_toolbox">
                   <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                   </li>
               </ul>
               <div class="clearfix"></div>
           </div>
           <div class="x_content">
               <h4>
                  Dashboard
               </h4>
           </div>
       </div>
   </div>
</div>
@endsection