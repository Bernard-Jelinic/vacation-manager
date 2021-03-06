@extends('dashboards.employees.index')

@section('dashboard')

    <script type="text/javascript">
        $(document).ready(function(){

            fetchNotification();
            function fetchNotification(){

                $.ajax({
                    type: "GET",
                    url: "{{url('employee/fetchnotification')}}",
                    dataType: "json",
                    success: function(response){

                        if (response.notifications.length>0) {
                            let notificationWindow = '<h3>NOTIFICATIONS</h3>';

                            response.notifications.forEach(element => {

                                notificationWindow += `
                                    <a href="{{ route('historyvacations') }}">
                                        <div class="desc">
                                            <div class="details">
                                                <p style="font-size:12px;color:black;">The request created on ${element.formated_created_at} changed its status</p>
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
    <h1>Hello employee {{Auth::user()->name}}, welcome to the vacation manager</h1>
    </div>
    
    
    <!-- **********************************************************************************************************************************************************
    RIGHT SIDEBAR CONTENT
    *********************************************************************************************************************************************************** -->                  
    
    <div class="col-lg-3 ds">
    <!--COMPLETED ACTIONS DONUTS CHART-->
    </div>
</div>

@endsection