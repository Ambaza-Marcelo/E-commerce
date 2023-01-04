
@extends('backend.layouts.master')

@section('title')
@lang('messages.stockin') - @lang('messages.admin_panel')
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
                <h4 class="page-title pull-left">@lang('messages.stockin')</h4>
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
                    <h4 class="header-title float-left">Stockin List</h4>
                    <p class="float-right mb-2">
                        <!-- create new if authorized -->
                        @if (Auth::guard('admin')->user()->can('stockin.create'))
                            <a class="btn btn-success text-white" href="{{ route('admin.stockin.export') }}" title="Exporter en Excel"><i class="fa fa-file-excel-o"></i>&nbsp;Export</a>
                            <a class="btn btn-primary text-white" href="{{ route('admin.stockins.create') }}">Create New</a>
                        @endif
                    </p>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="dataTable" class="text-center">
                            <!-- data table header-->
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="10%">Date</th>
                                    <th width="10%">Bon No</th>
                                    <th width="10%">Origin</th>
                                    <th width="10%">Remettant</th>
                                    <th width="10%">Created By</th>
                                    <th width="20%">Observation</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <!-- datatable body -->
                            <tbody>
                               @foreach ($stockins as $stockin)
                               <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $stockin->date }}</td>
                                    <td><a href="{{ route('admin.stockins.show',$stockin->bon_no)}}">{{ $stockin->bon_no }}</a></td>
                                    <td>{{ $stockin->origin }}</td>
                                    <td>{{ $stockin->handingover }}</td>
                                    <td>{{ $stockin->created_by }}</td>
                                    <td>{{ $stockin->observation }}</td>
                                    <td>
                                        <a class="btn btn-primary text-white" href="{{ route('admin.stockins.show',$stockin->bon_no) }}">
                                                Afficher
                                            </a>
                                            <!-- edit if authorized user -->
                                        @if (Auth::guard('admin')->user()->can('stockin.edit'))
                                            <a class="btn btn-success text-white" href="{{ route('admin.stockins.edit', $stockin->bon_no) }}">Edit</a>
                                        @endif
                                        <!-- destroy if authorized user -->
                                        @if (Auth::guard('admin')->user()->can('stockin.delete'))
                                            <a class="btn btn-danger text-white" href="{{ route('admin.stockins.destroy', $stockin->bon_no) }}"
                                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $stockin->bon_no }}').submit();">
                                                Delete
                                            </a>

                                            <form id="delete-form-{{ $stockin->bon_no }}" action="{{ route('admin.stockins.destroy', $stockin->bon_no) }}" method="POST" style="display: none;">
                                                @method('DELETE')
                                                @csrf
                                            </form>
                                        @endif
                                        @if (Auth::guard('admin')->user()->can('stockin.create'))
                                        <a class="btn btn-success" href="{{ route('admin.stockin.bon_entree',$stockin->bon_no) }}">Imprimer</a>
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