@extends('dashboards.admins.index')

@section('allvacations')
    
    <div class="container-fluid">
        <br>

            @if ($display == 'pending')
                <h3>Pending Vacations</h3><br>
            @elseif ($display == 'approved')
                <h3>Approved Vacations</h3><br>
            @elseif ($display == 'not approved')
                <h3>Not Approved Vacations</h3><br>
            @elseif ($display = 'all')
                <h3>Vacations History</h3><br>
            @endif

        <table class="table table-striped table-hover">

            <thead>
                <tr><th>User</th><th>User Id</th><th>Depart date</th><th>Return date</th><th>Date od application</th><th>Status</th><th>Action</th></tr>
            </thead>

            <tbody>
                @if ($vacation_datas)
                    @foreach ($vacation_datas as $vacation_data)

                        <tr><td>{{$vacation_data->name}}</td>
                        <td id="user_id" class="user_id" name="user_id" value="{{$vacation_data->id}}">{{$vacation_data->id}}</td>
                        <td>{{$vacation_data->depart}}</td><td>{{$vacation_data->return}}</td><td>{{$vacation_data->created_at}}</td>
                        
                        <td>
                            @if ($vacation_data->status == 0)
                                <span style="color: blue">waiting for approval</span>

                            @elseif ($vacation_data->status == 1)
                                <span style="color: green">Approved</span>
                                
                            @elseif ($vacation_data->status == 2)
                                <span style="color: red">Not Approved</span>
                            @endif

                        </td>
                        <td>
                            <a href="{{ route('admin.editvacation', [$vacation_data->id]) }}">
                                <button class="btn-sm btn btn-success"><i class="fa fa-edit"></i> Edit</button>
                            </a>
                        </td>
                        </tr>

                    @endforeach
                @endif
            </tbody>

        </table>

    </div>

@endsection