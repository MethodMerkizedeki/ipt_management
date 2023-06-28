@extends('layouts.dashboard')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <form action="{{route('ipt.iptlist')}}" method="get">
                    <!-- /.card-header -->
                    <div class="card-body" style="display: block;">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="region" placeholder="Enter Region">
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <!-- /.form-group -->
                                <div class="form-group">
                                <input type="text" class="form-control" name="category" placeholder="Enter category">
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary" value="submit"> Search</button>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>

                </Form>
            </div>
        </div>
    </div>
    <!-- container-fluid -->
</section>

@if(isset($pd))
<div class="row">
    <div class="col-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">IPT LIST</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example2" class="table table-sm table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Description</th>
                            <th>Region</th>
                            <th>Category</th>
                            <th>Vacancy</th>
                            @can('student')
                            <th>Status</th>
                            @endcan
                            @can('ipt_edit','ipt_delete')
                            <th style="width: 150px">Action</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($pd) > 0)
                            @foreach($pd as $pt)
                            <tr>
                                <td>{{++$i}}</td>
                                <td>{{$pt->description}}</td>
                                <td>{{$pt->region}}</td>
                                <td>{{$pt->category}}</td>
                                <td>{{$pt->vacancy}}</td>
                                @can('student')
                                <td>
                                    
                                    <a class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#Apply{{$pt->id}}"
                                      >Apply </a>
                                </td>
                                @endcan
                                @can('ipt_edit','ipt_delete')
                                <td class="project-actions text-right">
                                    <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#edit{{$pt->id}}"
                                        href="#">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Edit
                                    </a>

                                    <a class="btn btn-danger btn-sm" href="{{route('ipt.delete', $pt->id)}}"><i
                                            class="fas fa-trash"></i>Delete
                                    </a>
                                </td>
                                @endcan
                            </tr>
                                <!-- /.modal-dialog -->
                                <div class="modal fade" id="edit{{$pt->id}}" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit IPT</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('ipt.update', $pt->id)}}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for=""> Description</label>
                                                                <input type="hidden" name="id" value="{{$pt->id}}">
                                                                <input type="text" class="form-control" name="description"
                                                                    value="{{$pt->description}}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Region</label>
                                                                <input type="text" class="form-control" name="region"
                                                                    value="{{$pt->region}}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Category</label>
                                                                <input type="text" class="form-control" name="category"
                                                                    value="{{$pt->category}}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="">Vacancy</label>
                                                                <input type="number" class="form-control" name="vacancy"
                                                                    value="{{$pt->vacancy}}" required>

                                                            </div>

                                                            <div class="form-group">
                                                                <input type="hidden" class="form-control" name="status"
                                                                    value="Apply" required>
                                                                <input type="hidden" class="form-control" name="hr"
                                                                    value="{{Auth::user()->email}}" required>
                                                            </div>
                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                    <!-- /.card -->
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-danger"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                                            Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                </div>


                                <div class="modal fade" id="Apply{{$pt->id}}" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-sm modal-success">
                                        <div class="modal-content">

                                            <div class="modal-body">
                                                <form action="{{route('useript.store')}}" method="POST">
                                                    @csrf
                                                    <div class="row">
                                                        <p>Do You want to apply this Industrial Project training 
                                                            click Confinm to submit your Request
                                                        </p>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="hidden" class="form-control" name="hr"
                                                                    value="{{$pt->hr}}" required>
                                                                    <input type="hidden" class="form-control" name="user_id"
                                                                    value="{{Auth::user()->id}}" required>
                                                            </div>
                                                            <div class="form-group">

                                                                <input type="hidden" class="form-control" name="ipt_id"
                                                                    value="{{$pt->id}}" required>
                                                            </div>
                                                            <div class="form-group">

                                                                <input type="hidden" class="form-control" name="remark"
                                                                    value="Reject" required>
                                                            </div>

                                                        </div>
                                                        <!-- /.card-body -->
                                                    </div>
                                                    <!-- /.card -->
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">
                                                            Confirm</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                </div>
                            @endforeach
                        
                        @endif
                </table>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->
@endif
<div class="modal fade" id="add" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add IPT</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('ipt.store')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for=""> Description</label>
                                <input type="text" class="form-control" name="description" placeholder="Description"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="">Region</label>
                                <input type="text" class="form-control" name="region" placeholder="Region" required>
                            </div>
                            <div class="form-group">
                                <label for="">Category</label>
                                <input type="text" class="form-control" name="category" placeholder="Category" required>
                            </div>
                            <div class="form-group">
                                <label for="">Vacancy</label>
                                <input type="number" class="form-control" name="vacancy" placeholder="Vacancy" required>
                            </div>
                            <div class="form-group">
                                <input type="hidden" class="form-control" name="status" value="Apply" required>
                                <input type="hidden" class="form-control" name="hr" value="{{Auth::user()->email}}"
                                    required>

                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
</div>
</div>


@endsection