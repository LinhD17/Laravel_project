<div class="x_content">
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title">#</th>
                    <th class="column-title">Username</th>
                    <th class="column-title">Email</th>
                    <th class="column-title">Fullname</th>
                    <th class="column-title">Avatar</th>
                    <th class="column-title">Trạng thái</th>
                    <th class="column-title">Level</th>
                    <th class="column-title">Tạo mới</th>
                    <th class="column-title">Chỉnh sửa</th>
                    <th class="column-title">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @if (count($items) > 0)
                    <tr class="even pointer">
                        <td class="">1</td>
                        <td width="10%">admin</td>
                        <td>admin@gmail.com</td>
                        <td>admin</td>
                        <td width="5%">
                            <img src="{{ asset('admin/img/anhdaidien.jpeg') }}" alt="admin" class="zvn-thumb">
                        </td>
                        <td><a href="/change-status-active/1"
                            type="button" class="btn btn-round btn-success">Active</a></td>
                        <td width="11%">
                            <select name="select_change_attr" class="form-control"
                                    data-url="/change-level-value_new/1">
                                <option value="admin" selected="selected">Admin</option>
                                <option value="member">Member</option>
                            </select>
                        </td>
                        <td>
                            <p><i class="fa fa-user"></i> admin</p>
                            <p><i class="fa fa-clock-o"></i> 10/12/2014</p>
                        </td>
                        <td>
                            <p><i class="fa fa-user"></i> dieulinh</p>
                            <p><i class="fa fa-clock-o"></i> 10/12/2014</p>
                        </td>
                        <td class="last">
                            <div class="zvn-box-btn-filter"><a
                                    href="/form/1"
                                    type="button" class="btn btn-icon btn-success" data-toggle="tooltip"
                                    data-placement="top" data-original-title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a><a href="/delete/1"
                                type="button" class="btn btn-icon btn-danger btn-delete"
                                data-toggle="tooltip" data-placement="top"
                                data-original-title="Delete">
                                <i class="fa fa-trash"></i>
                            </a>
                            </div>
                        </td>
                    </tr>
                @else
                    {{-- trong trường hợp ko có slider nào, ta tạo sẵn 1 dòng thông báo dữ liệu đang được cập nhật --}}
                    @include('admin.template.list_empty', ['colspan' => 10])
                @endif
            </tbody>
        </table>
    </div>
</div>