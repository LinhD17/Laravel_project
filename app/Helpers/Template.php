<?php
namespace App\Helpers; 
use Config;

class Template {
    //function xử lý nếu status > 0 thì hiển thị lên nút All, Active, Inactive
    public static function showButtonFilter ($countByStatus) {
        $xhtml = null;

        if(count($countByStatus) > 0) {

            //thêm phần tử all vào vị trí đầu mảng 
            array_unshift($countByStatus, [
                'count'=> array_sum(array_column($countByStatus, 'count')),
                'status' => 'All'
            ]);

            foreach ($countByStatus as $value) {
                $xhtml .= sprintf('
                <a
                    href="#" type="button"
                    class="btn btn-primary"
                >
                    %s
                    <span class="badge bg-white">%s</span>
                </a>
                ', $value['status'],$value['count']);

            }

        }

        // $xhtml = sprintf('
        //     <a
        //         href="?filter_status=all" type="button"
        //         class="btn btn-primary"
        //     >
        //         All 
        //         <span class="badge bg-white">4</span>
        //     </a>
        //     <a 
        //         href="?filter_status=active"
        //         type="button" class="btn btn-success"
        //     >
        //         Active 
        //         <span class="badge bg-white">2</span>
        //     </a>
        //     <a 
        //         href="?filter_status=inactive"
        //         type="button" class="btn btn-success"
        //     >
        //         Inactive
        //         <span class="badge bg-white">2</span>
        //     </a>
        // ');
        return $xhtml;
    }

    //function để hiển thị tên người và thời gian tạo- cập nhật
    public static function showItemHistory ($by, $time) {
        $xhtml = sprintf('
            <p><i class="fa fa-user"></i> %s</p>
            <p><i class="fa fa-clock-o"></i> %s</p>
            ', $by, date(Config::get('zvn.format.short_time'), strtotime($time))  ); //%s đầu tiên sẽ ứng với $by, %s thứ 2 sẽ tương ứng với $time
        return $xhtml;
    }

    //function để điều chỉnh giao diện hiển thị theo trạng thái 
    public static function showItemStatus ($controllerName, $id, $status) {
        // định nghĩa 1 template dành cho status 
        $tmplStatus = [
            'active' => ['name' => 'Kích hoạt', 'class' => 'btn-success'],
            'inactive' => ['name' => 'Chưa kích hoạt', 'class' => 'btn-info']
        ];

        $curentStatus = $tmplStatus[$status];
        $link = route($controllerName . '/status', ['status' => $status, 'id' => $id]); // $controllerName này đã được truyền ra từ SliderController nên ta ko cần lo lắng gì nữa

        $xhtml = sprintf('
            <a href="%s"
                type="button" 
                class="btn btn-round %s"
            >
                %s
            </a>
            ', $link, $curentStatus['class'], $curentStatus['name']  ); //%s đầu tiên sẽ ứng với $by, %s thứ 2 sẽ tương ứng với $time
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
        $tmpButton = [
            'edit' => ['class' => 'btn-success', 'title' => 'Edit', 'icon' => 'fa-pencil', 'route-name' => $controllerName . '/form'], 
            'delete' => ['class' => 'btn-danger', 'title' => 'Delete', 'icon' => 'fa-trash', 'route-name' => $controllerName. '/delete'],
            'info' => ['class' => 'btn-info', 'title' => 'View', 'icon' => 'fa-pencil', 'route-name' => $controllerName . '/delete'] //dùng để xem chi tiết 1 slider nào đó 
        ];

        //định nghĩa buttonInArea 
        $buttonInArea = [
            'default' => ['edit', 'delete'], //mặc định phần quản lý sẽ có nút edit và delete 
            'slider' => ['edit', 'delete'],
            'category' => ['edit', 'delete', 'info'],
        ];

        $controllerName = (array_key_exists($controllerName, $buttonInArea)) ? $controllerName : 'default'; 
        $listButtons = $buttonInArea[$controllerName];

        $xhtml = '<div class="zvn-box-btn-filter">';  
        foreach ($listButtons as $btn) {
            $currentButton = $tmpButton[$btn];
            $link = route($currentButton['route-name'], ['id' => $id]);
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
