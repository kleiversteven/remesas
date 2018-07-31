
<!DOCTYPE html>
<html lang="en">
     <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
         <title>LocalRemesas</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="{{ asset('assets/global/plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/global/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/global/plugins/uniform/css/uniform.default.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <link href="{{ asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css">
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="{{ asset('assets/global/css/components.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />
        <link href="{{ asset('assets/global/css/plugins.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        
        <link href="{{ asset('assets/pages/css/profile.min.css')}}" rel="stylesheet" type="text/css">
         
        <link href="{{ asset('assets/global/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
         
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="{{ asset('assets/layouts/layout3/css/layout.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/layouts/layout3/css/themes/default.css')}}" rel="stylesheet" type="text/css" id="style_color" />
        <link href="{{ asset('assets/layouts/layout3/css/custom.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <link href="{{ asset('assets/global/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/global/plugins/select2/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
         
        <link href="{{ asset('css/alertify.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/alertify.default.css')}}" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="{{ asset('images/icono.png') }}" type="image/x-icon"/>
    <!-- END HEAD -->

    <body class="page-container-bg-solid page-header-top-fixed page-boxed">
        <!-- BEGIN HEADER -->
        <div class="page-header">
            <!-- BEGIN HEADER TOP -->
            <div class="page-header-top">
                <div class="container">
                    <!-- BEGIN LOGO -->
                    <div class="page-logo">
                        <a href="{{ url('inicio') }}">
                            <img src="{{ asset('images/logo2.png')}}" alt="logo" style="width:100px; margin-top: 7px;"  >
                        </a>
                    </div>
                    <!-- END LOGO -->
                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                    <a href="javascript:;" class="menu-toggler"></a>
                    <!-- END RESPONSIVE MENU TOGGLER -->
                    <!-- BEGIN TOP NAVIGATION MENU -->
                    <div class="top-menu">
                        <ul class="nav navbar-nav pull-right">
                            <!-- BEGIN NOTIFICATION DROPDOWN 
                            <li class="dropdown dropdown-extended dropdown-notification dropdown-dark" id="header_notification_bar">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <i class="icon-bell"></i>
                                    <span class="badge badge-default">7</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="external">
                                        <h3>You have
                                            <strong>12 pending</strong> tasks</h3>
                                        <a href="#">view all</a>
                                    </li>
                                    <li>
                                        <ul class="dropdown-menu-list scroller" style="height: 250px;" data-handle-color="#637283">
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="time">just now</span>
                                                    <span class="details">
                                                        <span class="label label-sm label-icon label-success">
                                                            <i class="fa fa-plus"></i>
                                                        </span> New user registered. </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>-->
                            <!-- END NOTIFICATION DROPDOWN 
                            
                            <li class="droddown dropdown-separator">
                                <span class="separator"></span>
                            </li>-->
                            <!-- BEGIN INBOX DROPDOWN 
                            <li class="dropdown dropdown-extended dropdown-inbox dropdown-dark" id="header_inbox_bar">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <span class="circle">3</span>
                                    <span class="corner"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="external">
                                        <h3>You have
                                            <strong>7 New</strong> Messages</h3>
                                        <a href="#">view all</a>
                                    </li>
                                    <li>
                                        <ul class="dropdown-menu-list scroller" style="height: 275px;" data-handle-color="#637283">
                                            <li>
                                                <a href="#">
                                                    <span class="photo">
                                                        <img src="{{asset('images/head.png')}}" class="img-circle" alt=""> </span>
                                                    <span class="subject">
                                                        <span class="from"> Lisa Wong </span>
                                                        <span class="time">Just Now </span>
                                                    </span>
                                                    <span class="message"> Vivamus sed auctor nibh congue nibh. auctor nibh auctor nibh... </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>-->
                            <!-- END INBOX DROPDOWN -->
                            <!-- BEGIN USER LOGIN DROPDOWN -->
                            <li class="dropdown dropdown-user dropdown-dark">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                    <img alt="" class="img-circle" src="{{ Storage::url($user->avatar) }}">{{ Auth::user()->name }} 
                                    <span class="username username-hide-mobile"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-default">
                                    @role('cliente')
                                    <li>
                                        <a href="{{ url('perfil') }}" >
                                            <i class="icon-user"></i> Perfil</a>
                                    </li>
                                    @endrole
                                    <li>
                                        <a href="{{ url('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="icon-key"></i> Salir </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- END USER LOGIN DROPDOWN -->
                            <!-- BEGIN QUICK SIDEBAR TOGGLER 
                            <li class="dropdown dropdown-extended quick-sidebar-toggler">
                                <span class="sr-only">Toggle Quick Sidebar</span>
                                <i class="icon-logout"></i>
                            </li>
                            <!-- END QUICK SIDEBAR TOGGLER -->
                        </ul>
                    </div>
                    <!-- END TOP NAVIGATION MENU -->
                </div>
            </div>
            <!-- END HEADER TOP -->
            <!-- BEGIN HEADER MENU -->
            <div class="page-header-menu">
                <div class="container">
                    <!-- BEGIN MEGA MENU -->
                    <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
                    <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
                    <div class="hor-menu  ">
                        <ul class="nav navbar-nav">
                           
                                    @role('cliente')
                                    <li class=" ">
                                        <a href="{{ url('administrar') }}"> Inicio
                                            <span class="arrow"></span>
                                        </a>
                                     </li>
                                    <li class="menu-dropdown classic-menu-dropdown ">
                                        <a href="javascript:;"> Depositos
                                            <span class="arrow"></span>
                                        </a>
                                        <ul class="dropdown-menu pull-left">
                                                <li class=" ">
                                                    <a href="{{ url('misdepositos') }}" class="nav-link  ">
                                                        <i class="fa "></i> Mis depositos
                                                    </a>
                                                </li>
                                                <li class=" ">
                                                    <a href="{{ url('depositos') }}" class="nav-link  ">
                                                        <i class="fa "></i> Nuevo deposito
                                                    </a>
                                                </li>
                                          </ul>
                                     </li>
                                    @endrole
                                    @role('developers')
                                    <li class=" ">
                                        <a href="{{ url('administrar') }}"> Inicio
                                            <span class="arrow"></span>
                                        </a>
                                     </li>
                                      <li class="menu-dropdown classic-menu-dropdown ">
                                        <a href="javascript:;"> Administrar
                                            <span class="arrow"></span>
                                            </a>
                                            <ul class="dropdown-menu pull-left">
                                                    <li class=" ">
                                                        <a href="{{ url('bancos') }}" class="nav-link  ">
                                                            <i class="fa "></i> Bancos
                                                        </a>
                                                    </li>
                                                    <li class=" ">
                                                        <a href="{{ url('tasas') }}" class="nav-link  ">
                                                            <i class="fa "></i> Tasas de cambio
                                                        </a>
                                                    </li>
                                              </ul>
                                         </li>
                                        <li class="menu-dropdown classic-menu-dropdown ">
                                        <a href="javascript:;"> Depositos
                                            <span class="arrow"></span>
                                            </a>
                                            <ul class="dropdown-menu pull-left">
                                                    <li class=" ">
                                                        <a href="{{ url('listardepositos') }}" class="nav-link  ">
                                                            <i class="fa "></i> Listar
                                                        </a>
                                                    </li>
                                              </ul>
                                         </li>
                                    @endrole
                                    @role('super-admin')
                                    <li class=" ">
                                        <a href="{{ url('administrar') }}"> Inicio
                                            <span class="arrow"></span>
                                        </a>
                                     </li>
                                      <li class="menu-dropdown classic-menu-dropdown ">
                                        <a href="javascript:;"> Administrar
                                            <span class="arrow"></span>
                                            </a>
                                            <ul class="dropdown-menu pull-left">
                                                    <li class=" ">
                                                        <a href="{{ url('bancos') }}" class="nav-link  ">
                                                            <i class="fa "></i> Bancos
                                                        </a>
                                                    </li>
                                                    <li class=" ">
                                                        <a href="{{ url('tasas') }}" class="nav-link  ">
                                                            <i class="fa "></i> Tasas de cambio
                                                        </a>
                                                    </li>
                                              </ul>
                                         </li>
                                        <li class="menu-dropdown classic-menu-dropdown ">
                                        <a href="javascript:;"> Depositos
                                            <span class="arrow"></span>
                                            </a>
                                            <ul class="dropdown-menu pull-left">
                                                    <li class=" ">
                                                        <a href="{{ url('listardepositos') }}" class="nav-link  ">
                                                            <i class="fa "></i> Listar
                                                        </a>
                                                    </li>
                                              </ul>
                                         </li>
                                        <li class="menu-dropdown classic-menu-dropdown ">
                                        <a href="javascript:;"> Usuarios
                                            <span class="arrow"></span>
                                            </a>
                                            <ul class="dropdown-menu pull-left">
                                                    <li class=" ">
                                                        <a href="{{ url('listarusuarios') }}" class="nav-link  ">
                                                            <i class="fa "></i> Listar
                                                        </a>
                                                    </li>
                                                    <li class=" ">
                                                        <a href="{{ url('adduser') }}" class="nav-link  ">
                                                            <i class="fa "></i> Agregar
                                                        </a>
                                                    </li>
                                              </ul>
                                         </li>
                                    @endrole
                                    @role('Mayorista')
                                    <li class=" ">
                                        <a href="{{ url('administrar') }}"> Inicio
                                            <span class="arrow"></span>
                                        </a>
                                     </li>
                                        <li class="menu-dropdown classic-menu-dropdown ">
                                        <a href="javascript:;">Mis depositos
                                            <span class="arrow"></span>
                                            </a>
                                            <ul class="dropdown-menu pull-left">
                                                    <li class=" ">
                                                        <a href="{{ url('misdepositos') }}" class="nav-link  ">
                                                            <i class="fa "></i> Trasferencias
                                                        </a>
                                                    </li>
                                                <li class=" ">
                                                        <a href="{{ url('listarefectivo') }}" class="nav-link  ">
                                                            <i class="fa "></i> Efectivo
                                                        </a>
                                                    </li>
                                              </ul>
                                         </li>
                                        <li class="menu-dropdown classic-menu-dropdown ">
                                        <a href="javascript:;"> Depostios
                                            <span class="arrow"></span>
                                            </a>
                                            <ul class="dropdown-menu pull-left">
                                                    <li class=" ">
                                                        <a href="{{ url('depositos') }}" class="nav-link  ">
                                                            <i class="fa "></i> Nuevo deposito
                                                        </a>
                                                    </li>
                                                    <li class=" ">
                                                        <a href="{{ url('efectivo') }}" class="nav-link  ">
                                                            <i class="fa "></i> Deposito en efectivo
                                                        </a>
                                                    </li>
                                              </ul>
                                         </li>
                                    @endrole
                                
                            
                           
                        </ul>
                    </div>
                    <!-- END MEGA MENU -->
                </div>
            </div>
            <!-- END HEADER MENU -->
        </div>
        <!-- END HEADER -->
        <!-- BEGIN CONTAINER -->
       
        <div class="page-container">
            
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <!-- BEGIN PAGE HEAD-->
                <div class="page-head">
                    <div class="container">
                        <!-- BEGIN PAGE TITLE -->
                        <div class="page-title">
                            <h1>@yield('title') </h1>
                        </div>
                        <!-- END PAGE TITLE -->
                    </div>
                </div>
                <!-- END PAGE HEAD-->
                <!-- BEGIN PAGE CONTENT BODY -->
                <div class="page-content">
                    <div class="container">
                        <!-- BEGIN PAGE BREADCRUMBS -->
                        <ul class="page-breadcrumb breadcrumb">
                            @yield('breadcound')
                        </ul>
                        <!-- END PAGE BREADCRUMBS -->
                       
                        <!-- BEGIN PAGE CONTENT INNER -->
                       @yield('content')
                        <!-- END PAGE CONTENT INNER -->
                    </div>
                </div>
                <!-- END PAGE CONTENT BODY -->
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
            <!-- BEGIN QUICK SIDEBAR
            <a href="javascript:;" class="page-quick-sidebar-toggler">
                <i class="icon-login"></i>
            </a> 
            <div class="page-quick-sidebar-wrapper" data-close-on-body-click="false">
                <div class="page-quick-sidebar">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="javascript:;" data-target="#quick_sidebar_tab_1" data-toggle="tab"> Usuarios
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active page-quick-sidebar-chat" id="quick_sidebar_tab_1">
                            <div class="page-quick-sidebar-chat-users" data-rail-color="#ddd" data-wrapper-class="page-quick-sidebar-list">
                                <h3 class="list-heading">Staff</h3>
                                <ul class="media-list list-items">
                                    <li class="media">
                                        <img class="media-object" src="{{asset('images/head.png')}}" alt="...">
                                        <div class="media-body">
                                            <h4 class="media-heading">Ella Wong</h4>
                                            <div class="media-heading-sub"> CEO </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="page-quick-sidebar-item">
                                <div class="page-quick-sidebar-chat-user">
                                    <div class="page-quick-sidebar-nav">
                                        <a href="javascript:;" class="page-quick-sidebar-back-to-list">
                                            <i class="icon-arrow-left"></i>Back</a>
                                    </div>
                                    <div class="page-quick-sidebar-chat-user-messages">
                                        
                                        <div class="post in">
                                            <img class="avatar" alt="" src="{{asset('images/head.png')}}" />
                                            <div class="message">
                                                <span class="arrow"></span>
                                                <a href="javascript:;" class="name">Ella Wong</a>
                                                <span class="datetime">20:15</span>
                                                <span class="body"> Its almost done. I will be sending it shortly </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="page-quick-sidebar-chat-user-form">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Type a message here...">
                                            <div class="input-group-btn">
                                                <button type="button" class="btn green">
                                                    <i class="icon-paper-clip"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END QUICK SIDEBAR -->
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <!-- BEGIN INNER FOOTER -->
        <div class="page-footer">
            <div class="container"> {{ date("Y") }} Local remesas.
            </div>
        </div>
        <div class="scroll-to-top">
            <i class="icon-arrow-up"></i>
        </div>
        {!! Form::open(['url'=>'/logout','method'=>'POST','id'=>'logout-form','style'=>'display: none;']) !!}
        {!! Form::close() !!}
        <!-- END INNER FOOTER -->
        <!-- END FOOTER -->
        <!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        

        <script src="{{ asset('assets/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/js.cookie.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/uniform/jquery.uniform.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <script src="{{ asset('assets/global/plugins/jquery.sparkline.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{ asset('assets/global/scripts/app.min.js')}}" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        
         <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="{{ asset('assets/pages/scripts/table-datatables-managed.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/datatables/datatables.js')}}" type="text/javascript"></script>
        <script src="{{ asset('assets/layouts/layout3/scripts/layout.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('assets/layouts/layout3/scripts/demo.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('assets/layouts/global/scripts/quick-sidebar.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('assets/layouts/global/scripts/quick-nav.min.js')}}" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        <script src="{{ asset('assets/pages/scripts/profile.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/select2/js/select2.full.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.min.js')}}" type="text/javascript"></script>
        <script src="{{ asset('js/alertify.js')}}" type="text/javascript"></script>
        @yield('scripts')
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
        </script>
    </body>

</html>