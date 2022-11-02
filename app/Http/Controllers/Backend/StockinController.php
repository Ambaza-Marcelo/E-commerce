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
use App\Models\Stockin;
use App\Models\Stock;
use App\Models\Report;
use App\Models\Setting;
use App\Models\Supplier;
use App\Models\StockinDetail;
use PDF;
use Validator;
use App\Exports\StockinExport;
use Excel;

class StockinController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (is_null($this->user) || !$this->user->can('stockin.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any stockin !');
        }

        $stockins = Stockin::all();

        return view('backend.pages.stockin.index', compact('stockins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('stockin.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any stockin !');
        }

        $commands  = DB::table('orders')->where('status',5)->whereNotIn('commande_no', function($q){
        $q->select('commande_no')->from('stockins');})->get();
        $articles  = Article::all();
        $suppliers  = Supplier::all();
        return view('backend.pages.stockin.create', compact('articles','commands','suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //cout unitaire moyen ponderee
    public function calculCump($vsi,$va,$qtu){
        return ($vsi + $va) / $qtu;
    }
    public function store(Request $request)
    {

        if (is_null($this->user) || !$this->user->can('stockin.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any stockin !');
        }

        $rules = array(
                'article_id.*'  => 'required',
                'date'  => 'required',
                'quantity.*'  => 'required',
                'total_value.*'  => 'required',
                'unit_price'  => 'required',
                'origin'  => 'required',
                'handingover'  => 'required',
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
            $commande_no = $request->commande_no;
            $observation =$request->observation; 
            $supplier = $request->supplier;
            $unit = $request->unit;
            $quantity = $request->quantity;


            $unit_price = $request->unit_price;
            //$total_value = 2000;
            $origin = $request->origin;
            $handingover =$request->handingover; 
            $bon_no = "BE000".date("y").substr(number_format(time() * mt_rand(), 0, '', ''), 0, 6);
            $created_by = $this->user->name;


            for( $count = 0; $count < count($article_id); $count++ ){
                $total_value = $quantity[$count] * $unit_price[$count];
                $data = array(
                    'article_id' => $article_id[$count],
                    'date' => $date,
                    'quantity' => $quantity[$count],
                    'unit_price' => $unit_price[$count],
                    'total_value' => $total_value,
                    'commande_no' => $commande_no,
                    'supplier' => $supplier,
                    'origin' => $origin,
                    'handingover' => $handingover,
                    'bon_no' => $bon_no,
                    'created_by' => $created_by,
                    'observation' => $observation,
                    'created_at' => \Carbon\Carbon::now()
                );
                $insert_data[] = $data;


                $valeurStockInitial = Stock::where('article_id', $article_id[$count])->value('total_value');
                $quantityStockInitial = Stock::where('article_id', $article_id[$count])->value('quantity');



                $valeurAcquisition = $quantity[$count] * $unit_price[$count];

                $valeurTotalUnite = $quantity[$count] + $quantityStockInitial;
                $cump = ($valeurStockInitial + $valeurAcquisition) / $valeurTotalUnite;

                $calcul_cump = array(
                        'unit_price' => $cump,
                    );
                Article::where('id',$article_id[$count])
                        ->update($calcul_cump);


                $reportData = array(
                    'article_id' => $article_id[$count],
                    'quantity_stock_initial' => $quantityStockInitial,
                    'value_stock_initial' => $valeurStockInitial,
                    'quantity_stockin' => $quantity[$count],
                    'value_stockin' => $cump * $quantity[$count],
                    'stock_total' => $quantityStockInitial + $quantity[$count],
                    'created_by' => $this->user->name,
                    'bon_entree' => $bon_no,
                    'created_at' => \Carbon\Carbon::now()
                );
                $report[] = $reportData;

                    $donnees = array(
                        'article_id' => $article_id[$count],
                        'quantity' => $quantity[$count],
                        'total_value' => $cump * $quantity[$count],
                        'created_by' => $this->user->name,
                    );
                    $stock[] = $donnees;


                    $sto = array(
                        'article_id' => $article_id[$count],
                        'quantity' => $valeurTotalUnite,
                        'total_value' => $cump * $quantity[$count],
                        'created_by' => $this->user->name,
                    );
                    $artic = Stock::where("article_id",$article_id[$count])->value('article_id');
                    if (!empty($artic)) {
                    Report::insert($report);
                    Stock::where('article_id',$article_id[$count])
                        ->update($sto);
                    }else{
                    Report::insert($report);
                    Stock::insert($stock);
                    }

                
            }

            

                

            
            //Stock::where('id',$article_id)
                   // ->update($data);

            StockinDetail::insert($insert_data);
            



            //create stockin
            $stockin = new Stockin();
            $stockin->date = $date;
            $stockin->bon_no = $bon_no;
            $stockin->origin = $origin;
            $stockin->handingover = $handingover;
            $stockin->supplier = $supplier;
            $stockin->created_by = $created_by;
            $stockin->observation = $observation;
            $stockin->save();

        session()->flash('success', 'Stockin has been created !!');
        return redirect()->route('admin.stockins.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($bon_no)
    {
        //
         $code = StockinDetail::where('bon_no', $bon_no)->value('bon_no');
         $stockins = StockinDetail::where('bon_no', $bon_no)->get();
         return view('backend.pages.stockin.show', compact('stockins','code'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($bon_no)
    {
        if (is_null($this->user) || !$this->user->can('stockin.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any stockin !');
        }

        $commands  = DB::table('supplier_requisitions')->whereNotIn('commande_no', function($q){
        $q->select('commande_no')->from('stockins');})->get();
        $suppliers  = Supplier::all();
        $stockin = Stockin::where('bon_no', $bon_no)->first();
        $stockinDetails = StockinDetail::where('bon_no' , $bon_no)->get();
        $articles  = Article::all();
        return view('backend.pages.stockin.edit', compact('stockin','stockinDetails', 'articles','commands','suppliers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $bon_no)
    {
        if (is_null($this->user) || !$this->user->can('stockin.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any stockin !');
        }

        // Create New Stockin
        
        //$stockinDetail = StockinDetail::where('bon_no', $bon_no)->first();

        $rules = array(
                'article_id.*'  => 'required',
                'date'  => 'required',
                'unit.*'  => 'required',
                'quantity.*'  => 'required',
                'total_value.*'  => 'required',
                'unit_price'  => 'required',
                //'invoice_no'  => 'required',
                //'commande_no'  => 'required',
                //'supplier'  => 'required',
                'origin'  => 'required',
                'handingover'  => 'required',
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
            $invoice_no = $request->invoice_no;
            $commande_no = $request->commande_no;
            $observation =$request->observation; 
            $supplier = $request->supplier;
            $unit = $request->unit;
            $quantity = $request->quantity;


            $unit_price = $request->unit_price;;
            //$total_value = 2000;
            $origin = $request->origin;
            $handingover =$request->handingover; 
            //$bon_no = "BE000".date("y").substr(number_format(time() * mt_rand(), 0, '', ''), 0, 6);
            $created_by = $this->user->name;

            //$article_id2 = Stock::where('article_id', $article_id)->get('article_id');


            for( $count = 0; $count < count($article_id); $count++ ){
                //$total_value = $quantity[$count] * $unit_price[$count];
                //$row = Incvoices::findOrFail($model["id"]);
                //$row->total = $model["total"];
                //$row->save();
                $data = array(
                    'article_id' => $article_id[$count],
                    'date' => $date,
                    'quantity' => $quantity[$count],
                    'unit' => $unit[$count],
                    'unit_price' => $unit_price[$count],
                    'total_value' => $quantity[$count] * $unit_price[$count],
                    'invoice_no' => $invoice_no,
                    'commande_no' => $commande_no,
                    'supplier' => $supplier,
                    'origin' => $origin,
                    'handingover' => $handingover,
                    //'bon_no' => $bon_no,
                    'created_by' => $created_by,
                    'observation' => $observation,
                );
               // $insert_data[] = $data;


                $valeurStockInitial = Stock::where('article_id', $article_id[$count])->value('total_value');
                $quantityStockInitial = Stock::where('article_id', $article_id[$count])->value('quantity');


                $valeurAcquisition = $quantity[$count] * $unit_price[$count];

                $valeurTotalUnite = $quantity[$count] + $quantityStockInitial;
                $cump = ($valeurStockInitial + $valeurAcquisition) / $valeurTotalUnite;

                $calcul_cump = array(
                        'unit_price' => $cump,
                    );
                

                $reportData = array(
                    'article_id' => $article_id[$count],
                    'quantity_stock_initial' => $quantityStockInitial,
                    'value_stock_initial' => $valeurStockInitial,
                    'quantity_stockin' => $quantity[$count],
                    'value_stockin' => $cump * $quantity[$count],
                    'stock_total' => $quantityStockInitial + $quantity[$count],
                    'created_by' => $this->user->name,
                    //'bon_entree' => $bon_no,
                    'created_at' => \Carbon\Carbon::now()
                );
                $report[] = $reportData;
                /*Report::where('article_id',$article_id[$count])
                        ->update($reportData); */

                    $donnees = array(
                        'article_id' => $article_id[$count],
                        'quantity' => $quantity[$count],
                        'total_value' => $cump * $quantity[$count],
                        'unit' => $unit[$count],
                        'created_by' => $this->user->name,
                        'verified' => false
                    );
                    $stock[] = $donnees;

                    $sto = array(
                        'article_id' => $article_id[$count],
                        'quantity' => $valeurTotalUnite,
                        'total_value' => $cump * $quantity[$count],
                        'unit' => $unit[$count],
                        'created_by' => $this->user->name,
                        'verified' => false
                    );
                    $artic = Stock::where("article_id",$article_id[$count])->value('article_id');
                    if (!empty($artic)) {
                    Report::where('article_id',$article_id[$count])
                        ->update($reportData);
                    Stock::where('article_id',$article_id[$count])
                        ->update($sto);
                    StockinDetail::where('article_id',$article_id[$count])
                        ->update($data);
                    Article::where('id',$article_id[$count])
                        ->update($calcul_cump);
                    }else{
                    StockinDetail::insert($insert_data);
                    Report::insert($report);
                    Stock::insert($stock);
                    Article::where('id',$article_id[$count])
                        ->update($calcul_cump);
                    }        
            }

            //StockinDetail::insert($insert_data);
            
            $stockin = Stockin::where('bon_no', $bon_no)->first();
            $stockin->date = $date;
            //$stockin->bon_no = $bon_no;
            $stockin->invoice_no = $invoice_no;
            $stockin->commande_no = $commande_no;
            $stockin->origin = $origin;
            $stockin->handingover = $handingover;
            $stockin->supplier = $supplier;
            $stockin->created_by = $created_by;
            $stockin->observation = $observation;
            $stockin->save();



        session()->flash('success', 'Stockin has been updated !!');
        return back();
    }

    public function bon_entree($numero)
    {
        if (is_null($this->user) || !$this->user->can('bon_entree.create')) {
            abort(403, 'Sorry !! You are Unauthorized!');
        }
        $setting = DB::table('settings')->orderBy('created_at','desc')->first();
        //$stockin = Stockin::find($invoice_no);
        $description = Stockin::where('bon_no', $numero)->value('observation');
        $code = Stockin::where('bon_no', $numero)->value('bon_no');
        $datas = StockinDetail::where('bon_no', $numero)->get();
        $remettant = Stockin::where('bon_no', $numero)->value('handingover');
        $gestionnaire = Stockin::where('bon_no', $numero)->value('created_by');
        $totalValue = DB::table('stockin_details')
            ->where('bon_no', '=', $numero)
            ->sum('total_value');
        $pdf = PDF::loadView('backend.pages.document.bon_entree',compact('datas','code','totalValue','remettant','gestionnaire','setting','description'));

        Storage::put('public/pdf/bon_entree/'.$numero.'.pdf', $pdf->output());

        // download pdf file
        return $pdf->download($numero.'.pdf');
    }

    public function get_stockin_data()
    {
        return Excel::download(new StockinExport, 'entrees.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($bon_no)
    {
        if (is_null($this->user) || !$this->user->can('stockin.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any stockin !');
        }

        $stockin = Stockin::where('bon_no',$bon_no)->first();
        if (!is_null($stockin)) {
            $stockin->delete();
            StockinDetail::where('bon_no',$bon_no)->delete();
            Report::where('bon_entree',$bon_no)->delete();
        }

        session()->flash('success', 'Stockin has been deleted !!');
        return back();
    }
}

