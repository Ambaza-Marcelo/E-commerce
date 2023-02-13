<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;
use App\Models\Article;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Stock;
use App\Models\Stockin;
use App\Models\StockinDetail;
use App\Models\Report;
use App\Models\Order;
use App\Models\Setting;
use PDF;
use Validator;
use App\Exports\SaleExport;
use Excel; 

class SaleController extends Controller
{
    //constructor
     public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *listing all sales
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (is_null($this->user) || !$this->user->can('sales.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any sale !');
        }

        $sales = Sale::all();

        return view('backend.pages.sale.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     *form for creating new sale
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('sales.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any sale !');
        }

        $articles  = Article::all();
        $orders = Order::all();
        return view('backend.pages.sale.create', compact('articles','orders'));
    }

    /**
     * Store a newly created resource in storage.
     *store sale
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('sales.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any sale !');
        }

        $rules = array(
                'article_id.*'  => 'required',
                'date'  => 'required',
                'quantity.*'  => 'required',
                'customer'  => 'required',
                //'commande_no'  => 'required',
                'observation'  => 'required'
            );

            $error = Validator::make($request->all(),$rules);

            if($error->fails()){
                return response()->json([
                    'error' => $error->errors()->all(),
                ]);
            }

            $article_id = $request->article_id;
            $date = $request->date;
            $observation =$request->observation; 
            $quantity = $request->quantity;
            $commande_no = $request->commande_no;

            $unit_price = $request->unit_price;
            $customer =$request->customer; 
            
            $bon_no = "Fac".date("y").substr(number_format(time() * mt_rand(), 0, '', ''), 0, 6);
            $created_by = $this->user->name;

            //sales of multiple items


            for( $count = 0; $count < count($article_id); $count++ ){

                $unit_price = Article::where('id', $article_id[$count])->value('unit_price');

                $total_value = $quantity[$count] * $unit_price;

                $valeurStockInitial = Stock::where('article_id', $article_id[$count])->value('total_value');
                $quantityStockInitial = Stock::where('article_id', $article_id[$count])->value('quantity');

                $stockTotal = Report::where('article_id', $article_id[$count])->value('stock_total');

                $quantityRestant = $quantityStockInitial - $quantity[$count];

                    $data = array(
                    'article_id' => $article_id[$count],
                    'date' => $date,
                    'quantity' => $quantity[$count],
                    'total_value' => $total_value,
                    'customer' => $customer,
                    'bon_no' => $bon_no,
                    'commande_no' => $commande_no,
                    'created_by' => $created_by,
                    'observation' => $observation,
                    'created_at' => \Carbon\Carbon::now()
                );
                $insert_data[] = $data;
                

                $reportData = array(
                    'article_id' => $article_id[$count],
                    'quantity_stock_initial' => $quantityStockInitial,
                    'value_stock_initial' => $valeurStockInitial,
                    'quantity_stockout' => $quantity[$count],
                    'value_stockout' => $quantity[$count] * $unit_price,
                    'quantity_stock_final' => $stockTotal - $quantity[$count],
                    'created_by' => $created_by,
                    'bon_sortie' => $bon_no,
                    'created_at' => \Carbon\Carbon::now()
                );
                $report[] = $reportData;
                
                    $donnees = array(
                        'article_id' => $article_id[$count],
                        'quantity' => $quantityRestant,
                        'total_value' => $quantityRestant * $unit_price,
                        'created_by' => $this->user->name
                    );

                    //if quantity is not enough
                    
                    if ($quantity[$count] <= $quantityStockInitial) {

                        Report::insert($report);
                        
                        Stock::where('article_id',$article_id[$count])
                        ->update($donnees);

                        
                    }else{
                        session()->flash('error', 'invalid quantity!!');
                        return redirect()->back();
                    }
                    


                
            }

                        $sale = new Sale();
                        $sale->bon_no = $bon_no;
                        $sale->date = $date;
                        $sale->customer = $customer;
                        $sale->observation = $observation;
                        $sale->commande_no = $commande_no;
                        $sale->created_by = $this->user->name;
                        $sale->save();

                        SaleDetail::insert($insert_data);
                        //return redirect with success message

            session()->flash('success', 'Sale has been created !!');
            return redirect()->route('admin.sales.index');

        
    }

    /**
     * Display the specified resource.
     *show all by invoice number
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($bon_no)
    {
        //
         $code = SaleDetail::where('bon_no', $bon_no)->value('bon_no');
         $sales = SaleDetail::where('bon_no', $bon_no)->get();
         return view('backend.pages.sale.show', compact('sales','code'));
    }

    /**
     * Show the form for editing the specified resource.
     *show from fro editing
     * @param  int  $bon_no
     * @return \Illuminate\Http\Response
     */
    public function edit($bon_no)
    {
        if (is_null($this->user) || !$this->user->can('sales.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any sale !');
        }

        $sale = Sale::where('bon_no', $bon_no)->first();
        $saleDetails = SaleDetail::where('bon_no' , $bon_no)->get();
        $articles  = Article::all();
        return view('backend.pages.sale.edit', compact('sale','saleDetails', 'articles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $bon_no
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $bon_no)
    {
        if (is_null($this->user) || !$this->user->can('sales.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any sale !');
        }

        $rules = array(
                'article_id.*'  => 'required',
                'date'  => 'required',
                'quantity.*'  => 'required',
                'destination.*'  => 'required',
                'asker'  => 'required',
                'observation'  => 'required'
            );

            $error = Validator::make($request->all(),$rules);

            if($error->fails()){
                return response()->json([
                    'error' => $error->errors()->all(),
                ]);
            }

            $article_id = $request->article_id;
            $date = $request->date;
            $observation =$request->observation; 
            $supplier = $request->supplier;
            $unit = $request->unit;
            $quantity = $request->quantity;


            $unit_price = $request->unit_price;
            $destination = $request->destination;
            $customer =$request->customer; 
            
            $created_by = $this->user->name;


            for( $count = 0; $count < count($article_id); $count++ ){

                $unit_price = Article::where('id', $article_id[$count])->value('unit_price');

                $total_value = $quantity[$count] * $unit_price;

                $valeurStockInitial = Stock::where('article_id', $article_id[$count])->value('total_value');
                $quantityStockInitial = Stock::where('article_id', $article_id[$count])->value('quantity');

                $quantityRestant = $quantityStockInitial - $quantity[$count];


                $data = array(
                    'article_id' => $article_id[$count],
                    'date' => $date,
                    'quantity' => $quantity[$count],
                    'unit' => $unit[$count],
                    'total_value' => $total_value,
                    'destination' => $destination[$count],
                    'asker' => $asker,
                    'created_by' => $created_by,
                    'observation' => $observation,
                );
                $insert_data[] = $data;



                $reportData = array(
                    'article_id' => $article_id[$count],
                    'quantity_stockout' => $quantity[$count],
                    'value_stockout' => $quantity[$count] * $unit_price,
                    'created_by' => $created_by,
                    'created_at' => \Carbon\Carbon::now()
                );
                $report[] = $reportData;
                
                    $donnees = array(
                        'article_id' => $article_id[$count],
                        'quantity' => $quantityRestant,
                        'total_value' => $quantityRestant * $unit_price,
                        'unit' => $unit[$count],
                        'created_by' => $this->user->name,
                        'verified' => false
                    );
                    
                    if ($quantity[$count] <= $quantityStockInitial) {
                        
                        Stock::where('article_id',$article_id[$count])
                        ->update($donnees);
                        SaleDetail::where('article_id',$article_id[$count])
                        ->update($data);
                        Report::where('article_id',$article_id[$count])
                        ->update($reportData);

                        
                    }else{
                        session()->flash('error', 'invalid quantity!!');
                        return redirect()->back();
                    }
                    


                
            }

                        $sale = Sale::where('bon_no', $bon_no)->first();
                        $sale->date = $date;
                        $sale->entree_no = $bon_entree_no;
                        $sale->customer = $customer;
                        $sale->observation = $observation;
                        $sale->created_by = $this->user->name;
                        $sale->save();

        session()->flash('success', 'Sale has been updated !!');
        return back();
    }

    public function bon_sortie($bon_no)
    {
        if (is_null($this->user) || !$this->user->can('sales.create')) {
            abort(403, 'Sorry !! You are Unauthorized!');
        }
        //invoice create
        $setting = DB::table('settings')->orderBy('created_at','desc')->first();
        $datas = SaleDetail::where('bon_no', $bon_no)->get();
        $totalValue = DB::table('sale_details')
            ->where('bon_no', '=', $bon_no)
            ->sum('total_value');
        $customer = Sale::where('bon_no', $bon_no)->value('customer');
        $description = Sale::where('bon_no', $bon_no)->value('observation');
        $commande_no = Sale::where('bon_no', $bon_no)->value('commande_no');
        $gestionnaire = Sale::where('bon_no', $bon_no)->value('created_by');
        $pdf = PDF::loadView('backend.pages.document.facture',compact('datas','bon_no','totalValue','customer','gestionnaire','setting','description','commande_no'));

        Storage::put('public/pdf/facture/'.$bon_no.'.pdf', $pdf->output());

        // download pdf file
        return $pdf->download($bon_no.'.pdf');
    }

    public function get_stockout_data()
    {
        //export to excel
        return Excel::download(new StockoutExport, 'sorties.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $bon_no
     * @return \Illuminate\Http\Response
     */
    public function destroy($bon_no)
    {
        if (is_null($this->user) || !$this->user->can('sales.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any sale !');
        }
        //destroy sales by bon_no

        $sale = Sale::where('bon_no', $bon_no)->first();


        if (!is_null($sale)) {
    
            SaleDetail::where('bon_no',$bon_no)->delete();
            Report::where('bon_sortie',$bon_no)->delete();
            $sale->delete();
        }

        session()->flash('success', 'Sale has been deleted !!');
        return back();
    }
}
