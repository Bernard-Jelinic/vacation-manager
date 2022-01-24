@extends('dashboards.admins.index')

@section('managedepartments')
    {{-- manage departments --}}


                <div class="row">
                    {{-- <div class="col-md-12"> --}}
                        {{-- <h2>{{$page_title}}</h2> --}}
                        {{-- <a href="{{url('admin/posts/add')}}">
                            <button class="btn btn-primary btn-sm" style="float:right"><i class="fa fa-plus"></i> Add Post</button>
                        </a>
                    </div> --}}

                <table class="table table-striped table-hover">
                    <thead>
                        {{-- <tr><th>Title</th><th>Department</th><th>Featured Image</th><th>Date</th><th>Action</th></tr> --}}
                        <tr><th>Department</th><th>Managers name</th><th>Action</th></tr>
                    </thead>
                    <tbody>
                        @if ($departments)
                            @foreach ($departments as $department)
                            {{-- {{print_r($department)}} --}}
                                {{-- <tr><td>{{$row->title}}</td><td>{{$row->category}}</td><td><img src="{{url($row->image)}}" style="width: 150px;"/></td><td>{{date("jS M, Y",strtotime($row->created_at))}}</td> --}}
                                <tr><td>{{$department->department_name}}</td><td>{{$department->user_name . ' ' . $department->last_name}}</td>
                                    <td>

                                        {{-- <a href="{{route('edit/'.$department->department_id)}}"> --}}
                                        
                                        <a href="{{url('admin/managedepartments/edit/'.$department->department_id)}}">
                                            <button class="btn-sm btn btn-success"><i class="fa fa-edit"></i> Edit</button>
                                        </a>
                                            <form action="{{url('admin/managedepartments/delete/'.$department->department_id)}}" method="post">
                                            @csrf
                                            {{-- <a href="{{url('admin/managedepartments/delete/'.$department->department_id)}}"> --}}
                                                <button type="submit" class="btn-sm btn btn-warning"><i class="fa fa-times"></i> Delete</button>
                                            {{-- </a> --}}
                                                {{-- <input class="btn btn-danger" style="float:right;" type="submit" value="Delete"> --}}
                                                {{-- <a href="{{url('admin/managedepartments/delete/'.$department->department_id)}}">
                                                    <input class="btn btn-success" type="button" value="Back">
                                                </a> --}}
                                        </form>


                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                {{-- @include('pagination') --}}
                </div>


@endsection