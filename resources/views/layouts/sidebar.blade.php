<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ getUser()['foto'] ?? '' }}" class="img-circle img-profil" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ getUser()['name'] ?? '' }}</p>
                <a href="javascript:void(0);">{{ getUser()['rolename'] ?? '' }}</a>
            </div>
        </div>
        
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            @php
            $mod = getModule('dashboard');
            if(!empty($mod)){
            @endphp
            <li>
                <a href="{{ route($mod['moduleurl']) }}">
                    <i class="{{$mod['moduleicon']}}"></i> <span>{{$mod['modulename']}}</span>
                </a>
            </li>
            @php } @endphp

            <!-- master -->
            @if( !empty(getModule('dept')) )
                <li class="header">MASTER DATA</li>
                @php
                $modMd = ['dept'];
                @endphp
                @foreach($modMd as $key => $row)
                    @php
                    $mod = getModule($row);
                    if(!empty($mod)){
                    @endphp
                    <li>
                        <a href="{{ route($mod['moduleurl']) }}">
                            <i class="{{$mod['moduleicon']}}"></i> <span>{{$mod['modulename']}}</span>
                        </a>
                    </li>
                    @php } @endphp
                @endforeach
            @endif
            <!-- end master -->

            <!-- Database -->
            @if( !empty(getModule('pegawai')) )
                <li class="header">Database</li>
                @php
                $modTrx = ['pegawai'];
                @endphp
                @foreach($modTrx as $key => $row)
                    @php
                    $mod = getModule($row);
                    if(!empty($mod)){
                    @endphp
                    <li>
                        <a href="{{ route($mod['moduleurl']) }}">
                            <i class="{{$mod['moduleicon']}}"></i> <span>{{$mod['modulename']}}</span>
                        </a>
                    </li>
                    @php } @endphp
                @endforeach
            @endif
            <!-- end Database -->

            <!-- acl -->
            @if( !empty(getModule('role')) || !empty(getModule('user')) )
                <li class="header">ACL</li>
                @php
                $modAcl = ['role','user'];
                @endphp
                @foreach($modAcl as $key => $row)
                    @php
                    $mod = getModule($row);
                    if(!empty($mod)){
                    @endphp
                    <li>
                        <a href="{{ route($mod['moduleurl']) }}">
                            <i class="{{$mod['moduleicon']}}"></i> <span>{{$mod['modulename']}}</span>
                        </a>
                    </li>
                    @php } @endphp
                @endforeach
            @endif
            <!-- end acl -->

            <!-- system -->
            @if( !empty(getModule('setting')) )
            <li class="header">SYSTEM</li>
            @php
            $mod = getModule('setting');
            if(!empty($mod)){
            @endphp
            <li>
                <a href="{{ route($mod['moduleurl']) }}">
                    <i class="{{$mod['moduleicon']}}"></i> <span>{{$mod['modulename']}}</span>
                </a>
            </li>
            @php } @endphp
            @endif
            <!-- end system -->
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>