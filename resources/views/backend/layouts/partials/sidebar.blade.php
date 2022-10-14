 <!-- sidebar menu area start -->
 @php
     $usr = Auth::guard('admin')->user();
 @endphp
 <div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <a href="{{ route('admin.dashboard') }}">
                <h2 class="text-white">EXAMEN</h2> 
            </a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">

                    @if ($usr->can('dashboard.view'))
                    <li class="active">
                        <a href="{{ route('admin.dashboard') }}" aria-expanded="true"><i class="ti-dashboard"></i><span>@lang('messages.dashboard')</span></a>
                    </li>
                    @endif
                    
                    @if ($usr->can('admin.create') || $usr->can('admin.view') ||  $usr->can('admin.edit') ||  $usr->can('admin.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-user"></i><span>
                            @lang('messages.users')
                        </span></a>
                        <ul class="collapse {{ Route::is('admin.admins.create') || Route::is('admin.admins.index') || Route::is('admin.admins.edit') || Route::is('admin.admins.show') ? 'in' : '' }}">
                            
                            @if ($usr->can('admin.view'))
                                <li class="{{ Route::is('admin.admins.index')  || Route::is('admin.admins.edit') ? 'active' : '' }}"><a href="{{ route('admin.admins.index') }}"><i class="fa fa-user"></i>&nbsp;@lang('messages.users')</a></li>
                            @endif
                            @if ($usr->can('role.view'))
                                <li class="{{ Route::is('admin.roles.index')  || Route::is('admin.roles.edit') ? 'active' : '' }}"><a href="{{ route('admin.roles.index') }}"><i class="fa fa-tasks"></i> &nbsp;@lang('messages.roles') & @lang('messages.permissions')</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    @if ($usr->can('stockin.create') || $usr->can('stockin.view') ||  $usr->can('stockin.edit') ||  $usr->can('stockin.delete') || $usr->can('sales.create') || $usr->can('sales.view') ||  $usr->can('sales.edit') ||  $usr->can('sales.delete') || $usr->can('article.create') || $usr->can('article.view') ||  $usr->can('article.edit') ||  $usr->can('article.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-shopping-basket"></i><span>
                            @lang('messages.stock')
                        </span></a>
                        <ul class="collapse">
                                @if ($usr->can('article.view'))
                                <li class=""><a href="{{ route('admin.articles.index') }}"><i class="fa fa-rebel"></i>&nbsp;@lang('messages.article')</a></li>
                                @endif
                                @if ($usr->can('stockin.view'))
                                <li class=""><a href="{{ route('admin.stockins.index') }}"><i class="fa fa-battery-three-quarters"></i>&nbsp;@lang('messages.stockin')</a></li>
                                @endif
                                @if ($usr->can('sales.view'))
                                <li class=""><a href="{{ route('admin.sales.index') }}"><i class="fa fa-battery-half"></i>&nbsp;@lang('messages.stockout')</a></li>
                                @endif
                                @if ($usr->can('stock.view'))
                                <li class=""><a href="{{ route('admin.stock-status.index') }}"><i class="fa fa-shopping-bag"></i>&nbsp;@lang('messages.stock')</a></li>
                                @endif

                        </ul>
                    </li>
                    @endif
                    @if($usr->can('supplier.view') || $usr->can('supplier.create') || $usr->can('supplier.edit') || $usr->can('supplier.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-male"></i><span>
                            @lang('messages.suppliers')
                        </span></a>
                        <ul class="collapse">
                                @if($usr->can('supplier.view'))
                                <li class=""><a href="{{ route('admin.suppliers.index') }}"><i class="fa fa-male"></i>&nbsp;@lang('messages.suppliers')</a></li>
                                @endif
                                @if ($usr->can('address.view'))
                                <li class="{{ Route::is('admin.address.index')  || Route::is('admin.address.edit') ? 'active' : '' }}"><a href="{{ route('admin.addresses.index') }}"><i class="fa fa-map-marker"></i>&nbsp;@lang('messages.address')</a></li>
                            @endif

                        </ul>
                    </li>
                    @endif
                    @if($usr->can('setting.view'))
                    <li class=""><a href="{{ route('admin.settings.index') }}"><i class="fa fa-cogs"></i><span>@lang('messages.setting')</a></li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</div>
