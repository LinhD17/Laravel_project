<!DOCTYPE html>
<html lang="en">
<head>
    {{-- kéo/ nhúng nội dung từ element/head sang  --}}
    @include('admin.elements.head')
</head>
     <body class="nav-sm"> 
    {{-- <body class="nav-md"> --}}
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    @include('admin.elements.sidebar_title')
                    @include('admin.elements.sidebar_menu')
                </div>
            </div>
            <!-- top navigation -->
            <div class="top_nav">
                @include('admin.elements.top_navigation')
            </div>
            <!-- page content -->
            <div class="right_col" role="main">
                {{-- yield('content') lấy ra tất cả nội dung có tên là content nằm trong @section('content' ở trong file index.blade.php, nội dung này sẽ thay đổi theo từng route khác nhau (route slider, route dashboard...) --}}
                @yield('content')
            </div>
            <!-- footer -->
            @include('admin.elements.footer')
        </div>
    </div>
    {{-- script - những file .js  --}}
    @include('admin.elements.script')
</body>
</html>