@extends('dashboards.admins.index')

@section('dashboard')

    <script type="text/javascript">
        $(document).ready(function(){

            fetchNotification();
            function fetchNotification(){

                $.ajax({
                    type: "GET",
                    url: "{{url('admin/fetchnotification')}}",
                    dataType: "json",
                    success: function(response){

                        if (response.notifications.length>0) {
                            let notificationWindow = '<h3>NOTIFICATIONS</h3>';

                            response.notifications.forEach(element => {

                                notificationWindow += `
                                    <a href="editvacation/${element.id}">
                                        <div class="desc">
                                            <div class="thumb">
                                                <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                                            </div>
                                
                                            <div class="details">
                                                <p><muted>${element.created_at}</muted></p>
                                                <p style="font-size:12px;color:black;">${element.name +' '+ element.last_name} sent a request</p>
                                            </div>
                                        </div>
                                    </a>
                                `;
                            });

                            $('.col-lg-3').html(notificationWindow);
                        }
                    }
                })

            }

            setTimeout(() => {
            try {
                document.querySelector(".col-lg-3").innerText = "";
            } catch (error) {
                //console.log(error);
            }
            }, 3000);

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
        {{-- <h3>NOTIFICATIONS</h3> --}}
                        
        <!-- First Action -->




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