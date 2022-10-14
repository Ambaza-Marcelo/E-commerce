
@extends('backend.layouts.master')

@section('title')
@lang('messages.sales') - @lang('messages.admin_panel')
@endsection

@section('styles')
    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
@endsection


@section('admin-content')

<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">@lang('messages.sales')</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">@lang('messages.dashboard')</a></li>
                    <li><span>@lang('messages.list')</span></li>
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
                    <h4 class="header-title float-left">sales List</h4>
                    <p class="float-right mb-2">
                        @if (Auth::guard('admin')->user()->can('sales.create'))
                            <a class="btn btn-primary text-white" href="{{ route('admin.sales.create') }}" title="vente">Create New</a>
                        @endif
                    </p>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="10%">Bon No</th>
                                    <th width="10%">Date</th>
                                    <th width="10%">No Commande</th>
                                    <th width="10%">Customer</th>
                                    <th width="10%">created by</th>
                                    <th width="20%">Observation</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($sales as $sale)
                               <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td><a href="@if($sale->bon_no){{ route('admin.sales.show',$sale->bon_no)}} @endif">{{ $sale->bon_no }} </a></td>
                                    <td>{{ $sale->date }}</td>
                                    <td>{{ $sale->commande_no }}</td>
                                    <td>{{ $sale->customer }}</td>
                                    <td>{{ $sale->created_by }}</td>
                                    <td>{{ $sale->observation }}</td>
                                    <td>
                                        @if (Auth::guard('admin')->user()->can('sales.edit'))
                                            <a class="btn btn-success text-white" href="{{ route('admin.sales.edit', $sale->bon_no) }}">Edit</a>
                                        @endif

                                        @if (Auth::guard('admin')->user()->can('sales.edit'))
                                            <a class="btn btn-danger text-white" href="{{ route('admin.sales.destroy', $sale->bon_no) }}" 
                                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $sale->bon_no }}').submit();"  onclick="return confirm('Etes-vous d\'accord pour supprimer le facture : {{$sale->bon_no}}?');" >
                                                Delete
                                            </a>

                                            <form id="delete-form-{{ $sale->bon_no }}" action="{{ route('admin.sales.destroy', $sale->bon_no) }}" method="POST" style="display: none;">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                        @endif
                                        @if (Auth::guard('admin')->user()->can('sales.create'))
                                        <a class="btn btn-primary" href="{{ route('admin.sales.bon_sortie',$sale->bon_no) }}">Imprimer</a>
                                        @endif
                                    </td>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->
        
    </div>
</div>
@endsection


@section('scripts')
     <!-- Start datatable js -->
     <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
     <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
     <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
     <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
     <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>


     <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
     
     <script>
         /*================================
        datatable active
        ==================================*/
        if ($('#dataTable').length) {
            $('#dataTable').DataTable({
                responsive: true
            });
        }

     </script>
@endsection