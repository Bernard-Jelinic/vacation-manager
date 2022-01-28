@extends('dashboards.users.index')

@section('applyvacations')

    <script>
        $(document).ready(function(){

            var minDate = new Date();

            $("#depart").datepicker({
                showAnim: 'drop',
                numberOfMonth: 1,
                minDate: minDate,
                dateFormat: 'dd/mm/yy',
                onClose: function(selectedDate){

                    if (selectedDate) { // Not null

                        var nextDay = $('#depart').datepicker('getDate', '+1d');
                        nextDay.setDate(nextDay.getDate()+1);
                        console.log(nextDay);
                        $('#return').datepicker("option","minDate",nextDay);

                    }
                    
                }
            });

            $("#return").datepicker({
                showAnim: 'drop',
                numberOfMonth: 1,
                minDate: minDate,
                dateFormat: 'dd/mm/yy',
                onClose: function(selectedDate){

                    if (selectedDate) { // Not null

                        var previousDay = $('#return').datepicker('getDate', '+1d');
                        previousDay.setDate(previousDay.getDate()-1);
                        console.log(previousDay);
                        $('#depart').datepicker("option","maxDate",previousDay);

                    }

                    
                }
            });

        });
    </script>
    {{-- <div class="container-fluid col-lg-5">
        <form method="post" enctype="multipart/form-data"><br>

            <span style="font-size:12px;color:red;">
                @if ($errors->all())
                    <div class="alert alert-danger text-center">
                        @foreach ($errors->all() as $error)
                            {{$error}}<br>
                        @endforeach
                    </div>
                @endif
            </span>

            <h3>Apply for new Vacation</h3><br>

            <div class="form-group">
                <label>Department Name</label>
                <input value="{{old('name')}}" id="name" type="text" class="form-control" placeholder="Department Name" name="name" required autofocus>
            </div>

            <div class="form-group">
                <label>Department Manager</label>

                <select id="manager_id" name="manager_id" class="form-control" required>
                    <option></option>
                    {{-- <?php if(is_array($managers)): ?>
                        <?php foreach($managers as $manager): ?>

                            <option value="<?=$manager->id?>"><?=$manager->name?></option>

                        <?php endforeach; ?>
                    <?php endif; ?> 
                </select>
            </div>

            @csrf
            <button class="btn btn-primary" type="submit">Post</button>

        </form>
    </div> --}}

    <form action="" method="POST">
        <input type="text" id="depart" name="depart" placeholder="depart date">
        <input type="text" id="return" name="return" placeholder="return date">
        <input type="submit" value="Apply Vacation">
    </form>


@endsection