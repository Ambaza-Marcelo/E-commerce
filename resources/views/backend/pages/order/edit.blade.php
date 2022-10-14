
@extends('backend.layouts.master')

@section('title')
@lang('modifier commande') - @lang('messages.admin_panel')
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
                <h4 class="page-title pull-left">@lang('modifier commande')</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">@lang('messages.dashboard')</a></li>
                    <li><a href="{{ route('admin.orders.index') }}">@lang('messages.list')</a></li>
                    <li><span>@lang('commandes')</span></li>
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
                    <h4 class="header-title">Modifier commande</h4>
                    @include('backend.layouts.partials.messages')
                    
                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        
                        <div class="row">
                        <div class="col-sm-6">
                            <input type="hidden" class="form-control" name="bon_no">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date" value="{{$order->date}}">
                        </div>
                        </div>
                        <div class="col-sm-6">
                        <div class="form-group">
                            <label for="supplier_id">Supplier</label>
                            <select class="form-control" name="supplier_id">
                                <option disabled="disabled" selected="selected">select supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{$order->supplier_id == $supplier->id  ? 'selected' : ''}}>{{ $supplier->name }}/{{ $supplier->phone_no }}</option>
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
                            </tr>
                            <tr class="bg-warning">  
                                <td><select id="purchase_bon_no" class="form-control" name="purchase_bon_no">
                                <option disabled="disabled" selected="selected">selectionner bon achat</option>
                            @foreach ($purchases as $purchase)
                                <option value="{{ $purchase->bon_no }}" {{$order->requisition_bon_no == $purchase->bon_no  ? 'selected' : ''}}>{{ $purchase->bon_no }}</option>
                            @endforeach
                            </select></td>  
                                <td><input type="date" name="start_date" class="form-control" value="{{ $order->start_date }}" /></td>  
                                <td><input type="date" name="end_date" class="form-control" value="{{ $order->end_date }}" /></td>     
                            </tr>  
                        </table> 
                        <div class="col-lg-12">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="description" placeholder="Enter Description">
                                {{ $order->description }}
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
@endsection
