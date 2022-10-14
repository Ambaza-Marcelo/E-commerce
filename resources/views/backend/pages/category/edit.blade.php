
@extends('backend.layouts.master')

@section('title')
@lang('messages.emplacement_create') - @lang('messages.admin_panel')
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
                <h4 class="page-title pull-left">@lang('messages.emplacement_create') - {{ $emplacement->rayon }}</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">@lang('messages.dashboard')</a></li>
                    <li><a href="{{ route('admin.emplacements.index') }}">@lang('messages.list')</a></li>
                    <li><span>@lang('messages.emplacement_create')</span></li>
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
                    <h4 class="header-title">Edit Emplacement</h4>
                    @include('backend.layouts.partials.messages')
                    
                    <form action="{{ route('admin.emplacements.update', $emplacement->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="name">Rayon</label>
                            <input type="text" class="form-control" id="name" value="{{ $emplacement->rayon }}" name="rayon">
                        </div>

                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Update Emplacement</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- data table end -->
        
    </div>
</div>
@endsection
