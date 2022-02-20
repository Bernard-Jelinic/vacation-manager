@extends('dashboards.admins.index')

@section('editvacation')

    <div class="container-fluid col-lg-5">
        <form method="post" enctype="multipart/form-data"><br>

            <h3>Edit Vacation</h3><br>

            @if ($vacation_data)
                @foreach ($vacation_data as $key)

                    <div class="form-group">
                        <label>Users Name</label>
                        <h4>{{$key->name . ' ' . $key->last_name}}</h4>
                    </div>

                    <div class="form-group">
                        <label>Depart date</label>
                        <h4>{{$key->depart}}</h4>
                    </div>

                    <div class="form-group">
                        <label>Return date</label>
                        <h4>{{$key->return}}</h4>
                    </div>

                    <div class="form-group">
                        <label>Vacation Status</label>
                    
                            @csrf
                            <select name="status" class="form-control">
                                @if ($key->status == 0)
                                    <option value="0"selected>Waiting for approval</option>
                                    <option value="1">Approved</option>
                                    <option value="2">Not Approved</option>

                                @elseif ($key->status == 1)
                                    <option value="0">Waiting for approval</option>
                                    <option value="1" selected>Approved</option>
                                    <option value="2">Not Approved</option>
                                    
                                @else
                                    <option value="0">Waiting for approval</option>
                                    <option value="1">Approved</option>
                                    <option value="2" selected>Not Approved</option>
                                @endif
                            </select>
                                
                    </div>

                @endforeach
            @endif

            <input class="btn btn-primary" type="submit" value="Change">

        </form>
    </div>

@endsection