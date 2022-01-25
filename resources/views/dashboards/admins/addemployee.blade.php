@extends('dashboards.admins.index')

@section('addemployee')

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

            <h3>Register User</h3><br>

            @csrf

            <div class="form-group">
                <label>Name</label>
                <input class="form-control" type="text" placeholder="Enter name" name="name" value="{{old('name')}}"/>
            </div>

            <div class="form-group">
                <label>Last Name</label>
                <input class="form-control" type="text" placeholder="Enter last name" name="last_name" value="{{old('last_name')}}"/>
            </div>

            <div class="form-group">
                <label>Users Role</label>
                <select class="form-control" id="role" name="role" required>
                    <option>Select role</option>
                    <option value="admin">Admin</option>
                    <option value="manager">Manager</option>
                    <option value="user">User</option>
                </select>
            </div>

            <div class="form-group">
                <label>Email address</label>
                <input class="form-control" type="text" placeholder="Enter email" name="email" value="{{old('email')}}"/>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input class="form-control" type="password" placeholder="Password" name="password" value="{{old('password')}}"/>
            </div>

            <button class="btn btn-primary" type="submit">Create</button>

        </form>
    </div>

@endsection