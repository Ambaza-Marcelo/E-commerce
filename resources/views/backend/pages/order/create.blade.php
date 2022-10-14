
@extends('backend.layouts.master')

@section('title')
@lang('commande') - @lang('messages.admin_panel')
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
                <h4 class="page-title pull-left">@lang('commande')</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">@lang('messages.dashboard')</a></li>
                    <li><a href="{{ route('admin.orders.index') }}">@lang('messages.list')</a></li>
                    <li><span>@lang('commande')</span></li>
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
                    <h4 class="header-title">Create Order</h4>
                    @include('backend.layouts.partials.messages')
                    
                    <form action="{{ route('admin.orders.store') }}" method="POST">
                        @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="hidden" class="form-control" name="bon_no">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date">
                        </div>
                        </div>
                        <div class="col-sm-6">
                        <div class="form-group">
                            <label for="supplier_id">Supplier</label>
                            <select class="form-control" name="supplier_id">
                                <option disabled="disabled" selected="selected">select supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}/{{ $supplier->phone_no }}</option>
                            @endforeach
                            </select>
                        </div>
                        </div>
                    </div>
                         <table class="table table-bordered" id="dynamicTable">  
                            <tr class="bg-secondary">
                                <th>Bon Achat</th>
                                <th>date debut</th>
                                <th>date fin</th>
                                <th>Action</th>
                            </tr>
                            <tr class="bg-warning">  
                                <td><select id="purchase_bon_no" class="form-control" name="purchase_bon_no[]">
                                <option disabled="disabled" selected="selected">selectionner bon achat</option>
                            @foreach ($purchases as $purchase)
                                <option value="{{ $purchase->bon_no }}">{{ $purchase->bon_no }}</option>
                            @endforeach
                            </select></td>  
                                <td><input type="date" name="start_date[]" class="form-control" /></td>  
                                <td><input type="date" name="end_date[]" class="form-control" /></td>    
                                <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>  
                            </tr>  
                        </table> 
                        <div class="col-lg-12">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="description" placeholder="Enter Description">
                                
                            </textarea>
                        </div>
                        <div style="margin-top: 15px;margin-left: 15px;">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript">
    var i = 0;
       
    $("#add").click(function(){
   
        ++i;

         var markup = "<tr class='bg-warning'>"+
                      "<td>"+
                         "<select class='form-control' name='purchase_bon_no[]'"+
                            "<option disabled='disabled' selected='selected'>Selectionner bon Achat</option>"+
                             "@foreach ($purchases as $purchase)"+
                                 "<option value='{{ $purchase->bon_no }}'>{{ $purchase->bon_no }}</option>"+
                             "@endforeach>"+
                          "</select>"+
                        "</td>"+
                        "<td>"+
                          "<input type='date' name='start_date[]' class='form-control' />"+
                        "</td>"+
                        "<td>"+
                          "<input type='date' name='end_date[]' class='form-control' />"+
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

</script>
@endsection
