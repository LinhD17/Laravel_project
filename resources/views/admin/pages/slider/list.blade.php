@php 
   use App\Helpers\Template as Template;
@endphp



<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title">Stt</th>
                    <th class="column-title">Slider Info</th>
                    {{-- <th class="column-title">Avatar</th> --}}
                    <th class="column-title">Trạng thái</th>
                    <th class="column-title">Tạo mới</th>
                    <th class="column-title">Chỉnh sửa</th>
                    <th class="column-title">Hành động</th>
                </tr>
            </thead>
            <tbody>
                {{-- nếu có item thì in ra tất cả các item, nếu ko có item thì hiện ra thông báo dưới --}}
                @if (count($items) > 0)
                    @foreach ($items as $key => $val)
                        @php
                            $index = $key + 1;
                            $class = ($index %2 == 0) ? "even" : "odd"; 
                            $id = $val['id'];
                            $name = $val['name'];
                            $description = $val['description'];
                            $link = $val['link'];
                            $thumb = Template::showItemThumb($controllerName, $val['thumb'], $val['name']);
                            $status = Template::showItemStatus($controllerName, $id, $val['status']);
                            $createdHistory = Template::showItemHistory($val['created_by'], $val['created']);
                            $modifiedHistory = Template::showItemHistory($val['modified_by'], $val['modified']);
                            $listBtnAction = Template::showButtonAction($controllerName, $id);
                        @endphp
                        <tr class="{{ $class }} pointer">
                            <td class="">{{ $index }}</td>
                            <td width="40%">
                                <p><strong>Name: </strong> {{ $name }}</p>
                                <p><strong>Description: </strong> {{ $description }}</p>
                                <p><strong>Link: </strong> {{ $link }}</p>
                                <p>{!! $thumb !!}</p>
                            </td>
                            <td>
                                {!! $status !!}
                            </td>
                            <td>
                                {!! $createdHistory !!}
                            </td>
                            <td>
                                {!! $modifiedHistory !!}
                            </td>
                            <td class="last">
                                {!! $listBtnAction !!}
                            </td>
                        </tr>
                    @endforeach

                @else
                    {{-- trong trường hợp ko có slider nào, ta tạo sẵn 1 dòng thông báo dữ liệu đang được cập nhật --}}
                    @include('admin.template.list_empty', ['colspan'=> 6])
                @endif
            </tbody>
        </table>
    </div>
</div>