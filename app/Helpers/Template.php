<?php
namespace App\Helpers; 
use Config;

class Template {
    //function xử lý nếu status > 0 thì hiển thị lên nút All, Active, Inactive
    public static function showButtonFilter ($controllerName, $itemsStatusCount, $currentFilterStatus, $paramsSearch) { //$currentFilterStatus - active / inactive / all 
        $xhtml = null;
        $tmplStatus = Config::get('zvn.template.status');

        // echo '<pre style="color:red">';
        // print_r($paramsSearch);
        // echo '</pre>';

        if(count($itemsStatusCount) > 0) {
            //thêm phần tử all vào vị trí đầu mảng 
            array_unshift($itemsStatusCount, [
                'count'=> array_sum(array_column($itemsStatusCount, 'count')),
                'status' => 'all'
            ]);
            //duyệt qua $itemsStatusCount này, mỗi lần duyệt qua ta đặt tên cho nó là item
            foreach ($itemsStatusCount as $item) { //item = [count, status]
                $statusValue = $item['status']; //active, inactive, block - trạng thái của item 
                //kiểm tra xem giá trị này có trong khai báo của zvn.php hay không, nếu có thì cứ in ra bình thường, nếu ko có thì cho in ra 1 giá trị default nào đó 
                $statusValue = array_key_exists($statusValue, $tmplStatus) ? $statusValue : 'default'; 

                $curentTemplateStatus = $tmplStatus[$statusValue]; //sau khi kiểm tra đi cập nhật lại cho $curentTemplateStatus
                $link = route($controllerName) . "?filter_status=" . $statusValue; //link của filter

                //nếu người dùng đang tìm kiếm gì đó, thì gán lại link của filter để giá trị ta đang search ko bị nhảy đi/ reload khi ta bấm vào 1 trong các nút trạng thái
                if($paramsSearch['value'] !== ''){
                    $link .= "&search_field=" . $paramsSearch['field'] . "&search_value=" . $paramsSearch['value'];
                }

                $class = ($currentFilterStatus == $statusValue) ? 'btn-danger' : 'btn-info'; 
                $xhtml .= sprintf('
                <a
                    href="%s" type="button"
                    class="btn %s"
                >
                    %s
                    <span class="badge bg-white">%s</span>
                </a>
                ', $link, $class, $curentTemplateStatus['name'],$item['count']);

            }
        }
        return $xhtml;
    }

    //function xử lý và hiển thị phần search 
    public static function showAreaSearch ($controllerName, $paramsSearch) {
        $xhtml = null;
        $tmplField = Config::get('zvn.template.search');
        $fieldInController = Config::get('zvn.config.search');

        $controllerName = (array_key_exists($controllerName, $fieldInController)) ? $controllerName : 'default';
        $xhtmlField = null; 
        
        foreach($fieldInController[$controllerName] as $field) {
            $xhtmlField .= sprintf('<li><a href="#" class="select-field" data-field="%s">%s</a></li>', $field, $tmplField[$field]['name']);
        }

        // echo'<pre style="color:red">'; 
        // print_r($paramsSearch);
        // echo'</pre>';

        $searchField = (in_array($paramsSearch['field'], $fieldInController[$controllerName])) ? $paramsSearch['field'] : "all";
        //$searchField = $paramsSearch['field']; // all id description ...


        $xhtml = sprintf('
            <div class="input-group">
                    <div class="input-group-btn">
                        <button type="button"
                            class="btn btn-default dropdown-toggle btn-active-field"
                            data-toggle="dropdown" aria-expanded="false"
                        >
                            %s <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                            %s
                        </ul>
                    </div>
                    <input type="text"  name="search_value" value="%s" class="form-control">
                    <input type="hidden" name="search_field" value="%s">
                    <span class="input-group-btn">
                        <button id="btn-clear-search" type="button" class="btn btn-success" style="margin-right: 0px">Xóa tìm kiếm</button>
                        <button id="btn-search" type="button" class="btn btn-primary">Tìm kiếm</button>
                    </span>
                </div>
        ', $tmplField[$searchField]['name'], $xhtmlField, $paramsSearch['value'], $searchField);

        return $xhtml;
    }

    //function để hiển thị tên người và thời gian tạo - cập nhật
    public static function showItemHistory ($by, $time) {
        $xhtml = sprintf('
            <p><i class="fa fa-user"></i> %s</p>
            <p><i class="fa fa-clock-o"></i> %s</p>
            ', $by, date(Config::get('zvn.format.short_time'), strtotime($time))  ); //%s đầu tiên sẽ ứng với $by, %s thứ 2 sẽ tương ứng với $time
        return $xhtml;
    }

    //function để điều chỉnh giao diện hiển thị theo trạng thái 
    public static function showItemStatus ($controllerName, $id, $statusValue) {
        // định nghĩa 1 template dành cho status, để sau này khu muốn sửa name hay class ta không cần sửa nhiều nơi nữa, ta sẽ định nghĩa nó trong file config/zvn.php
        $tmplStatus = Config::get('zvn.template.status');
        
        $statusValue = array_key_exists($statusValue, $tmplStatus) ? $statusValue : 'default';

        $curentTemplateStatus = $tmplStatus[$statusValue]; //sau khi kiểm tra đi cập nhật lại cho $curentTemplateStatus
        $link = route($controllerName . '/status', ['status' => $statusValue, 'id' => $id]); // $controllerName này đã được truyền ra từ SliderController nên ta ko cần lo lắng gì nữa

        $xhtml = sprintf('
            <a href="%s"
                type="button" 
                class="btn btn-round %s"
            >
                %s
            </a>
            ', $link, $curentTemplateStatus['class'], $curentTemplateStatus['name']); 
        return $xhtml;
    }

    //function hiển thị ảnh
    public static function showItemThumb ($controllerName, $thumbName, $thumbAlt) {
        $xhtml = sprintf('
            <img src="%s" alt="%s" class="zvn-thumb">
        ', asset('images/'. $controllerName. '/'. $thumbName ) , $thumbAlt);
        return $xhtml; 
    }

    //fuction chung cho 2 nút edit và delete 
    public static function showButtonAction ($controllerName, $id) {
        //định nghĩa template dàng cho nút 
        $tmpButton = Config::get('zvn.template.button');

        //định nghĩa buttonInArea 
        $buttonInArea = Config::get('zvn.config.button');

        $controllerName = (array_key_exists($controllerName, $buttonInArea)) ? $controllerName : 'default'; 
        $listButtons = $buttonInArea[$controllerName];

        $xhtml = '<div class="zvn-box-btn-filter">';  
        foreach ($listButtons as $btn) {
            $currentButton = $tmpButton[$btn];
            $link = route($controllerName . $currentButton['route-name'], ['id' => $id]);
            $xhtml .= sprintf('
                <a
                    href="%s"
                    type="button"
                    class="btn btn-icon %s" 
                    data-toggle="tooltip"
                    data-placement="top" 
                    data-original-title="%s"
                >
                    <i class="fa %s"></i>
                </a>
            ', $link, $currentButton['class'], $currentButton['title'], $currentButton['icon'] );
        }
        $xhtml .=  '</div>';
        return $xhtml;
    }
}
// template này hỗ trợ những vấn đề về sinh ra những HTML
// 2 nút edit và delete khác nhau ở: class, title, icon, route-name 
