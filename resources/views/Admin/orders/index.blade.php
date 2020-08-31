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
                                <h3 class="card-title">Orders</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>address</th>
                                        <th>status</th>
                                        <th>controls</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{$order->address}}</td>
                                            <td>
                                                @if($order->status == '1' )

                                                    <form action="{{ route('orders.status', $order->id) }}" method="POST">

                                                        @csrf
                                                        @method('put')
                                                        <input type="hidden" value="1" name="favourite" class="btn btn-default btn-enroll">
                                                        <button type="button" onclick="confirm('{{ __("Are you sure you want to change status of this order?") }}')" href="{{route('orders.status', $order->id)}}" class="btn btn-block btn-outline-success">delivered</button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('orders.status', $order->id) }}" method="POST">

                                                        @csrf
                                                        @method('put')
                                                        <input type="hidden" value="1" name="favourite" class="btn btn-default btn-enroll">
                                                        <button type="button" onclick="confirm('{{ __("Are you sure you want to change status of this order?") }}') ? this.parentElement.submit() : ''" href="{{route('orders.status', $order->id)}}" class="btn btn-block btn-outline-danger">not delivered</button>
                                                    </form>                                                @endif

                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="drop-down-button">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                        <form action="{{ route('orders.delete', $order->id) }}" method="post">
                                                            @csrf
                                                            @method('delete')

                                                            <a class="dropdown-item" href="{{ route('orders.edit', $order->id) }}">{{ __('edit') }}</a>
                                                            <button type="button" class="dropdown-item" onclick="confirm('{{ __("Are you sure you want to delete this order?") }}') ? this.parentElement.submit() : ''">{{ __('delete') }}</button>
                                                        </form>

                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end w-100">
                                        <nav aria-label="Page navigation example">
                                            {{ $orders->links() }}
                                        </nav>
                                    </div>
                                </div>
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




<!-- jQuery -->
<script src="{{ asset('plugins') }}/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins') }}/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="{{ asset('plugins') }}/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('plugins') }}/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('plugins') }}/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('plugins') }}/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist') }}/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist') }}/js/demo.js"></script>
<!-- page script -->
<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
    });
</script>
</body>
</html>
