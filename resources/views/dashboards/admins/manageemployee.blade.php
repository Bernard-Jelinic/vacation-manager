@extends('dashboards.admins.index')

@section('manageemployee')

        <div class="container-fluid">
        <br>

        <h3>Manage Employee</h3><br>

        <table class="table table-striped table-hover">

            <thead>
                <tr><th>Name</th><th>Last name</th><th>Role</th><th>Email</th><th>Action</th></tr>
            </thead>

            <tbody>
                @if ($users)
                    @foreach ($users as $user)

                        <tr><td>{{$user->name}}</td><td>{{$user->last_name}}</td><td>{{$user->role}}</td><td>{{$user->email}}</td>
                            <td>
                        
                                <a href="{{url('admin/manageemployee/edit/'.$user->id)}}">
                                    <button class="btn-sm btn btn-success"><i class="fa fa-edit"></i> Edit</button>
                                </a>
                                <form action="{{url('admin/manageemployee/delete/'.$user->id)}}" method="post">
                                    @csrf
                                    <button type="submit" class="btn-sm btn btn-warning"><i class="fa fa-times"></i> Delete</button>
                                </form>

                            </td>
                        </tr>

                    @endforeach
                @endif
            </tbody>

        </table>

    </div>

@endsection