@extends('dashboards.admins.index')

@section('addemployee')

    <div class="container-fluid col-lg-5">
        <form method="post" enctype="multipart/form-data"><br>

            <h3>Add Employee</h3><br>

            @csrf

            <div class="form-group">
                <label>Name *</label>
                <input class="form-control @error('name') error-border @enderror" type="text" placeholder="Enter name" name="name" value="{{old('name')}}"/>
                @error('name')
                    <div class="error-text">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Last Name *</label>
                <input class="form-control @error('last_name') error-border @enderror" type="text" placeholder="Enter last name" name="last_name" value="{{old('last_name')}}"/>
                @error('last_name')
                    <div class="error-text">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Role *</label>
                <select class="form-control @error('role') error-border @enderror" id="role" name="role" required>
                    <option>Select role</option>
                    {{-- <option value="admin">Admin</option> --}}
                    <option value="manager">Manager</option>
                    <option value="user">User</option>
                </select>
                @error('role')
                    <div class="error-text">
                        {{-- {{ $message }} --}}
                        {{ 'The role must be selected.' }}
                    </div>
                @enderror
            </div>
            
            <div class="form-group">
                <label>Department *</label>
                <select class="form-control @error('department_id') error-border @enderror" id="department_id" name="department_id" required>
                    <option>Select department</option>

                    @foreach ($departments as $department)
                        <option value="{{$department->id}}">{{$department->name}}</option>
                    @endforeach

                </select>
                @error('department_id')
                    <div class="error-text">
                        {{ $message }}
                        {{-- {{ 'The department must be selected.' }} --}}
                    </div>
                @enderror
            </div>


            <div class="form-group">
                <label>Email address *</label>
                <input class="form-control @error('email') error-border @enderror" type="text" placeholder="Enter email" name="email" value="{{old('email')}}"/>
                @error('email')
                    <div class="error-text">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Password *</label>
                <input class="form-control @error('password') error-border @enderror" type="password" placeholder="Password" name="password" value="{{old('password')}}"/>
                @error('password')
                    <div class="error-text">
                        {{ $message }}
                    </div>
                @enderror
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

            <button class="btn btn-primary" type="submit">Create</button>

        </form>
    </div>

@endsection