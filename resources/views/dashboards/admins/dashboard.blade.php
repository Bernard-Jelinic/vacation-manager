@extends('dashboards.admins.index')

@section('dashboard')

    <script>
        $(document).ready(function(){

            // setTimeout(() => {
            // try {
            //     document.querySelector(".col-lg-3").innerText = "";
            // } catch (error) {
            //     //console.log(error);
            // }
            // }, 3000);

        });
    </script>


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
        @foreach ($vacation_datas as $vacation_data)
            <a href="">
                <div class="desc">
                    <div class="thumb">
                        <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                    </div>
        
                    <div class="details">
                        <p><muted>2 Minutes Ago</muted></p>
                        {{-- <p>{{$vacation_data->name . ' ' .$vacation_data->last_name . ' send request for vacation'}}</p> --}}
                        {{-- {{$vacation_data->name . ' ' .$vacation_data->last_name . ' send request for vacation'}} --}}
                        <a href="#">{{$vacation_data->name . ' ' .$vacation_data->last_name}}</a> sent a request
                    </div>
                </div>
            </a>

        @endforeach



        {{-- <!-- Second Action -->
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
        </div> --}}




    </div><!-- /col-lg-3 -->
</div>

@endsection