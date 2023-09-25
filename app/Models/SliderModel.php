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
    protected $fieldSearchAccepted = [   // chỉ khi là 1 trong các field dứoi đây mới cho phép search, còn lại thì ko 
        'id',  
        'name', 
        'description', 
        'link'
    ];

    //xây dựng phương thức lấy ra tất cả các phần tử
    //ta đẩy việc lấy dữ liệu về cho SliderModel giải quyết chứ ko giải quyết ở SliderController 
    public function listItems($params = null, $options = null) {
        $result = null; 

        //có 2 kiểu search, 1: search theo id, 2: search theo 1 tiêu chí vd id / name / description ...
        echo '<pre style="color:red">';
        print_r($params);
        echo '</pre>';

        //params chứa nhưng tham số (có đk) ví dụ như id, options chứa những trạng thái của phần tử, vd như active, inactive,...
        if($options['task'] == 'admin-list-items'){
            //$result =  SliderModel::all();
            //chỉ định rõ cột ta cần lấy dữ liẹu chứ không cần lấy hết như bên trên 
            $query = $this -> select('id','name','description', 'status', 'link','thumb', 'created', 'created_by', 'modified', 'modified_by');
            //cách viết khác 
            //$result = SliderModel::all('id','name','description');

            //nếu param tồn tại và có giá trị khác all thì tiếp tục gọi đến điều kiện where => chỉ hiển thị những phần tử có trạng thái như ta mong muốn
            if($params['filter']['status'] !== "all" ){
                $query->where('status', '=', $params['filter']['status']);
            }

            if($params['search']['value'] !== "" ){
      
                if($params['search']['field'] == "all") {
                    $query->where(function($query) use ($params) {
                        foreach($this->fieldSearchAccepted as $column) {
                            $query->orWhere($column, 'LIKE', "%{$params['search']['value']}%" );
                        }
                    });
                } else if(in_array($params['search']['field'], $this->fieldSearchAccepted)) {
                    echo '<h3 style="color:red"> 123 </h3>';
                    $query->where($params['search']['field'], 'LIKE', "%{$params['search']['value']}%");
                }
            }


            $result = $query ->orderBy('id','desc') // xuất hiện theo id giảm dần
                            ->paginate($params['pagination']['totalItemsPerPage']); //phân cho trên 1 trang hiển thị số phần tử mà ta mong muốn
        }

        return $result;
    }

    //xây dựng phương thức lấy ra trạng thái của phẩn tử và số phần tử tương ứng với trạng thái đó
    public function countItems($params = null, $options = null) {
        $result = null; 

        //params chứa nhưng tham số (có đk) ví dụ như id, options chứa những trạng thái của phần tử, vd như active, inactive,...
        if($options['task'] == 'admin-count-items-group-by-status'){

            //trong sql ta có câu lệnh để lấy ra status và số phần tử ứng với từng trạng thái như sau: SELECT `status`, COUNT(id) as COUNT FROM `slider` group by `status`;
            // $result = self::select(DB::raw('count(id) as count, status'))
            // ->groupBy('status')
            // ->get()
            // ->toArray(); 

            $query = $this::groupBy('status')
                      ->select(DB::raw('status, COUNT(id) as count'));

            if($params['search']['value'] !== "" ){
      
                if($params['search']['field'] == "all") {
                    $query->where(function($query) use ($params) {
                        foreach($this->fieldSearchAccepted as $column) {
                            $query->orWhere($column, 'LIKE', "%{$params['search']['value']}%" );
                        }
                    });
                } else if(in_array($params['search']['field'], $this->fieldSearchAccepted)) {
                    echo '<h3 style="color:red"> 123 </h3>';
                    $query->where($params['search']['field'], 'LIKE', "%{$params['search']['value']}%");
                }
            }

            $result = $query->get()->toArray();
        }
        return $result;
    }

    //Xây dựng phương thức saveItem
    public function saveItem($params = null, $options = null) {
        // nếu task là change-status thì sẽ tiến hành cập nhật lại trạng thái
        if($options['task'] == 'change-status') {
            $status = ($params['currentStatus'] == "active") ? "inactive" : "active"; //nếu status hiện tại là active thì đổi lại thành inactive và ngược lại

            self::where('id', $params['id']) -> update(['status' => $status ]); //  lưu và cập nhật lại trạng thái status thep điều kiện trên
        }
    }

    //Xây dựng phương thức deleteItem
    public function deleteItem($params = null, $options = null) {
        if($options['task'] == 'delete-item') {
            self::where('id', $params['id']) -> delete(); 
        }
    }

}
