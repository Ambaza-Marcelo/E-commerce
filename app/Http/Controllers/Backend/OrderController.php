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
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Supplier;
use App\Models\Order;
use App\Models\Article;
use Validator;
use PDF;
use Mail;
use App\Mail\OrderMail;
class OrderController extends Controller
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
        if (is_null($this->user) || !$this->user->can('order.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any order !');
        }

        $orders = Order::all();
        return view('backend.pages.order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $articles = Article::all();
        return view('backend.pages.order.create', compact('articles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = array(
                'article_id'  => 'required',
                'email'  => 'required'
            );

            $error = Validator::make($request->all(),$rules);

            if($error->fails()){
                return response()->json([
                    'error' => $error->errors()->all(),
                ]);
            }

            $email = $request->email;
            $article_id = $request->article_id;

            $name = Article::where('id',$article_id)->value('name');

            $mailData = [
                    'title' => 'COMMANDE',
                    'name' => $name,
                    'email' => $email,
                    ];
         
        Mail::to($email)->send(new OrderMail($mailData));

        return redirect()->route('welcome');
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
         $code = Order::where('commande_no', $bon_no)->value('commande_no');
         $orders = Order::where('commande_no', $bon_no)->get();
         return view('backend.pages.order.show', compact('orders','code'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('order.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any order !');
        }

        $order = Order::find($id);
        $purchases = DB::table('purchases')->select('bon_no')->distinct()->get();
        $suppliers  = Supplier::all();
        $addresses = Address::all();
        return view('backend.pages.order.edit', compact('order', 'purchases','suppliers','addresses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('order.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to edit any order !');
        }

        // update Order
        $order = Order::find($id);

        // Validation Data
        $request->validate([
            'supplier_id'  => 'required',
            'date'  => 'required',
            'purchase_bon_no'  => 'required',
            'start_date'  => 'required',
            'end_date'  => 'required|after:start_date',
            'description'  => 'required'
        ]);

        $order->supplier_id = $request->supplier_id;
        $order->date = $request->date;
        $order->purchase_bon_no = $request->purchase_bon_no;
        $order->start_date = $request->start_date;
        $order->end_date = $request->end_date;
        $order->description =$request->description; 
        $order->created_by = $this->user->name;
        $order->save();

        session()->flash('success', 'order has been updated !!');
        return back();
    }

    public function validateCommand($bon_no)
    {
       if (is_null($this->user) || !$this->user->can('order.validate')) {
            abort(403, 'Sorry !! You are Unauthorized to validate any order !');
        }
            Order::where('purchase_bon_no', '=', $bon_no)
                ->update(['status' => 2]);

        session()->flash('success', 'order has been validated !!');
        return back();
    }

    public function reject($bon_no)
    {
       if (is_null($this->user) || !$this->user->can('order.reject')) {
            abort(403, 'Sorry !! You are Unauthorized to reject any order !');
        }

        Order::where('purchase_bon_no', '=', $bon_no)
                ->update(['status' => -1]);

        session()->flash('success', 'Order has been rejected !!');
        return back();
    }

    public function reset($bon_no)
    {
       if (is_null($this->user) || !$this->user->can('order.reset')) {
            abort(403, 'Sorry !! You are Unauthorized to reset any order !');
        }

        Order::where('purchase_bon_no', '=', $bon_no)
                ->update(['status' => 1]);

        session()->flash('success', 'Order has been reseted !!');
        return back();
    }

    public function confirm($bon_no)
    {
       if (is_null($this->user) || !$this->user->can('order.confirm')) {
            abort(403, 'Sorry !! You are Unauthorized to confirm any order !');
        }

        Order::where('purchase_bon_no', '=', $bon_no)
                ->update(['status' => 3]);

        session()->flash('success', 'Order has been confirmed !!');
        return back();
    }

    public function sendmail(Request $request){
        $data["email"]=$request->get("email");
        $data["client_name"]=$request->get("client_name");
        $data["subject"]=$request->get("subject");
 
        $pdf = PDF::loadView('test', $data);
 
        try{
            Mail::send('mails.mail', $data, function($message)use($data,$pdf) {
            $message->to($data["email"], $data["client_name"])
            ->subject($data["subject"])
            ->attachData($pdf->output(), "test.pdf");
            });
        }catch(JWTException $exception){
            $this->serverstatuscode = "0";
            $this->serverstatusdes = $exception->getMessage();
        }
        if (Mail::failures()) {
             $this->statusdesc  =   "Error sending mail";
             $this->statuscode  =   "0";
 
        }else{
 
           $this->statusdesc  =   "Message sent Succesfully";
           $this->statuscode  =   "1";
        }
        return response()->json(compact('this'));
    }

    public function approuve($bon_no)
    {
       if (is_null($this->user) || !$this->user->can('order.approuve')) {
            abort(403, 'Sorry !! You are Unauthorized to confirm any order !');
        }

        Order::where('purchase_bon_no', '=', $bon_no)
                ->update(['status' => 4]);

        session()->flash('success', 'Order has been confirmed !!');
        return back();
    }

    public function reception($bon_no)
    {
       if (is_null($this->user) || !$this->user->can('order.reception')) {
            abort(403, 'Sorry !! You are Unauthorized to take any order !');
        }

        Order::where('purchase_bon_no', '=', $bon_no)
                ->update(['status' => 5]);

        session()->flash('success', 'Order has been arrived !!');
        return back();
    }

    public function htmlPdf($bon_no)
    {
        if (is_null($this->user) || !$this->user->can('bon_commande.create')) {
            abort(403, 'Sorry !! You are Unauthorized!');
        }
        //$nbr = count(PurchaseDetail::where('bon_no',$bon_no)->get());
        $setting = DB::table('settings')->orderBy('created_at','desc')->first();
        $stat = Order::where('commande_no', $bon_no)->value('status');
        $description = Order::where('commande_no', $bon_no)->value('description');
        $purchase_bon = Order::where('commande_no', $bon_no)->value('purchase_bon_no');
        if($stat == 2 && $stat == 3 || $stat == 4){
           $code = Order::where('commande_no', $bon_no)->value('commande_no');
           $cheflogistique = Order::where('commande_no', $bon_no)->value('created_by');
           $datas = PurchaseDetail::where('bon_no', $purchase_bon)->get();
           $pdf = PDF::loadView('backend.pages.document.bon_commande',compact('datas','code','setting','cheflogistique','description','purchase_bon'));

           Storage::put('public/pdf/bon_commande/'.$bon_no.'.pdf', $pdf->output());

           // download pdf file
           return $pdf->download($bon_no.'.pdf'); 
           
        }else if ($stat == -1) {
            session()->flash('error', 'Order has been rejected !!');
            return back();
        }else{
            session()->flash('error', 'wait until order will be validated !!');
            return back();
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (is_null($this->user) || !$this->user->can('order.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any order !');
        }

        $order = Order::find($id);
        if (!is_null($order)) {
            $order->delete();
        }

        session()->flash('success', 'Order has been deleted !!');
        return back();
    }
}
