@extends('dashboards.admins.index')

@section('editemployee')

    <div class="container-fluid col-lg-5">
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

            <h3>Edit Employee</h3><br>

            @if ($employee)
                @foreach ($employee as $key)

                    <div class="form-group">
                        <label>Employee name</label>
                        <input value="{{$key->name}}" id="name" type="text" class="form-control" placeholder="Employee name" name="name" required autofocus>
                    </div>

                    <div class="form-group">
                        <label>Employee last name</label>
                        <input value="{{$key->last_name}}" id="name" type="text" class="form-control" placeholder="Employee last name" name="last_name" required autofocus>
                    </div>

                @endforeach
            @endif

            <div class="form-group">
                <label>Employees Role</label>
                
                <select class="form-control" id="role" name="role" required>

                    @foreach ($employee as $key)
                            <option value="admin" {{$key->role == 'admin' ? 'selected':''}}>Admin</option>
                            <option value="manager" {{$key->role == 'manager' ? 'selected':''}}>Manager</option>
                            <option value="user" {{$key->role == 'user' ? 'selected':''}}>User</option>
                    @endforeach

                </select>
            </div>

            <div class="form-group">
                <label>Email address</label>
                <input class="form-control" type="text" placeholder="Enter email" name="email" value="{{$key->email}}"/>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input class="form-control" type="password" placeholder="Password" name="password" value="{{old('password')}}"/>
            </div>

            @csrf
            <input class="btn btn-primary" type="submit" value="Change">
        </form>
    </div>

@endsection