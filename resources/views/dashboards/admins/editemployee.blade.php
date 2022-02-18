@extends('dashboards.admins.index')

@section('editemployee')

    <script type="text/javascript">
        
        $(document).ready(function(){

            if ($("#role option:selected").val() == 'admin') {
                // console.log($("#role option:selected").val());
                $("#show").hide();
            }

            $("#role").change(function() {

                if (this.value == 'admin') {
                    // console.log($("#role option:selected").val());
                     $("#show").hide();
                }else{
                    $("#show").show();
                }
            });

        });

    </script>

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
                        <input value="{{$key->last_name}}" id="last_name" type="text" class="form-control" placeholder="Employee last name" name="last_name" required autofocus>
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

            <div id="show" class="form-group">
                <label>Employees Department * </label>

                <select class="form-control" id="department_id" name="department_id" required>
                    <option>Select department</option>
                    @foreach ($employee as $key)
                        @foreach ($departments as $department)
                            <option value="{{$department->id}}" {{$department->id == $key->department_id ? 'selected':''}}>{{$department->name}}</option>
                        @endforeach
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

            <div class="form-group">
                <label>Confirm Password *</label>
                <input class="form-control @error('password_confirmation') error-border @enderror" type="password" placeholder="Confirm Password" name="password_confirmation" value="{{old('password_confirmation')}}"/>
                @error('password_confirmation')
                    <div class="error-text">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            @csrf
            <input class="btn btn-primary" type="submit" value="Change">
        </form>
    </div>

@endsection