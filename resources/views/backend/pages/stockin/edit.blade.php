
@extends('backend.layouts.master')

@section('title')
@lang('messages.stockin_edit') - @lang('messages.admin_panel')
@endsection

@section('styles')
<style>
    .form-check-label {
        text-transform: capitalize;
    }
</style>
@endsection


@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">@lang('messages.stockin_edit')</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">@lang('messages.dashboard')</a></li>
                    <li><a href="{{ route('admin.stockins.index') }}">@lang('messages.list')</a></li>
                    <li><span>@lang('messages.stockin_edit')</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>
<!-- page title area end -->

<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Edit Stockin</h4>
                    @include('backend.layouts.partials.messages')
                    
                    <form action="{{ route('admin.stockins.update', $stockin->bon_no) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="bon_no" value="{{ $stockin->bon_no }}">
                        <div class="row">
                        <div class="col-sm-6" id="dynamicDiv">
                            <input type="hidden" class="form-control" name="bon_no">
                        <div class="form-group">
                            <label for="date">Stockin Date</label>
                            <input type="date" class="form-control" id="date" name="date" value="{{ $stockin->date }}">
                        </div>
                        <div class="form-group">
                            <label for="handingover">Remettant</label>
                            <input type="text" class="form-control" id="handingover" name="handingover" placeholder="Entrer le nom du remettant" value="{{ $stockin->handingover }}">
                        </div>
                        </div>
                        <div class="col-sm-6" id="dynamicInvoice">
                        <div class="form-group">
                            <label for="origin">Origin</label>
                            <select class="form-control" name="origin" id="origin">
                                <option disabled="disabled" selected="selected">Select Origin</option>
                                <option value="local">Local</option>
                                <option value="national">National</option>
                                <option value="international">International</option>
                            </select>
                        </div>
                    </div>

                         <table class="table table-bordered" id="dynamicTable">  
                            <tr>
                                <th>Article</th>
                                <th>Quantity</th>
                                <th>Unit</th>
                                <th>Unit Price</th>
                            </tr>
                            @foreach($stockinDetails as $stockinDetail)
                            <tr>  
                                <td> <select class="form-control" name="article_id[]" id="article_id">
                                <option disabled="disabled" selected="selected">Select item</option>
                            @foreach ($articles as $article)
                                <option value="{{ $article->id }}" class="form-control" {{$stockinDetail->article_id == $article->id  ? 'selected' : ''}}>{{ $article->name }}/{{ $article->code }}/@if($article->status == 1)Usée @else Neuf @endif</option>
                            @endforeach
                            </select></td>  
                                <td><input type="number" name="quantity[]" value="{{$stockinDetail->quantity }}" class="form-control" /></td>  
                                <td><input type="text" name="unit[]" value="{{$stockinDetail->unit }}" class="form-control" /></td>
                                <td><input type="number" name="unit_price[]" value="{{$stockinDetail->unit_price }}" class="form-control" /></td> 
                                <td><button type="button" class="btn btn-danger remove-tr"><i class="fa fa-trash-o" aria-hidden="false"></i>&nbsp;Supprimer</button></td>  
                            </tr> 
                            @endforeach 
                        </table> 
                        <button type="button" name="add" id="add" class="btn btn-success">Add More</button>
                        <div class="col-lg-12">
                            <label for="observation">Stockin Observation</label>
                            <textarea class="form-control" name="observation" id="observation">
                                {{ $stockin->observation }}
                            </textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Update</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- data table end -->
        
    </div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript">
    var i = 0;
       
    $("#add").click(function(){
   
        ++i;

         var markup = "<tr>"+
                      "<td>"+
                         "<select class='form-control' name='article_id[]'"+
                            "<option value='0'>Select Item</option>"+
                             "@foreach($articles as $article)"+
                                 "<option value='{{ $article->id }}'>{{ $article->name }}/{{ $article->code }}/@if($article->status == 1)Usée @else Neuf @endif</option>"+
                             "@endforeach>"+
                          "</select>"+
                        "</td>"+
                        "<td>"+
                          "<input type='number' name='quantity[]' placeholder='Enter Quantity' class='form-control' />"+
                        "</td>"+
                        "<td>"+
                          "<input type='text' name='unit[]' placeholder='Enter Unit' class='form-control' />"+
                        "</td>"+
                        "<td>"+
                        "<input type='number' name='unit_price[]' placeholder='Enter Unit price' class='form-control' />"+
                        "</td>"+
                        "<td>"+
                          "<button type='button' class='btn btn-danger remove-tr'>Remove</button>"+
                        "</td>"+
                    "</tr>";
   
        $("#dynamicTable").append(markup);
    });
   
    $(document).on('click', '.remove-tr', function(){  
         $(this).parents('tr').remove();
    }); 


    $('#origin').change(function () { 
    if ($(this).val() === 'national'){
      var supplier = "<div class='form-group'>"+
                            "<label for='supplier'>Supplier</label>"+
                            "<select class='form-control' name='supplier' id='supplier'>"+
                                "<option disabled='disabled' selected='selected'>Select Supplier</option>"+
                                "@foreach($suppliers as $supplier)"+
                                "<option value='{{$supplier->name}}'>{{$supplier->name}}</option>"+
                                "@endforeach>"+
                            "</select>"+
                        "</div>";
        var invoice = "<div class='form-group'>"+
                            "<label for='invoice_no'>Invoice No</label>"+
                            "<input type='text' class='form-control' id='invoice_no' name='invoice_no' placeholder='Enter invoice no'>"+
                        "</div>";
        var bon_commande = "<div class='form-group'>"+
                            "<label for='commande_no'>Bon Commande No.</label>"+
                            "<select class='form-control' name='commande_no' id='commande_no'>"+
                                "<option disabled='disabled' selected='selected'>Select Bon Commande No.</option>"+
                                "@foreach($commands as $command)"+
                                "<option value='{{$command->commande_no}}'>{{$command->commande_no}}</option>"+
                                "@endforeach>"+
                            "</select>"+
                        "</div>";
        $("#dynamicDiv").append(supplier);
        $("#dynamicInvoice").append(invoice,bon_commande);
    }
    if ($(this).val() === 'international'){
      var supplier = "<div class='form-group'>"+
                            "<label for='supplier'>Supplier</label>"+
                            "<select class='form-control' name='supplier' id='supplier'>"+
                                "<option disabled='disabled' selected='selected'>Select Supplier</option>"+
                                "@foreach($suppliers as $supplier)"+
                                "<option value='{{$supplier->name}}'>{{$supplier->name}}</option>"+
                                "@endforeach>"+
                            "</select>"+
                        "</div>";
        var invoice = "<div class='form-group'>"+
                            "<label for='invoice_no'>Invoice No</label>"+
                            "<input type='text' class='form-control' id='invoice_no' name='invoice_no' placeholder='Enter invoice no'>"+
                        "</div>";
        var bon_commande = "<div class='form-group'>"+
                            "<label for='commande_no'>Bon Commande No.</label>"+
                            "<select class='form-control' name='commande_no' id='commande_no'>"+
                                "<option disabled='disabled' selected='selected'>Select Bon Commande No.</option>"+
                                "@foreach($commands as $command)"+
                                "<option value='{{$command->commande_no}}'>{{$command->commande_no}}</option>"+
                                "@endforeach>"+
                            "</select>"+
                        "</div>";
        var country =   "<div class='form-group'>"+
                            "<label for='country'>Country</label>"+
                            "<input type='text' class='form-control' id='country' name='country' placeholder='Enter invoice no'>"+
                        "</div>";
        $("#dynamicDiv").append(supplier);
        $("#dynamicInvoice").append(invoice,bon_commande,country);
    }
    })
    .trigger( "change" );

    $('#type').change(function () { 
    if ($(this).val() == '1'){
        $("#rest_quantity").hide();
    }
    if ($(this).val() == '2'){
        $("#rest_quantity").show();
    }
    })
    .trigger( "change" );

</script>
@endsection
