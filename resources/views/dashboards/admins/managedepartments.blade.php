@extends('dashboards.admins.index')

@section('managedepartments')

    <div class="container-fluid">
        <br>

        <h3>Manage Departments</h3><br>

        <table class="table table-striped table-hover">

            <thead>
                <tr><th>Department</th><th>Managers name</th><th>Action</th></tr>
            </thead>

            <tbody>
                @if ($departments)
                    @foreach ($departments as $department)

                        <tr><td>{{$department->department_name}}</td><td>{{$department->user_name . ' ' . $department->last_name}}</td>
                            <td>
                        
                                <a href="{{url('admin/managedepartments/edit/'.$department->department_id)}}">
                                    <button class="btn-sm btn btn-success"><i class="fa fa-edit"></i> Edit</button>
                                </a>
                                <form action="{{url('admin/managedepartments/delete/'.$department->department_id)}}" method="post">
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