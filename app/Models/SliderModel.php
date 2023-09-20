<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SliderModel extends Model
{
    //ở đây ta đang setup lại: mặc dù model có tên là SliderModel nhưng nó vẫn kết nối được với bảng sliders để làm việc chứ không cần phải tuân thủ nguyên tắc tên giống hệt nhau
    protected $table = 'slider';
    //định nghĩa khoá chính 
    //protected $primaryKey = "id"; //trong DB ta đã mặc định id là khoá chính nên có thể ko cần viết cũng được
    public $timestamps = false;
    //cấu hình lại tg tạo ra và sửa chữa 
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    //xây dựng phương thức lấy ra tất cả các phần tử
    //ta đẩy việc lấy dữ liệu về cho SliderModel giải quyết chứ ko giải quyết ở SliderController 
    public function listItems($params = null, $options = null) {
        $result = null; 

        //params chứa nhưng tham số (có đk) ví dụ như id, options chứa những trạng thái của phần tử, vd như active, inactive,...
        if($options['task'] == 'admin-list-items'){
            //$result =  SliderModel::all();
            //chỉ định rõ cột ta cần lấy dữ liẹu chứ không cần lấy hết như bên trên 
            $result = self::select('id','name','description', 'status', 'link','thumb', 'created', 'created_by', 'modified', 'modified_by')
                            //->where('id', '>', 3)
                            ->orderBy('id','desc') // xuất hiện theo id giảm dần
                            ->paginate($params['pagination']['totalItemsPerPage']); //phân cho trên 1 trang hiển thị số phần tử mà ta mong muốn
                            //->get(); //self ở đây chính là class SliderModel, cách viết này giúp tối ưu code, sau này có copy code thì cũng chỉ cần sửa class name thôi 
            //cách viết khác 
            //$result = SliderModel::all('id','name','description');
        }

        return $result;
    }

    //xây dựng phương thức lấy ra trạng thái của phẩn tử và số phần tử tương ứng với trạng thái đó
    public function countItems($params = null, $options = null) {
        $result = null; 

        //params chứa nhưng tham số (có đk) ví dụ như id, options chứa những trạng thái của phần tử, vd như active, inactive,...
        if($options['task'] == 'admin-count-items'){
            //trong sql ta có câu lệnh để lấy ra status và số phần tử ứng với từng trạng thái như sau: SELECT `status`, COUNT(id) as COUNT FROM `slider` group by `status`;
            $result = self::select(DB::raw('count(id) as count, status'))
            ->groupBy('status')
            ->get()
            ->toArray();

            //echo '<h3 style="color:red">countItems</h3>'; //countItems
        }

        return $result;
    }
}
