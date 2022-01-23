@extends('dashboards.admins.index')

@section('adddepartment')

                        <div class="container-fluid col-lg-12">
                        <form method="post" enctype="multipart/form-data">

                            @if ($errors->all())
                                <div class="alert alert-danger text-center">
                                    @foreach ($errors->all() as $error)
                                        {{$error}}<br>
                                    @endforeach
                                </div>
                            @endif

                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Department Name</label>
                                <div class="col-sm-10">
                                    <input value="{{old('name')}}" id="name" type="text" class="form-control" placeholder="Department Name" name="name" required autofocus><br>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Department Manager</label>
                                <div class="col-sm-10">
                                    <select id="manager_id" name="manager_id" required>
                                        <option></option>
                                        <?php if(is_array($managers)): ?>
                                            <?php foreach($managers as $manager): ?>

                                                <option value="<?=$manager->id?>"><?=$manager->name?></option>

                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>

                            @csrf
{{-- 
                            <a href="{{route('add')}}">
                                <input class="btn btn-primary" type="submit" value="Post">
                            </a> --}}

                            <input class="btn btn-primary" type="submit" value="Post">
                        </form>
                    </div>


{{--  --}}

            {{-- <main class="mn-inner">
                <div class="row">
                    <div class="col s12">
                        <div class="page-title">Manage Departments</div>
                    </div>
                    <div class="col s12 m12 l12">
                        <div class="card">
                            <div class="card-content">
                                <span class="card-title">Departments Info</span>
                                    <table id="example" class="display responsive-table ">
                                    <thead>
                                        <tr>
                                            <th>Sr no</th>
                                            <th>Dept Name</th>
                                            <th>Dept Short Name</th>
                                            <th>Dept Code</th>
                                            <th>Creation Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                 
                                    <tbody>
  
                                        <tr>
                                            <td> 1</td>
                                            <td>Human Resource</td>
                                            <td>HR</td>
                                            <td>HR001</td>
                                            <td>2021-04-01 09:16:25</td>
                                            <td><a href="editdepartment.php?deptid=1"><i class="material-icons">mode_edit</i></a><a href="managedepartments.php?del=1" onclick="return confirm('Do you want to delete');"> <i class="material-icons">delete_forever</i></a></td>
                                        </tr>
                                           
                                        <tr>
                                            <td> 2</td>
                                            <td>Information Technology</td>
                                            <td>IT</td>
                                            <td>IT001</td>
                                            <td>2021-04-01 09:19:37</td>
                                            <td><a href="editdepartment.php?deptid=2"><i class="material-icons">mode_edit</i></a><a href="managedepartments.php?del=2" onclick="return confirm('Do you want to delete');"> <i class="material-icons">delete_forever</i></a></td>
                                        </tr>
                                           
                                        <tr>
                                            <td> 3</td>
                                            <td>Operations</td>
                                            <td>OP</td>
                                            <td>OP1</td>
                                            <td>2021-04-02 23:28:56</td>
                                            <td><a href="editdepartment.php?deptid=3"><i class="material-icons">mode_edit</i></a><a href="managedepartments.php?del=3" onclick="return confirm('Do you want to delete');"> <i class="material-icons">delete_forever</i></a></td>
                                        </tr>
                                                                             </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main> --}}

{{--  --}}





@endsection