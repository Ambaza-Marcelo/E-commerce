
@extends('backend.layouts.master')

@section('title')
@lang('messages.dashboard') - @lang('messages.admin_panel')
@endsection


@section('admin-content')

<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">@lang('messages.dashboard')</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{url('/404/muradutunge/ivyomwasavye-ntibishoboye-kuboneka')}}">@lang('messages.home')</a></li>
                    <li><span>@lang('messages.dashboard')</span></li>
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
    <div class="col-md-2" id="side-navbar">
    </div>
    <div class="col-lg-12">
        
        <div class="row">
        <div class="col-md-8 offset-md-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <canvas id="canvas" height="280" width="500"></canvas>
                </div>
            </div>
        </div>
    </div>
    <br><br>


        <div class="row">
            <div class="col-md-6 mt-5 mb-3">
                <div class="card">
                    <div class="seo-fact sbg1">
                        <a href="{{ route('admin.roles.index') }}">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon"><i class="fa fa-users"></i> @lang('messages.roles')</div>
                                <h2>{!! QrCode::size(100)->backgroundColor(255,255,255)->generate('Le nombre de roles : '.$total_roles.' ,Designed by Marcellin' ) !!}
                                </h2>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-md-5 mb-3">
                <div class="card">
                    <div class="seo-fact sbg2">
                       <a href="{{ route('admin.admins.index') }}"> 
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon"><i class="fa fa-user"></i> @lang('messages.users')</div>
                                <h2>{!! QrCode::size(100)->backgroundColor(255,255,255)->generate('Le nombre des utilisateurs : '.$total_admins.' ,Designed by Marcellin' ) !!}
                                </h2>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3 mb-lg-0">
                <div class="card">
                    <div class="seo-fact sbg3">
                        <a href="{{ route('admin.articles.index')}}">
                        <div class="p-4 d-flex justify-content-between align-items-center">
                            <div class="seofct-icon"><i class="fa fa-shopping-basket"></i>@lang('messages.article')</div>
                            <h2>{!! QrCode::size(100)->backgroundColor(255,255,255)->generate('Nombre des produits : '.$total_article.', Designed by Marcellin' ) !!}
                            </h2>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3 mb-lg-0">
                <div class="card">
                    <div class="seo-fact sbg4">
                        <a href="{{ route('admin.stock-status.index')}}">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon"><i class="fa fa-shopping-bag"></i>@lang('messages.customer')</div>
                                <h2>
                                    {!! QrCode::size(100)->backgroundColor(255,255,255)->generate('Nombre Clients : 0 ,Designed by Marcellin' ) !!}
                                </h2>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6 mb-3 mb-lg-0">
                <div class="card">
                    <div class="seo-fact sbg5">
                        <a href="">
                        <div class="p-4 d-flex justify-content-between align-items-center">
                            <div class="seofct-icon"><i class="fa fa-shopping-basket"></i>@lang('messages.order')</div>
                            <h2>{!! QrCode::size(100)->backgroundColor(255,255,255)->generate('Nombre de commandes : 0 , Designed by Marcellin' ) !!}
                            </h2>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3 mb-lg-0">
                <div class="card">
                    <div class="seo-fact sbg6">
                        <a href="{{ route('admin.stock-status.index')}}">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon"><i class="fa fa-shopping-bag"></i>@lang('messages.stock')</div>
                                <h2>
                                    {!! QrCode::size(100)->backgroundColor(255,255,255)->generate('Quantite totale du stock : '.$quantityTot_stock.' ,Marcellin' ) !!}
                                </h2>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6 mb-3 mb-lg-0">
                <div class="card">
                    <div class="seo-fact sbg7">
                        <a href="{{ route('admin.sales.index')}}">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon"><i class="fa fa-industry"></i> @lang('messages.sale')</div>
                                <h2>{!! QrCode::size(100)->backgroundColor(255,255,255)->generate('Designed by Marcellin' ) !!}</h2>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3 mb-lg-0">
                <div class="card">
                    <div class="seo-fact sbg8">
                        <a href="{{ route('admin.stockins.index')}}">
                            <div class="p-4 d-flex justify-content-between align-items-center">
                                <div class="seofct-icon"><i class="fa fa-shopping-bag"></i>@lang('messages.stockin')</div>
                                <h2>
                                    {!! QrCode::size(100)->backgroundColor(255,255,255)->generate('Quantite totale entree : '.$quantityTot_stockin.' ,Marcellin' ) !!}
                                </h2>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <br>
        </div>
    </div>
  </div>
  <!-- ambaza marcellin -pink -->
</div>
<script type="text/javascript">
    var year = <?php echo $year; ?>;
    var stockout = <?php echo $stockout; ?>;
    var stockin = <?php echo $stockin; ?>;
    var barChartData = {
        labels: year,
        datasets: [
        {
            label: 'Entrée',
            backgroundColor: "green",
            data: stockin
        },
        {
            label: 'Ventes',
            backgroundColor: "pink",
            data: stockout
        }

        ]
    };

    window.onload = function() {
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myBar = new Chart(ctx, {
            type: 'bar',
            data: barChartData,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: '#c1c1c1',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,
                title: {
                    display: true,  
                    text: 'les statistiques des entrées et ventes'
                }
            }
        });
    };
</script>
@endsection