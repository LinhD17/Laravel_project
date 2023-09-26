<?php
 
namespace App\Http\Controllers; 
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View; 
//use DB;
use App\Models\SliderModel as MainModel; 

class SliderController extends Controller
{
    private $pathViewController = 'admin.pages.slider.'; 
    private $controllerName = 'slider';
    private $params = [];
    private $model;

    //share $controllerName đến tất cả các view dùng chung, sau khi share rồi thì ta không cần phải khai báo nó trong từng function bên dưới nữa
    //phải khai báo use...View bên trên ta mới có thể sử dụng được View dứoi đây
    public function __construct()
    {
        $this -> model = new MainModel;
        $this -> params["pagination"]["totalItemsPerPage"] = 5; // hiển thị ra số phần tử trên 1 trang theo yêu cầu của mình chứ ko mặc định
        //View::share('controllerName', $this->controllerName); 
        // cách ghi khác mà ko cần sử dụng use...View bên trên 
        view()->share('controllerName', $this->controllerName);
    }

    //trong function này ta đang nói tập tin index (resource/views/admin/pages/index.blade.php chứa toàn bộ giao diện của dự án)
    public function index(Request $request)
    {
        // thông qua phương thức request chúng ta lấy ra được filter hiênj tại 
        // echo '<h3 style="color: red">' .$request-> input('filter_status', 'all') . '</h3>';  //all, inactive hoặc active
        $this->params['filter']['status'] = $request-> input('filter_status', 'all');
        $this->params['search']['field'] = $request-> input('search_field', '');
        $this->params['search']['value'] = $request-> input('search_value', '');

        // echo '<pre style="color: red">';
        // print_r($this->params);
        // '</pre>';

        // echo '<h3 style="color: red">' . DB::connection()->getDatabaseName() . '</h3>';   //ở đay mới chỉ trả về project/_laravel, ta chưa biết được nó đã kết nối đứng hay chưa 

        // //thử lấy ra tên các table trong DB xem đã kết nối đúng chưa 
        // $tables = DB::select('SHOW TABLES');
        // foreach($tables as $table)
        // {
        //     echo '<pre style="color: red">';
        //     print_r($table);
        //     echo '</pre>';
        // }

        //test lấy ra 1 item trong bảng mà ta đã kết nối 
        $items = $this -> model -> listItems($this -> params, ['task' => 'admin-list-items']); //null là tham số cúa param, option là 1 array có task là admin-list-items
        // foreach ($items as $item) {
        //     echo '<h3 style="color:red">' . $item -> name . '</h3>';
        // }

        //lấy ra những trạng thái và số phần tử tương ứng với trạng thái đó 
        $itemsStatusCount = $this -> model -> countItems($this -> params, ['task' => 'admin-count-items-group-by-status']); // [['status', 'count']]

        return view($this->pathViewController . 'index', [
            'params' => $this->params,
            'items' => $items, 
            'itemsStatusCount' => $itemsStatusCount
            //'controllerName' => $this ->controllerName //truyền giá trị $controllerName ra ngoài view 
        ]); // index là action ta đang làm việc 
    }

    public function form(Request $request)
    {
        $item = null;
        //nếu request gọi đến id khác rỗng thì đây là TH edit, ngược lại thì là TH thêm mới 
        if ($request->id !== null) {
            $params["id"] = $request -> id;
            $item = $this-> model-> getItem($params, ['task' => 'get-item']);
        }

        // cách viết ['id' -> $id] giúp ta truyền id ra form để trong resource/views/admin/slider/form... ta có thể call id này ra được
        return view($this->pathViewController . 'form', [
            'item' => $item, 
        ]);
    }

    public function save(Request $request)
    {
            echo '<h3 style="color: red">save</h3>';
    }

    // phải khai báo use ....request ở trên ta mới có thể sử sử dụng request dưới này để lấy ra id, status...
    public function status(Request $request) 
    {
        $params["currentStatus"] = $request->status; 
        $params["id"] = $request->id; 
        $this->model->saveItem($params, ['task'=>'change-status']);  // $this->model đã có trong phần construct ở trên 
        //return "SliderController - status ";

        //phân tích:
            // user -> slider trạng thái hiện => tắt đi => link: http://127.0.0.1:8000/admin123/slider/change-status-active/123
            // vấn đề: từ slider-status làm sao hiện được về trang danh sách list ban đầu
            // sử dụng redirect 
        //return redirect()->route($this -> controllerName);
        return redirect()->route($this -> controllerName) -> with('zvn_notify', 'Cập nhật trạng thái thành công!'); // with... nhằm mục đích hiển thị câu thông báo đã hoàn thành 1 hành động nào đó 
    }

    public function delete(Request $request)
    {        
        $params["id"] = $request->id; 
        $this->model->deleteItem($params, ['task'=>'delete-item']);  
        return redirect()->route($this -> controllerName) -> with('zvn_notify', 'Xoá phần tử thành công!');
    }
}
