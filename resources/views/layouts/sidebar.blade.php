<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                </li>

                <li class="sidebar-item mt-2">
                    <a class="sidebar-link waves-effect waves-dark" href="{{ route('admin.index') }}" aria-expanded="false">
                        <i class="icon-Car-Wheel"></i>
                        <span class="hide-menu">Dashboard </span>
                    </a>
                </li>
                @role('admin')
                @can('user.view', 'permission.view', 'role.view')
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                            aria-expanded="false">
                            <i class="mdi mdi-account-multiple"></i>
                            <span class="hide-menu">User </span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            @can('user.view')
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.user.index') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu"> User List </span>
                                    </a>
                                </li>
                            @endcan

                            @can('permission.view')
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.permission.index') }}" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i><span class="hide-menu">User Permission</span>
                                    </a>
                                </li>
                            @endcan

                            @can('role.view')
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.role.index') }}" class="sidebar-link"><i
                                            class="mdi mdi-adjust"></i><span class="hide-menu">User Role</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                
                <li class="sidebar-item">
                    <a href="{{ route('admin.general.index') }}" class="sidebar-link">
                        <i class="mdi mdi-garage-open"></i>
                        <span class="hide-menu"> General </span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="{{ route('admin.mutu-indicator.index') }}" class="sidebar-link">
                        <i class="mdi mdi-garage-open"></i>
                        <span class="hide-menu"> Indikator Mutu </span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="{{ route('admin.patient-indification.index') }}" class="sidebar-link">
                        <i class="mdi mdi-garage-open"></i>
                        <span class="hide-menu"> Indifikasi Pasien</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="{{ route('admin.compotition.index') }}" class="sidebar-link">
                        <i class="mdi mdi-garage-open"></i>
                        <span class="hide-menu"> Komposisi Pasien </span>
                    </a>
                </li>
                

                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                        aria-expanded="false">
                        <i class="mdi mdi-account-multiple"></i>
                        <span class="hide-menu">Pelayanan </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        @can('service.view')
                            <li class="sidebar-item">
                                <a href="{{ route('admin.service.index') }}" class="sidebar-link">
                                    <i class="mdi mdi-email"></i>
                                    <span class="hide-menu"> Pemeriksaan Lab </span>
                                </a>
                            </li>
                        @endcan

                        @can('parameter.view')
                            <li class="sidebar-item">
                                <a href="{{ route('admin.parameter.index') }}" class="sidebar-link">
                                    <i class="mdi mdi-adjust"></i><span class="hide-menu">Pemeriksaan Lab Parameter</span>
                                </a>
                            </li>
                        @endcan

                        @can('role.view')
                            <li class="sidebar-item">
                                <a href="{{ route('admin.role.index') }}" class="sidebar-link"><i
                                        class="mdi mdi-adjust"></i><span class="hide-menu">User Role</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
                
                <li class="sidebar-item">
                    <a href="{{ route('admin.report.index') }}" class="sidebar-link">
                        <i class="mdi mdi-garage-open"></i>
                        <span class="hide-menu"> Report </span>
                    </a>
                </li>
                @endrole


                @can('marketplace.view')
                    <li class="sidebar-item">
                        <a href="{{ route('admin.marketplace.index') }}" class="sidebar-link">
                            <i class="mdi mdi-garage-open"></i>
                            <span class="hide-menu"> Marketplace </span>
                        </a>
                    </li>
                @endcan

                
            </ul>
        </nav>
    </div>
</aside>
