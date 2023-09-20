<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// định nghĩa phần tiền tố dành cho admin 
$prefixAdmin = config('dinhnghiachung.url.prefix_admin');
//$prefixAdmin = Config::get('dinhnghiachung.url.prefix_admin', 'hehe'); //cách viết khác cho cách viết trên, 'hehe' là giá trị default trong trường hợp ko có giá trị nào được định nghĩa bên file định nghĩa chung kia nó sẽ trả ra đường link có dạng http://127.0.0.1:8000/hehe/slider/edit/124


// Route::get('/', function () {
//     //return "Cài đặt Laravel đã thành công HAHHAHA"; 
//     return view('home');
// });

// Route::get('/about', function () {
//     return "About";
// });

// //ở đây ta đang cố định cho id phải là 1 số 
// Route::get('/category/{id}', function ($id) {
//     return 'Category '.$id;
// })->where('id', '[0-9]+');

// //? có nghĩa là xuất hiện cũng được, ko xuất hiện cũng đươc (ko có tham số nó sẽ tự động lấy tham số mặc định và in ra là John)
// Route::get('/category/{name?}', function ($name = 'John') {
//     return $name;
// });

/////////////////////////////////////////////////////

// Route::get('/admin123/user', function () {
//     return "/admin123/user";
// });

// Route::get('/admin123/slider', function () {
//     return "/admin123/slider";
// });

// Route::get('/admin123/category', function () {
//     return "/admin123/category";
// });

// Router Prefixes - tiền tố Router - áp dụng để ta có thể dùng lại mà ko cần viết đi viết lại
Route::prefix($prefixAdmin)->group(function () {
    Route::get('user', function() {
        return "/admin/user";
    });

    //======================================SLIDER=======================================
    //tạo ra khai báo router của phần slider
    $prefix = 'slider';
    $controllerName = 'slider';
    //trong slider ta lại có 1 list để quản lý 
    Route::prefix($prefix)->group(function () use($controllerName) {
        // //echo '<h3 style="color:red">' . $prefix . '</h3>'; //kiem tra xem có in ra đúng $prefix được như ming muốn không

        // //$controller ='SliderController@';
        $controller = ucfirst($controllerName) . 'Controller@'; //cách viết thay thế cho dòng trên, ucfist() là hàm giúp in hoa chữ cái đầu tiên

        // // Route::get('', function() {
        // //     return "slider list";
        // // });
        // Route::get('/', $controller .'index'); //SliderController Là tệp nằm trong Controllers, index là action nằm trong tệp đó

        // // Route::get('edit/{id}', function($id) {
        // //     return "slider edit" .$id;
        // // })->where('id', '[0-9]+');
        // Route::get('form/{id?}', $controller . 'form')->where('id', '[0-9]+');

        // // Route::get('delete/{id}', function($id) {
        // //     return "slider delete" .$id;
        // // })->where('id', '[0-9]+');
        // Route::get('delete/{id}', $controller . 'delete')->where('id', '[0-9]+');

        // //giả sử ta khai báo 1 route vớ 2 tham số (chứ ko phải 1 tham số như trên nữa)
        //     //change-status-active/12 => inactive/12 
        //     //change-status-inactive/32 => active/32 
        // Route::get('change-status-{status}/{id}', $controller . 'status')->where('id', '[0-9]+');



        //Với cách viết như trên ta không thể định danh cho nó được 
        Route::get('/',[
            'as' =>  $controllerName, 
            'uses' => $controller . 'index'
        ]);

        Route::get('form/{id?}',[
            'as' => $controllerName . '/form', 
            'uses' =>  $controller . 'form'
        ])->where('id', '[0-9]+');
        Route::get('delete/{id}',[
            'as' => $controllerName . '/delete', 
            'uses' =>  $controller . 'delete'
        ])->where('id', '[0-9]+');
        Route::get('change-status-{status}/{id}',[
            'as' => $controllerName . '/status', 
            'uses' =>  $controller . 'status'
        ])->where('id', '[0-9]+');

    });


    //======================================CATEGORY=======================================
    $prefix = 'category';
    $controllerName = 'category';
    Route::prefix($prefix)->group(function () use($controllerName) {

        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('/',[
            'as' =>  $controllerName, 
            'uses' => $controller . 'index'
        ]);

        Route::get('form/{id?}',[
            'as' => $controllerName . '/form', 
            'uses' =>  $controller . 'form'
        ])->where('id', '[0-9]+');
        Route::get('delete/{id}',[
            'as' => $controllerName . '/delete', 
            'uses' =>  $controller . 'delete'
        ])->where('id', '[0-9]+');
        Route::get('change-status-{status}/{id}',[
            'as' => $controllerName . '/status', 
            'uses' =>  $controller . 'status'
        ])->where('id', '[0-9]+');

    });

    //======================================DASHBOARD - bảng điều khiển=======================================
    $prefix = 'dashboard';
    $controllerName = 'dashboard';
    Route::prefix($prefix)->group(function () use($controllerName) {

        $controller = ucfirst($controllerName) . 'Controller@';
        Route::get('/',[
            'as' =>  $controllerName, 
            'uses' => $controller . 'index'
        ]);
        
    });

}); 


