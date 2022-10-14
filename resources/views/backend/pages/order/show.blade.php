
@extends('backend.layouts.master')

@section('title')
@lang('messages.supplier_requisitions') - @lang('messages.admin_panel')
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
                <h4 class="page-title pull-left">@lang('messages.orders')</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">@lang('messages.dashboard')</a></li>
                    <li><span>@lang('messages.list')</span></li>
                </ul>
            </div>
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
                    <h4 class="header-title float-left">Liste des détails sur la commande No : {{ $code }}</h4>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="10%">Date</th>
                                    <th width="10%">Commande No</th>
                                    <th width="10%">Bon D.A No</th>
                                    <th width="10%">Name</th>
                                    <th width="10%">Phone No</th>
                                    <th width="10%">Start Date</th>
                                    <th width="10%">End Date</th>                                   
                                    <th width="10%">Status</th>
                                    <th width="30%">description</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($orders as $order)
                               <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $order->date }}</td>
                                    <td>{{ $order->commande_no }}</td>
                                    <td><a href="{{ route('admin.purchase.show',$order->purchase_bon_no)}}">{{ $order->purchase_bon_no }}</a></td>
                                    <td>{{ $order->supplier->name }}</td>
                                    <td>{{ $order->supplier->phone_no }}</td>
                                    <td>{{ $order->start_date }}</td>
                                    <td>{{ $order->end_date }}</td>
                                    @if($order->status == 2)
                                    <td><span  class="alert alert-success">Validée</span></td>
                                    @elseif($order->status == -1)
                                    <td><span class="alert alert-danger">Rejetée</span></td>
                                    @elseif($order->status == 3)
                                    <td><span class="alert alert-success">confirmée</span></td>
                                    @elseif($order->status == 4)
                                    <td><span class="alert alert-success">Approuvée</span></td>
                                    @elseif($order->status == 5)
                                    <td><span class="alert alert-success">Receptionnée</span></td>
                                    @else
                                    <td><span class="alert alert-primary">Encours...</span></td>
                                    @endif
                                    <td>{{ $order->description }}</td>
                                    <td>
                                        
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