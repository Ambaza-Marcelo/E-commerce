
@extends('backend.layouts.master')

@section('title')
@lang('messages.article_create') - @lang('messages.admin_panel')
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
                <h4 class="page-title pull-left">@lang('messages.article_create')</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">@lang('messages.dashboard')</a></li>
                    <li><a href="{{ route('admin.articles.index') }}">@lang('messages.list')</a></li>
                    <li><span>@lang('messages.article_create')</span></li>
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
            <div class="row">
                <div class="col-sm-12">   
                    <form action="{{ route('admin.categories.store') }}" method="POST">
                        @csrf
                        <table class="table table-bordered" id="dynamicTable">  
                            <tr class="bg-secondary">
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                            <tr class="bg-warning">    
                                <td><input type="text" class="form-control" id="name" name="name" placeholder="Entrer Category"></td>   
                                <td><button type="submit" class="btn btn-primary">Save</button></td>  
                            </tr>  
                        </table> 
                    </form>
                </div>
            </div>
        </div>
        <!-- data table end -->
        
    </div>
</div>

<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body bg-warning">
                    <h4 class="header-title">Create New </h4>
                    @include('backend.layouts.partials.messages')
                    
                    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                        <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter Quantity">
                        </div>
                        <div class="form-group">
                            <label for="unit_price">Unit Price</label>
                            <input type="number" class="form-control" id="unit_price" name="unit_price" placeholder="Enter Unit Price">
                        </div>
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select class="form-control" name="category_id" id="category_id">
                                <option disabled="disabled" selected="selected">Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        </div>
                        <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Specification</label>
                            <input type="text" class="form-control" id="specification" name="specification" placeholder="Enter Specification">
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" name="status" id="status">
                                <option disabled="disabled" selected="selected">merci de choisir</option>
                                <option value="0">....</option>
                                <option value="1">Occasion</option>
                                <option value="2">Neuve</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="expiration_date">Date Expiration</label>
                            <input type="date" class="form-control" id="expiration_date" name="expiration_date">
                        </div>
                        <div class="form-group">
                            <label for="threshold_quantity">threshold quantit</label>
                            <input type="number" class="form-control" id="threshold_quantity" name="threshold_quantity" placeholder="Enter threshold quantity">
                        </div>
                        </div>
                        <div class="col-sm-12">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                    </div>
                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- data table end -->
        
    </div>
</div>
@endsection
