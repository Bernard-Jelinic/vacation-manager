@extends('dashboards.admins.index')

@section('dashboard')
<div class="row">
    <div class="col-lg-9 main-chart">
    <h1>Hello admin {{Auth::user()->name}}, welcome to the vacation manager</h1>
    </div>
    
    
<!-- **********************************************************************************************************************************************************
RIGHT SIDEBAR CONTENT
*********************************************************************************************************************************************************** -->                  
    
    <div class="col-lg-3 ds">
    <!--COMPLETED ACTIONS DONUTS CHART-->
        <h3>NOTIFICATIONS</h3>
                        
        <!-- First Action -->
        <div class="desc">
        <div class="thumb">
            <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
        </div>
        <div class="details">
            <p><muted>2 Minutes Ago</muted><br/>
                <a href="#">James Brown</a> subscribed to your newsletter.<br/>
            </p>
        </div>
        </div>
        <!-- Second Action -->
        <div class="desc">
        <div class="thumb">
            <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
        </div>
        <div class="details">
            <p><muted>3 Hours Ago</muted><br/>
                <a href="#">Diana Kennedy</a> purchased a year subscription.<br/>
            </p>
        </div>
        </div>
        <!-- Third Action -->
        <div class="desc">
        <div class="thumb">
            <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
        </div>
        <div class="details">
            <p><muted>7 Hours Ago</muted><br/>
                <a href="#">Brandon Page</a> purchased a year subscription.<br/>
            </p>
        </div>
        </div>
        <!-- Fourth Action -->
        <div class="desc">
        <div class="thumb">
            <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
        </div>
        <div class="details">
            <p><muted>11 Hours Ago</muted><br/>
                <a href="#">Mark Twain</a> commented your post.<br/>
            </p>
        </div>
        </div>
        <!-- Fifth Action -->
        <div class="desc">
        <div class="thumb">
            <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
        </div>
        <div class="details">
            <p><muted>18 Hours Ago</muted><br/>
                <a href="#">Daniel Pratt</a> purchased a wallet in your store.<br/>
            </p>
        </div>
        </div>
    </div><!-- /col-lg-3 -->
</div>

@endsection