<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu" data-auto-scroll="true" data-slide-speed="200">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <li class="sidebar-toggler-wrapper">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler">
                </div>
                <!-- END SIDEBAR TOGGLER BUTTON -->
            </li>

            <li class="{{ Request::is('admin') ? 'start active' : '' }}">
                <a href="{{ URL::route('home') }}">
                <i class="icon-home"></i>
                <span class="title">Dashboard</span>
                <span class="selected"></span>
                </a>
            </li>

<!--
|--------------------------------------------------------------------------
| Manifest
|--------------------------------------------------------------------------
-->

            <li class="{{ Request::is('admin/manifest*') ? 'start active open' : '' }}">
                <a href="javascript:;">
                <i class="icon-anchor"></i>
                <span class="title">Manifest</span>
                <span class="{{ Request::is('admin/manifest*') ? 'arrow open' : 'arrow' }}"></span>
                <span class="selected"></span>
                </a>
                <ul class="sub-menu">
                    <li class="{{ Request::is('admin/manifest/schedule*') ? 'active' : '' }}">
                        <a href="{{ URL::route('manifest.schedule') }}">
                        Vessel Schedule </a>
                    </li>   
                    <li class="{{ Request::is('admin/manifest/vessels*') ? 'active' : '' }}">
                        <a href="{{ URL::route('manifest.vessels') }}">
                        Vessels</a>
                    </li>    

           
                </ul>                
            </li>

<!--
|--------------------------------------------------------------------------
| Receiving Advice
|--------------------------------------------------------------------------
-->
            <li class="{{ Request::is('admin/receiving') ? 'start active' : '' }}">
                <a href="{{ URL::route('receiving') }}">
                <i class="fa fa-arrow-down"></i>
                <span class="title">Receiving Advice</span>
                <span class="selected"></span>
                </a>
            </li>          
<!--
|--------------------------------------------------------------------------
| Work Order
|--------------------------------------------------------------------------
-->
            <li class="{{ Request::is('admin/movement*') ? 'start active open' : '' }}">
                <a href="javascript:;">
                <i class="fa fa-exchange"></i>
                <span class="title">Container Movement</span>
                <span class="{{ Request::is('admin/workorders*') ? 'arrow open' : 'arrow' }}"></span>
                <span class="selected"></span>
                </a>
                <ul class="sub-menu">
                    <li class="{{ Request::is('admin/movement/workorder*') ? 'active' : '' }}">
                        <a href="{{ URL::route('workorders') }}">
                        Work Order </a>
                    </li>        
                    <li class="{{ Request::is('admin/movement/container*') ? 'active' : '' }}">
                        <a href="{{ URL::route('containers') }}">
                        Container </a>
                    </li>                      
                    <li class="{{ Request::is('admin/movement/confirmation*') ? 'active' : '' }}">
                        <a href="{{ URL::route('confirmation') }}">
                        Confirmation </a>
                    </li>                            
                </ul>           
            </li>
<!--
|--------------------------------------------------------------------------
| Cargo
|--------------------------------------------------------------------------
-->
            <li class="{{ Request::is('admin/cargo*') ? 'start active open' : '' }}">
                <a href="javascript:;">
                <i class="fa fa-archive"></i>
                <span class="title">Cargo Confirmation</span>
                <span class="{{ Request::is('admin/cargo*') ? 'arrow open' : 'arrow' }}"></span>
                <span class="selected"></span>
                </a>
                <ul class="sub-menu">      
                    <li class="{{ Request::is('admin/cargo/list*') ? 'active' : '' }}">
                        <a href="{{ URL::route('cargo') }}">
                        Cargo </a>
                    </li>                  
                    <li class="{{ Request::is('admin/cargo/confirmation/import*') ? 'active' : '' }}">
                        <a href="{{ URL::route('cargo.confirmation.import') }}">
                        Import Cargo </a>
                    </li>                               
                    <li class="{{ Request::is('admin/cargo/confirmation/export*') ? 'active' : '' }}">
                        <a href="{{ URL::route('cargo.confirmation.export') }}">
                        Export Cargo </a>
                    </li>                            
                </ul>                             
            </li>          
<!--
|--------------------------------------------------------------------------
| Port User
|--------------------------------------------------------------------------
-->
            <li class="{{ Request::is('admin/portusers*') ? 'start active' : '' }}">
                <a href="{{ URL::route('portusers') }}">
                <i class="fa fa-male"></i>
                <span class="title">Port Users</span>
                <span class="selected"></span>
                </a>
            </li>
<!--
|--------------------------------------------------------------------------
| Access Control
|--------------------------------------------------------------------------
-->            
            <li class="{{ Request::is('admin/access*') ? 'start active open' : '' }}">
                <a href="javascript:;">
                <i class="icon-user"></i>
                <span class="title">Access Control</span>
                <span class="{{ Request::is('admin/access*') ? 'arrow open' : 'arrow' }}"></span>
                <span class="selected"></span>
                </a>
                <ul class="sub-menu">
                    <li class="{{ Request::is('admin/access/users*') ? 'active' : '' }}">
                        <a href="{{ URL::route('users') }}">
                        Users </a>
                    </li>
                    <li class="{{ Request::is('admin/access/roles*') ? 'active' : '' }}">
                        <a href="{{ URL::route('roles') }}">
                        Roles </a>
                    </li>
                    <li class="{{ Request::is('admin/access/permissions*') ? 'active' : '' }}">
                        <a href="{{ URL::route('permissions') }}">
                        Permissions </a>
                    </li>                    
                </ul>                
            </li>                       
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>
<!-- END SIDEBAR -->