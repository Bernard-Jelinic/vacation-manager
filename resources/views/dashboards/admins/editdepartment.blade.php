@extends('dashboards.admins.index')

@section('editdepartments')

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

            @if ($department)
                @foreach ($department as $key)

                    <div class="form-group">
                        <label>Department Name</label>
                        <input value="{{$key->name}}" id="name" type="text" class="form-control" placeholder="Department Name" name="name" required autofocus>
                    </div>

                @endforeach
            @endif

            <div class="form-group">
                <label>Department Manager</label>

                <select id="manager_id" name="manager_id" class="form-control" required>

                    <?php if(is_array($managers)): ?>
                        <?php foreach($managers as $manager): ?>
                            @foreach ($department as $key)

                                @if ($key->manager_id == $manager->id)
                                    <option value="<?=$manager->id?>" selected>{{$manager->name . ' ' . $manager->last_name}}</option>
                                @else
                                    <option value="<?=$manager->id?>">{{$manager->name . ' ' . $manager->last_name}}</option>
                                @endif
                            @endforeach
                            
                        <?php endforeach; ?>
                    <?php endif; ?>

                </select>
            </div>

            @csrf
            <input class="btn btn-primary" type="submit" value="Change">
        </form>
    </div>

@endsection