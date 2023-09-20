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
        $this -> params["pagination"]["totalItemsPerPage"] = 3; // hiển thị ra số phần tử trên 1 trang theo yêu cầu của mình chứ ko mặc định
        View::share('controllerName', $this->controllerName); 
        // cách ghi khác mà ko cần sử dụng use...View bên trên 
        //view()->share('controllerName', $this->controllerName);
    }

    //trong function này ta đang nói tập tin index (resource/views/admin/pages/index.blade.php chứa toàn bộ giao diện của dự án)
    public function index()
    {
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
            'items' => $items, 
            'itemsStatusCount' => $itemsStatusCount
            //'controllerName' => $this ->controllerName //truyền giá trị $controllerName ra ngoài view 
        ]); // index là action ta đang làm việc 
    }

    public function form($id = null)
    {
        // echo '<pre style="color:red">';
        // print_r($id);    //hàm in ra id mà ta đã truyền vào bên bên => check xem có đúng không 
        // echo '</pre>';

        $title = "SliderController - form";

        // cách viết ['id' -> $id] giúp ta truyền id ra form để trong resource/views/admin/slider/form... ta có thể call id này ra được
        return view($this->pathViewController . 'form', [
            'id' => $id, 
            'title' => $title, 
            //'controllerName' => $this ->controllerName //truyền giá trị $controllerName ra ngoài view và đi vào form
        ]);
    }

    // phải khai báo use ....request ở trên ta mới có thể sử sử dụng request dưới này để lấy ra id, status...
    public function status(Request $request) 
    {
        echo '<h3 style="color:red">STATUS: ' . $request->route('status') . '</h3>'; 
        echo '<h3 style="color:red">ID: ' . $request->route('id') . '</h3>'; 
        //c2
        echo '<h3 style="color:red">STATUS: ' . $request->status . '</h3>'; 
        echo '<h3 style="color:red">ID: ' . $request->id . '</h3>'; 
        //return "SliderController - status ";

        //phân tích:
            // user -> slider trạng thái hiện => tắt đi => link: http://127.0.0.1:8000/admin123/slider/change-status-active/123
            // vấn đề: từ slider-status làm sao hiện được về trang danh sách list ban đầu
            // sử dụng redirect 
        return redirect()->route('slider');
    }

    public function delete()
    {        
        return view($this->pathViewController . 'delete');
    }
}
