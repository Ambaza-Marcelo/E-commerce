
@extends('backend.layouts.master')

@section('title')
@lang('messages.report_day') - @lang('messages.admin_panel')
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
                <h4 class="page-title pull-left">@lang('messages.report_day')</h4>
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
                    <h4 class="header-title float-left">Day report</h4>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="10%">Date</th>
                                    <th width="10%">Article</th> 
                                    <th width="10%">Q.S.Initial</th>
                                    <th width="10%">Q. Entree</th>
                                    <th width="10%">Stock Total</th>
                                    <th width="10%">Q. Sortie</th>
                                    <th width="10%">Bon Entrée</th>
                                    <th width="10%">Bon Sortie</th>
                                    <th width="10%">Auteur</th> 
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($reportDays as $reportDay)
                               <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $reportDay->day }}/{{ $reportDay->month }}/{{ $reportDay->year }}</td>
                                    <td>{{ $reportDay->article->name }}/{{ $reportDay->article->specification }}</td>
                                    <td>{{ $reportDay->q_stock_ini }}</td>
                                    <td>{{ $reportDay->q_stockin }}</td>
                                    <td>{{ $reportDay->q_tot_stock }}</td>
                                    <td>{{ $reportDay->q_stockout }}</td>
                                    <td><a href="@if($reportDay->bon_entree){{ route('admin.stockins.show',$reportDay->bon_entree)}} @endif">{{ $reportDay->bon_entree }}</a></td>
                                    <td><a href="@if($reportDay->bon_sortie){{ route('admin.stockouts.show',$reportDay->bon_sortie)}} @endif">{{ $reportDay->bon_sortie }}</a></td>
                                    <td>{{ $reportDay->created_by }}</td>
                                    <td>
                                       <!-- <a class="btn btn-info text-white" href="">Rapport</a> -->
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