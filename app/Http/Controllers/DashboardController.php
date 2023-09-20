<?php
 
namespace App\Http\Controllers; 
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View; 

class DashboardController extends Controller
{
    private $pathViewController = 'admin.dashboard.'; 
    private $controllerName = 'dashboard';

    public function __construct()
    {
        View::share('controllerName', $this->controllerName);
    }

    public function index()
    {
        return view($this->pathViewController . 'index', [
            
        ]); // index là action ta đang làm việc 
    }


}
