@extends('dashboards.admins.index')

@section('editdepartments')

    <div class="container-fluid col-lg-5">
        <form method="post" enctype="multipart/form-data"><br>

            <h3>Edit Department</h3><br>

            @if ($department)
                @foreach ($department as $key)

                    <div class="form-group">
                        <label>Department Name</label>
                        <input class="form-control @error('name') error-border @enderror" value="{{$key->name}}" id="name" type="text" placeholder="Department Name" name="name">
                        @error('name')
                            <div class="error-text">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                @endforeach
            @endif

            <div class="form-group">
                <label>Departments Manager</label>

                <select id="manager_id" name="manager_id" class="form-control">
                    <option>Select departments manager</option>

                    @foreach ($managers as $manager)
                        @if ($manager->department_id == $department_id)
                            <option value="<?=$manager->id?>" selected>{{$manager->name . ' ' . $manager->last_name}}</option>
                        @else
                            <option value="<?=$manager->id?>">{{$manager->name . ' ' . $manager->last_name}}</option>
                        @endif
                    @endforeach

                </select>
            </div>

            @csrf
            <input class="btn btn-primary" type="submit" value="Change">
        </form>
    </div>

@endsection