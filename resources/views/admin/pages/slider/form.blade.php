@extends('admin.main')
@php 
    use App\Helpers\Form as FormTemplate;
    $formLabelClass = config('zvn.template.form_label.class'); 
    $formInputClass = config('zvn.template.form_input.class'); 

    $statusValue = ['default' => 'Select status', 'active' => config('zvn.template.status.active.name'), 'inactive' => config('zvn.template.status.inactive.name')];

    $elements = [
        [
            'label' => Form::label('name', 'Name', ['class' => $formLabelClass]),
            'element' =>  Form::text('name', $item['name'], ['class' => $formInputClass]) // $item['name'] chính là tên của phần tử hiện tại mà ta muốn edit 
        ],  
        [
            'label' => Form::label('description', 'Description', ['class' =>  $formLabelClass]), 
            'element' => Form::text('description', $item['description'], ['class' => $formInputClass])
        ], 
        [
            'label' => Form::label('status', 'Status', ['class' =>  $formLabelClass]), 
            'element' => Form::select('status', $statusValue, $item['status'], ['class' => $formInputClass])
        ], 
        [
            'label' => Form::label('link', 'Link', ['class' =>  $formLabelClass]), 
            'element' => Form::text('link', $item['link'], ['class' => $formInputClass])
        ], 
        // cấu trúc của button không có phần label
        [
            'element' => Form::submit('save', ['class' =>  'btn btn-success']), 
            'type' => "btn-submit"
        ]
    ];
@endphp

{{-- section ta tạo ở đây có tên là content, nó sẽ lấy hết toàn bộ nội dung bên trong quăng vào trong vùng có tên là content ta viết bên file main: @yield('content')  --}}
@section('content')
    @include('admin.template.page_header', ['pageIndex' => false])

    <!--box-lists-->
    <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
                @include('admin.template.x_title', ['title' => 'Form'])
                <div class="x-content">
                    {{ Form::open([
                        'method' => 'POST', 
                        'url' => route("$controllerName/save"), 
                        'accept-charset' => 'UTF-8',
                        'enctype' => 'multipart/form-data',
                        'class' => 'form-horizontal form-label-left',
                        'id' => 'main-form'
                        ]) }}
                        {!! FormTemplate::show($elements)!!}

                    {{ Form::close() }}
                </div>

                {{-- <form method="POST" action="http://proj_news.xyz/admin123/slider/save" accept-charset="UTF-8" enctype="multipart/form-data" class="form-horizontal form-label-left" id="main-form">
                    <input name="_token" type="hidden" value="m4wsEvprE9UQhk4WAexK6Xhg2nGQwWUOPsQAZOQ5">
                    <div class="form-group">
                    <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-6 col-xs-12" name="name" type="text" value="Ưu đãi học phí" id="name">
                    </div>
                    </div>
                    <div class="form-group">
                    <label for="description" class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-6 col-xs-12" name="description" type="text" value="Tổng hợp các trương trình ưu đãi học phí hàng tuần..." id="description">
                    </div>
                    </div>
                    <div class="form-group">
                    <label for="status" class="control-label col-md-3 col-sm-3 col-xs-12">Status</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control col-md-6 col-xs-12" id="status" name="status">
                            <option value="default">Select status</option>
                            <option value="active" selected="selected">Kích hoạt</option>
                            <option value="inactive">Chưa kích hoạt</option>
                        </select>
                    </div>
                    </div>
                    <div class="form-group">
                    <label for="link" class="control-label col-md-3 col-sm-3 col-xs-12">Link</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-6 col-xs-12" name="link" type="text" value="https://zendvn.com/uu-dai-hoc-phi-tai-zendvn/" id="link">
                    </div>
                    </div>
                    <div class="form-group">
                    <label for="thumb" class="control-label col-md-3 col-sm-3 col-xs-12">Thumb</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control col-md-6 col-xs-12" name="thumb" type="file" id="thumb">
                        <p style="margin-top: 50px;"><img src="http://proj_news.xyz/images/slider/LWi6hINpXz.jpeg" alt="Ưu đãi học phí" class="zvn-thumb"></p>
                    </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <input name="id" type="hidden" value="3">
                        <input name="thumb_current" type="hidden" value="LWi6hINpXz.jpeg">
                        <input class="btn btn-success" type="submit" value="Save">
                    </div>
                    </div>
                </form> --}}
        </div>
    </div>
    </div>
@endsection