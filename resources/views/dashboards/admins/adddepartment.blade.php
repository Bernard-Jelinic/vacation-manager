@extends('dashboards.admins.index')

@section('adddepartment')

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

            <h3>Add New Department</h3><br>

            <div class="form-group">
                <label>Department Name</label>
                <input value="{{old('name')}}" id="name" type="text" class="form-control" placeholder="Department Name" name="name" required autofocus>
            </div>

            @csrf
            <button class="btn btn-primary" type="submit">Post</button>

        </form>
    </div>

@endsection