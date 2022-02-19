@extends('dashboards.admins.index')

@section('adddepartment')

    <div class="container-fluid col-lg-5">
        <form method="post" enctype="multipart/form-data"><br>

            <h3>Add New Department</h3><br>

            <div class="form-group">
                <label>Department Name</label>
                <input class="form-control @error('name') error-border @enderror" type="text" placeholder="Department Name" name="name" value="{{old('name')}}">
                @error('name')
                    <div class="error-text">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Departments manager *</label>
                <select class="form-control @error('user_id') error-border @enderror" id="user_id" name="user_id">
                    <option>Select departments manager</option>

                    @foreach ($managers as $manager)
                        <option value="{{$manager->id}}">{{$manager->name . ' ' .$manager->last_name}}</option>
                    @endforeach

                </select>
            </div>

            @csrf
            <button class="btn btn-primary" type="submit">Post</button>

        </form>
    </div>

@endsection