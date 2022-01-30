@extends('layouts.app')

@section('content')

    <section id="container" >
        <!-- **********************************************************************************************************************************************************
        TOP BAR CONTENT & NOTIFICATIONS
        *********************************************************************************************************************************************************** -->
        <!--header start-->
        <header class="header black-bg">
            <div class="sidebar-toggle-box">
                <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
            </div>
            <!--logo start-->
            <a href="{{ route('manager.dashboard') }}" class="logo"><b>Vacation manager</b></a>
            <!--logo end-->
            <div class="nav notify-row" id="top_menu">
                <!--  notification start -->
                <ul class="nav top-menu">
                    <!-- inbox dropdown start-->
                    <li id="header_inbox_bar" class="dropdown">

                        

                        {{-- <a data-toggle="dropdown" class="dropdown-toggle" id="notification" href="index.html#">
                            <i class="fa fa-bell"></i>
                            <i class="fa fa-bell-o"></i>
                            <span class="badge bg-theme" id="notification_num"></span>
                        </a>
                        <ul class="dropdown-menu extended inbox">
                            <div class="notify-arrow notify-arrow-green"></div>
                            <li>
                                <p class="green">You have 4 pending vacations</p>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <span class="photo"><img alt="avatar" src="assets/img/ui-zac.jpg"></span>
                                    <span class="subject">
                                    <span class="from">Zac Snider</span>
                                    <span class="time">Just now</span>
                                    </span>
                                    <span class="message">
                                        Hi mate, how is everything?
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <span class="photo"><img alt="avatar" src="assets/img/ui-divya.jpg"></span>
                                    <span class="subject">
                                    <span class="from">Divya Manian</span>
                                    <span class="time">40 mins.</span>
                                    </span>
                                    <span class="message">
                                        Hi, I need your help with this.
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <span class="photo"><img alt="avatar" src="assets/img/ui-danro.jpg"></span>
                                    <span class="subject">
                                    <span class="from">Dan Rogers</span>
                                    <span class="time">2 hrs.</span>
                                    </span>
                                    <span class="message">
                                        Love your new Dashboard.
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">
                                    <span class="photo"><img alt="avatar" src="assets/img/ui-sherman.jpg"></span>
                                    <span class="subject">
                                    <span class="from">Dj Sherman</span>
                                    <span class="time">4 hrs.</span>
                                    </span>
                                    <span class="message">
                                        Please, answer asap.
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a href="index.html#">See all vacations</a>
                            </li>
                        </ul> --}}


                        
                    </li>
                    <!-- inbox dropdown end -->
                </ul>
                <!--  notification end -->
            </div>
            <div class="top-menu">
                <ul class="nav pull-right top-menu">
                    <li>
                        <a class="logout" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </header>
        <!--header end-->
        
        <!-- **********************************************************************************************************************************************************
        MAIN SIDEBAR MENU
        *********************************************************************************************************************************************************** -->
        <!--sidebar start-->
        <aside>
            <div id="sidebar"  class="nav-collapse ">
                <!-- sidebar menu start-->
                <ul class="sidebar-menu" id="nav-accordion">
                    <h5 class="centered">Manager:</h5>
                    <h5 class="centered">{{ Auth::user()->name . ' ' . Auth::user()->last_name }}</h5>

                    <li class="sub-menu">
                        <a href="{{ route('manager.dashboard') }}">
                            <i class="fa fa-home"></i>
                            <span>Home</span>
                        </a>
                    </li>
                    
                    {{-- <li class="sub-menu">
                        <a href="javascript:;" >
                            <i class="fa fa-th"></i>
                            <span>Department</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{route('adddepartment')}}">Add Department</a></li>
                            <li><a href="{{url('manager/managedepartments')}}">Manage Departments</a></li>
                        </ul>
                    </li> --}}
                    
                    {{-- <li class="sub-menu">
                        <a href="javascript:;" >
                            <i class="fa fa-users"></i>
                            <span>Employees</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{route('addemployee')}}">Add Employee</a></li>
                            <li><a href="{{route('manageemployee')}}">Manage Employee</a></li>
                        </ul>
                    </li> --}}
                    
                    <li class="sub-menu">
                        <a href="javascript:;" >
                            <i class="fa fa-compass"></i>
                            <span>Vacations</span>
                        </a>

                        <ul class="sub">
                            <li><a href="{{route('allvacations')}}">All Vacations</a></li>
                            <li><a href="{{route('pendingvacations')}}">Pending Vacations</a></li>
                            <li><a href="{{route('approvedvacations')}}">Approved Vacations</a></li>
                            <li><a href="{{route('notapprovedvacations')}}">Not Approved Vacations</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out"></i>
                            <span>Logout</span>
                        </a>
                    </li>

                </ul>
                <!-- sidebar menu end-->
            </div>
        </aside>
        <!--sidebar end-->
        
        <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">

                @yield('dashboard')

                {{-- @yield('addemployee')
                @yield('manageemployee')
                @yield('editemployee')

                @yield('adddepartment')
                @yield('managedepartments')
                @yield('editdepartments') --}}

                @yield('editvacation')
                @yield('allvacations')
                @yield('pendingvacations')
                @yield('approvedvacations')
                @yield('notapprovedvacations')

            </section>
        </section>
    </section>

    <script type="text/javascript">

        $(document).ready(function(){

            fetchNotification();
            function fetchNotification(){

                $.ajax({
                    type: "GET",
                    url: "{{url('manager/fetchnotification')}}",
                    dataType: "json",
                    success: function(response){

                        let notificationNav = `
                        
                        <a data-toggle="dropdown" class="dropdown-toggle" id="notification" href="index.html#">
                            ${(response.count > 0) ? `<i class="fa fa-bell"></i><span class="badge bg-theme" id="notification_num">${response.count}</span>` : `<i class="fa fa-bell-o"></i>`}
                        </a>
                        
                        <ul class="dropdown-menu extended inbox">
                            <div class="notify-arrow notify-arrow-green"></div>

                            ${(response.count >= 0) ? `<li><p class="green">You have ${response.count} pending vacations</p></li>` : `<li><p class="green">You don't have pending vacations</p></li>`}

                        `;
                        if (response.count >= 0) {
                            response.notifications.forEach(element => {

                            notificationNav += `
                                <li>
                                    <a href="editvacation/${element.id}">
                                        <span class="subject">
                                        <span class="from">${element.name +' '+ element.last_name}</span>
                                        <span class="time">${element.created_at}</span>
                                        </span>
                                    </a>
                                </li>
                            `;
                        });
                        }


                        notificationNav += `
                        
                            <li>
                                <a href="allvacations">See all vacations</a>
                            </li>
                        </ul>

                        `;

                        $('#header_inbox_bar').html(notificationNav);

                    }
                })

            }

        })

    </script>

@endsection