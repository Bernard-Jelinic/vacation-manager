@extends('dashboards.users.index')

@section('historyvacations')

    <div class="container-fluid">
        <br>

        <h3>Vacations History</h3><br>

        <table class="table table-striped table-hover">

            <thead>
                <tr><th>Depart date</th><th>Return date</th><th>Date od application</th><th>Status</th></tr>
            </thead>

            <tbody>
                @if ($vacation_datas)
                    @foreach ($vacation_datas as $vacation_data)

                        <tr><td>{{$vacation_data->depart}}</td><td>{{$vacation_data->return}}</td><td>{{$vacation_data->formated_created_at}}</td>
                        
                            <td>
                                @if ($vacation_data->status == 0)
                                    <span style="color: blue">waiting for approval</span>

                                @elseif ($vacation_data->status == 1)
                                    <span style="color: green">Approved</span>
                                    
                                @else
                                    <span style="color: red">Not Approved</span>
                                @endif
                            </td>
                        </tr>

                    @endforeach
                @endif
            </tbody>

        </table>

    </div>

@endsection