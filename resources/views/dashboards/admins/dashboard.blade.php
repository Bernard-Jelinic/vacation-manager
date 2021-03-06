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

                        //  because it doesn't needs to be displayed if there is no notifications
                        if (response.notifications.length>0) {
                            let notificationWindow = '<h3>NOTIFICATIONS</h3>';

                            response.notifications.forEach(element => {

                                notificationWindow += `
                                    <a href="admin/editvacation/${element.id}">
                                        <div class="desc">
                                            <div class="details">
                                                <p style="font-size:12px;color:black;">${element.name} ${element.last_name} send request</p>
                                                <p style="font-size:12px;color:black;">created ${element.formated_created_at}</p>
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
        </div>
    </div>

@endsection