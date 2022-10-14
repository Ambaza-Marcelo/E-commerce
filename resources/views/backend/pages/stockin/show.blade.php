
@extends('backend.layouts.master')

@section('title')
@lang('details des entrees') - @lang('messages.admin_panel')
@endsection

@section('styles')
    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
@endsection

@section('admin-content')
<div class="main-content-inner">
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title float-left">Details des entrées sur bon d'entree No : {{ $code }}</h4>
                    <div class="clearfix"></div>
                    <div class="data-tables">
                        @include('backend.layouts.partials.messages')
                        <table id="dataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="10%">Date</th>
                                    <th width="10%">Bon No</th>
                                    <th width="10%">Article Name</th>
                                    <th width="10%">Specification</th>
                                    <th width="10%">Quantity</th>
                                    <th width="10%">Origin</th>
                                    <th width="10%">Status</th>
                                    <th width="10%">unit price</th>
                                    <th width="10%">Supplier</th>
                                    <th width="10%">Total Value</th>
                                    <th width="10%">Remettant</th>
                                    <th width="10%">Created By</th>
                                    <th width="20%">Observation</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach ($stockins as $stockin)
                               <tr>
                                    <td>{{ $loop->index+1 }}</td>
                                    <td>{{ $stockin->date }}</td>
                                    <td>{{ $stockin->bon_no }}</td>
                                    <td>{{ $stockin->article->name }}</td>
                                    <td>{{ $stockin->article->specification }}</td>
                                    <td>{{ $stockin->quantity }}</td>
                                    <td>{{ $stockin->origin }}</td>
                                    @if($stockin->article->status  == 1)
                                    <td>Usée</td>
                                    @else
                                    <td>Neuf</td>
                                    @endif
                                    <td>{{ number_format($stockin->unit_price,0,',','.' ) }} fbu</td>
                                    <td><a href="@if($stockin->commande_no){{ route('admin.orders.show',$stockin->commande_no)}} @endif">{{ $stockin->commande_no }}</a></td>
                                    <td>{{ number_format($stockin->total_value,0,',','.' ) }} FBU</td>
                                    <td>{{ $stockin->handingover }}</td>
                                    <td>{{ $stockin->created_by }}</td>
                                    <td>{{ $stockin->observation }}</td>
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