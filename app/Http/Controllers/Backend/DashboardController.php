<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\Article;
use App\Models\StockinDetail;
use App\Models\SaleDetail;
use App\Events\RealTimeMessage;


class DashboardController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }


    public function index()
    {
        if (is_null($this->user) || !$this->user->can('dashboard.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view dashboard !');
        }
        //dynamic chart

        $year = ['2022','2023','2024','2025'];
        
        $stockout = [];
        foreach ($year as $key => $value) {
            $stockout[] = SaleDetail::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"),$value)->sum('total_value');
        }

        $stockin = [];
        foreach ($year as $key => $value) {
            $stockin[] = StockinDetail::where(\DB::raw("DATE_FORMAT(created_at, '%Y')"),$value)->sum('total_value');
        }

        //total roles
        $total_roles = count(Role::select('id')->get());
        //total admins
        $total_admins = count(Admin::select('id')->get());
        //total permissions
        $total_permissions = count(Permission::select('id')->get());
        //total quantity stock
        $quantityTot_stock = DB::table("stocks")->sum('quantity');
        //total quantity stockin
        $quantityTot_stockin = DB::table("stockin_details")->sum('quantity');
        //total quantity stockout
        $quantityTot_stockout = DB::table("sale_details")->sum('quantity');
        //total items
        $total_article = count(Article::select('id')->get());


        return view('backend.pages.dashboard.index', 
            compact(
            'total_admins', 
            'total_roles', 
            'total_permissions',
            'total_article',

            'quantityTot_stockin',
            'quantityTot_stockout',
            'quantityTot_stock',

            ))->with('year',json_encode($year,JSON_NUMERIC_CHECK))->with('stockout',json_encode($stockout,JSON_NUMERIC_CHECK))->with('stockin',json_encode($stockin,JSON_NUMERIC_CHECK));
    }

    //change language function
    public function changeLang(Request $request){
        \App::setlocale($request->lang);
        session()->put("locale",$request->lang);
        event(new RealTimeMessage('Hello World'));

        return redirect()->back();
    }
}
