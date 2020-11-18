@extends('layouts.admin_layout')

@section('content')



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>DataTables</h1>
                    </div>

                    @if(auth()->user()->can('admin-create'))
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                               
                             

                                    @csrf

                                    <input type="file" name="file" accept=".csv"/>

                                    <button type="submit" class="btn btn-primary">import</button>

                                </form>
                            </ol>
                        </div>

                        -->
                    @endif

                    <div class="col-12">

                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">delivery</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>name</th>
                                        <th>email</th>
                                        <th>Role</th>
                           
                                        <th>status</th>
                                    
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($delivery as $admin)
                                        <tr>
                                            <td>{{$admin->name}}</td>
                                            <td>{{$admin->email}}</td>
                                            <td>

                                                @foreach($admin->roles as $role)

                                                    @if(App::getLocale() == 'ar')

                                                        [{{$role->arab_name}}]

                                                    @else

                                                        [{{$role->eng_name}}]

                                                    @endif

                                                @endforeach

                                            </td>


                                               


                                            @if($admin->orders->count() == 0)

                                                <td>available</td>

                                            @else

                                                <td>not available</td>

                                            @endif
                                            
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

@endsection

