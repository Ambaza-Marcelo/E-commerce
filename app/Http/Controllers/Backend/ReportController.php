<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Stockin;
use App\Models\Stockout;
use App\Models\Stock;
use App\Models\Article;
use App\Models\Emplacement;
use App\Models\Report;
use App\Models\FuelReport;
use App\Models\MachineRepairingDetail;
use Carbon\Carbon;
use App\Exports\ReportExport;
use Excel;
use PDF;

class ReportController extends Controller
{
    //
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }
    public function dayReport(){
    	 
    	 if (is_null($this->user) || !$this->user->can('report.view')) {
            abort(403, 'Muradutunge !! Ntaburenganzira mufise bwo kuraba raporo,mufise ico mubaza murashobora guhamagara kuri 122 !');
        }
        
        $reportDays = Report::select(
                        DB::raw('DAY(created_at) as day,MONTH(created_at) as month,YEAR(created_at) as year'),
                        DB::raw('article_id,bon_entree,bon_sortie,created_by,sum(quantity_stock_initial) as q_stock_ini,sum(value_stock_initial) as v_s_ini,sum(quantity_stockin) as q_stockin,sum(value_stockin) as v_stockin,sum(stock_total) as q_tot_stock,sum(quantity_stockout) as q_stockout,sum(value_stockout) as v_stockout'))->groupBy('article_id','bon_entree','bon_sortie','created_by','day','month','year')->get();
       return view('backend.pages.report.day_report.index',compact('reportDays'));


    }

    public function monthReport(){

        if (is_null($this->user) || !$this->user->can('report.view')) {
            abort(403, 'Muradutunge !! Ntaburenganzira mufise bwo kuraba raporo,mufise ico mubaza murashobora guhamagara kuri 122 !');
        }
        /*
    	$stockInitial = Stock::select(
                        DB::raw('MONTH(created_at) as month,YEAR(created_at) as year'),
                        DB::raw('article_id,sum(quantity) as total_quantity,sum(total_value) as tot_value'))->groupBy('article_id')->get();

        */
        $qStock = Report::orderBy('created_at','desc')->first();
        $reportMonths = Report::select(
                        DB::raw('MONTH(created_at) as month,YEAR(created_at) as year'),
                        DB::raw('article_id,service_id,bon_entree,bon_sortie,created_by,sum(quantity_stock_initial) as q_stock_ini,sum(value_stock_initial) as v_s_ini,sum(quantity_stockin) as q_stockin,sum(value_stockin) as v_stockin,sum(stock_total) as q_tot_stock,sum(quantity_stockout) as q_stockout,sum(value_stockout) as v_stockout'))->groupBy('article_id','service_id','bon_entree','bon_sortie','created_by','month','year')->get();
        return view('backend.pages.report.month_report.index',compact('reportMonths'));
    }


    public function personalizedReport(Request $request){

        if (is_null($this->user) || !$this->user->can('report.view')) {
            abort(403, 'Muradutunge !! Ntaburenganzira mufise bwo kuraba raporo,mufise ico mubaza murashobora guhamagara kuri 122 !');
        }

        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required|after:start_date'
        ]);

        $dateS = $request->start_date;
        $dateE = $request->end_date;
 
        $reports = Report::select(
                        DB::raw('DAY(created_at) as day,MONTH(created_at) as month,YEAR(created_at) as year'),
                        DB::raw('bon_entree,bon_sortie,created_by,sum(quantity_stock_initial) as q_stock_ini,sum(value_stock_initial) as v_s_ini,sum(quantity_stockin) as q_stockin,sum(value_stockin) as v_stockin,sum(stock_total) as q_tot_stock,sum(quantity_stockout) as q_stockout,sum(value_stockout) as v_stockout'))->whereBetween('created_at',[$dateS,$dateE])->groupBy('bon_entree','bon_sortie','created_by','month','year')->get();
                        
        return view('backend.pages.report.personalized_report.index',compact('reports'));
    }

    public function sixMonthReport(){

        if (is_null($this->user) || !$this->user->can('report.view')) {
            abort(403, 'Muradutunge !! Ntaburenganzira mufise bwo kuraba raporo,mufise ico mubaza murashobora guhamagara kuri 122 !');
        }

        $dateS = Carbon::now()->startOfMonth()->subMonth(6);
        $dateE = Carbon::now()->startOfMonth(); 

        
        $qStock = Report::orderBy('created_at','desc')->first();
        $report6Months = Report::select(
                        DB::raw('MONTH(created_at) as month,YEAR(created_at) as year'),
                        DB::raw('bon_entree,bon_sortie,created_by,sum(quantity_stock_initial) as q_stock_ini,sum(value_stock_initial) as v_s_ini,sum(quantity_stockin) as q_stockin,sum(value_stockin) as v_stockin,sum(stock_total) as q_tot_stock,sum(quantity_stockout) as q_stockout,sum(value_stockout) as v_stockout'))->whereBetween('created_at',[$dateS,$dateE])->groupBy('bon_entree','bon_sortie','created_by','month','year')->get();
                        
        return view('backend.pages.report.six_month.index',compact('report6Months'));
    }

    public function yearReport(){
        if (is_null($this->user) || !$this->user->can('report.view')) {
            abort(403, 'Muradutunge !! Ntaburenganzira mufise bwo kuraba raporo,mufise ico mubaza murashobora guhamagara kuri 122 !');
        }
        /*
    	$stockInitial = Stock::select(
                        DB::raw('MONTH(created_at) as month,YEAR(created_at) as year'),
                        DB::raw('article_id,sum(quantity) as total_quantity,sum(total_value) as tot_value'))->groupBy('article_id')->get();

        */
        $reportYears = Report::select(
                        DB::raw('YEAR(created_at) as year'),
                        DB::raw('article_id,bon_entree,bon_sortie,created_by,sum(quantity_stock_initial) as q_stock_ini,sum(value_stock_initial) as v_s_ini,sum(quantity_stockin) as q_stockin,sum(value_stockin) as v_stockin,sum(stock_total) as q_tot_stock,sum(quantity_stockout) as q_stockout,sum(value_stockout) as v_stockout'))->groupBy('article_id','bon_entree','bon_sortie','created_by','year')->get();
        return view('backend.pages.report.year_report.index',compact('reportYears'));
    }

    public function trimester(){
        /*
         $items = Item::select('*')

                        ->whereBetween('created_at', 

                            [Carbon::now()->subMonth(6), Carbon::now()]

                        )

                        ->get();
                        */
    }

    public function stockMovement(){
        if (is_null($this->user) || !$this->user->can('report.view')) {
            abort(403, 'Muradutunge !! Ntaburenganzira mufise bwo kuraba raporo,mufise ico mubaza murashobora guhamagara kuri 122 !');
        }
       $stockMovements = Report::select(
                        DB::raw('created_at,service_id,bon_entree,quantity_stock_initial,quantity_stockin,stock_total,quantity_stockout,bon_sortie,created_by,article_id,sum(quantity_stock_initial) as q_stock_ini,sum(value_stock_initial) as v_s_ini,sum(quantity_stockin) as q_stockin,sum(value_stockin) as v_stockin,sum(stock_total) as q_tot_stock,sum(quantity_stockout) as q_stockout,sum(value_stockout) as v_stockout'))->groupBy('bon_entree','bon_sortie','created_by','created_at','article_id','quantity_stockin','quantity_stockout','quantity_stock_initial','stock_total','service_id')->get();
        return view('backend.pages.report.stock_movement.index',compact('stockMovements'));
    }

    public function toPdf()
    {
        if (is_null($this->user) || !$this->user->can('stock.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any stock !');
        }

        $datas = Report::all();
        $setting = DB::table('settings')->orderBy('created_at','desc')->first();
        $currentTime = Carbon::now();

        $dateT =  $currentTime->toDateTimeString();

        $dateTime = str_replace([' ',':'], '_', $dateT);
        $pdf = PDF::loadView('backend.pages.document.stock_movement',compact('datas','dateTime','setting'));//->setPaper('a4', 'landscape');

        Storage::put('public/pdf/mouvement_stock/'.$dateTime.'.pdf', $pdf->output());

        // download pdf file
        return $pdf->download($dateTime.'.pdf');
    }

    //rapport usine

    public function dayReportMaintenance(){
         
         if (is_null($this->user) || !$this->user->can('machine_repairing.view')) {
            abort(403, 'Muradutunge !! Ntaburenganzira mufise bwo kuraba raporo,mufise ico mubaza murashobora guhamagara kuri 122 !');
        }

        $machines = MachineRepairingDetail::select(
                        DB::raw('machine_id,sum(new_quantity) as new_quantit'))->where('status',2)->groupBy('machine_id')->orderBy('new_quantit','desc')->get();
        
        $reportDays = MachineRepairingDetail::select(
                        DB::raw('DAY(date) as day,MONTH(date) as month,YEAR(date) as year'),
                        DB::raw('bon_no,machine_id,article_id,status,unit,new_unit,start_date,end_date,created_by,sum(quantity) as quantit,sum(new_quantity) as new_quantit'))->groupBy('bon_no','machine_id','article_id','unit','new_unit','status','start_date','end_date','created_by','day','month','year')->get();
       return view('backend.pages.report_maintenance.day_report.index',compact('reportDays','machines'));


    }

    public function toPdfMaintenance()
    {
        if (is_null($this->user) || !$this->user->can('report.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any stock !');
        }

        $datas = MachineRepairingDetail::all();
        $setting = DB::table('settings')->orderBy('created_at','desc')->first();
        $currentTime = Carbon::now();

        $dateT =  $currentTime->toDateTimeString();

        $dateTime = str_replace([' ',':'], '_', $dateT);
        $pdf = PDF::loadView('backend.pages.document.report_maintenance',compact('datas','dateTime','setting'));//->setPaper('a4', 'landscape');

        Storage::put('public/pdf/rapport_maintenance/'.$dateTime.'.pdf', $pdf->output());

        // download pdf file
        return $pdf->download($dateTime.'.pdf');
    }

    public function monthReportUsine(){

        if (is_null($this->user) || !$this->user->can('report.view')) {
            abort(403, 'Muradutunge !! Ntaburenganzira mufise bwo kuraba raporo,mufise ico mubaza murashobora guhamagara kuri 122 !');
        }

        $reportMonths = MachineRepairingDetail::select(
                        DB::raw('MONTH(date) as month,YEAR(date) as year'),
                        DB::raw('bon_no,machine_id,article_id,status,unit,new_unit,start_date,end_date,created_by,sum(quantity) as quantit,sum(new_quantity) as new_quantit'))->groupBy('bon_no','machine_id','article_id','unit','new_unit','status','start_date','end_date','created_by','month','year')->get();
        return view('backend.pages.report_usine.month_report.index',compact('reportMonths'));
    }


    public function personalizedReportUsine(Request $request){

        if (is_null($this->user) || !$this->user->can('report.view')) {
            abort(403, 'Muradutunge !! Ntaburenganzira mufise bwo kuraba raporo,mufise ico mubaza murashobora guhamagara kuri 122 !');
        }

        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required|after:start_date'
        ]);

        $dateS = $request->start_date;
        $dateE = $request->end_date;
 
        $reports = MachineRepairingDetail::select(
                        DB::raw('DAY(created_at) as day,MONTH(created_at) as month,YEAR(created_at) as year'),
                        DB::raw('bon_entree,bon_sortie,created_by,sum(quantity_stock_initial) as q_stock_ini,sum(value_stock_initial) as v_s_ini,sum(quantity_stockin) as q_stockin,sum(value_stockin) as v_stockin,sum(stock_total) as q_tot_stock,sum(quantity_stockout) as q_stockout,sum(value_stockout) as v_stockout'))->whereBetween('created_at',[$dateS,$dateE])->groupBy('bon_entree','bon_sortie','created_by','month','year')->get();
                        
        return view('backend.pages.report_usine.personalized_report.index',compact('reports'));
    }

    public function yearReportUsine(){
        if (is_null($this->user) || !$this->user->can('report.view')) {
            abort(403, 'Muradutunge !! Ntaburenganzira mufise bwo kuraba raporo,mufise ico mubaza murashobora guhamagara kuri 122 !');
        }

        $reportYears = MachineRepairingDetail::select(
                        DB::raw('YEAR(date) as year'),
                        DB::raw('bon_no,machine_id,article_id,status,unit,new_unit,start_date,end_date,created_by,sum(quantity) as quantit,sum(new_quantity) as new_quantit'))->groupBy('bon_no','machine_id','article_id','unit','new_unit','status','start_date','end_date','created_by','year')->get();
        return view('backend.pages.report_usine.year_report.index',compact('reportYears'));
    }


    public function get_report_data()
    {
        return Excel::download(new ReportExport, 'rapports.xlsx');
    }

    public function rapportGeneral(){
        if (is_null($this->user) || !$this->user->can('report.view')) {
            abort(403, 'Muradutunge !! Ntaburenganzira mufise bwo kuraba raporo,mufise ico mubaza murashobora guhamagara kuri 122 !');
        }
       $stockFournitures = Report::select(
                        DB::raw('created_at,service_id,bon_entree,quantity_stock_initial,quantity_stockin,stock_total,quantity_stockout,bon_sortie,created_by,article_id,sum(quantity_stock_initial) as q_stock_ini,sum(value_stock_initial) as v_s_ini,sum(quantity_stockin) as q_stockin,sum(value_stockin) as v_stockin,sum(stock_total) as q_tot_stock,sum(quantity_stockout) as q_stockout,sum(value_stockout) as v_stockout'))->groupBy('bon_entree','bon_sortie','created_by','created_at','article_id','quantity_stockin','quantity_stockout','quantity_stock_initial','stock_total','service_id')->get();


        $stockCarburants = FuelReport::select(
                        DB::raw('created_at,fuel_pump_id,driver_car_id,quantite_stock_initiale,bon_entree,stock_totale,bon_sortie,auteur,quantite_entree,quantite_sortie'))->groupBy('created_at','fuel_pump_id','driver_car_id','quantite_stock_initiale','bon_entree','bon_sortie','auteur','quantite_entree','stock_totale','quantite_sortie')->get();

        return view('backend.pages.rapport_general.index',compact('stockFournitures','stockCarburants'));
    }
}
