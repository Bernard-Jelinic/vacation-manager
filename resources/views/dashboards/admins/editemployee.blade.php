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

            <h3>Edit Department</h3><br>

            @if ($employee)
                @foreach ($employee as $key)

                    <div class="form-group">
                        <label>User name</label>
                        <input value="{{$key->name}}" id="name" type="text" class="form-control" placeholder="User name" name="name" required autofocus>
                    </div>

                    <div class="form-group">
                        <label>User last name</label>
                        <input value="{{$key->last_name}}" id="name" type="text" class="form-control" placeholder="User last name" name="name" required autofocus>
                    </div>

                @endforeach
            @endif

            <div class="form-group">
                <label>Users Role</label>
                
                <select class="form-control" id="role" name="role" required>

                    @foreach ($employee as $key)
                            <option value="admin" {{$key->role == 'admin' ? 'selected':''}}>Admin</option>
                            <option value="manager" {{$key->role == 'manager' ? 'selected':''}}>Manager</option>
                            <option value="user" {{$key->role == 'user' ? 'selected':''}}>User</option>
                    @endforeach

                </select>
            </div>

            @csrf
            <input class="btn btn-primary" type="submit" value="Change">
        </form>
    </div>

@endsection