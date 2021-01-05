
@extends('layouts.admin_layout')

@section('content')



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('admin.contact-us') }}</h1>
                    </div>


                       {{--  <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                @if(auth()->user()->can('location-create'))
                                <li class="breadcrumb-item"><a href="{{route('locations.create')}}">{{ __('admin.add_new_area') }}</a></li>
                                @endif
                            </ol>
                        </div> --}}


                    <div class="col-12">

                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" admin="alert">
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
                                <h3 class="card-title">{{ __('admin.contact-us') }}</h3>
                            </div>
                                
                            <div id="success" class="hidden">
                              <p id="message" ></p>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                 <table id="example20" class="table table-bordered table-hover">

                                  <thead>
                                      <tr>
                                          <th>#</th>
                                          <th>الاسم</th>
                                         <th>النعوان</th>
                                          <th>الحالة</th>
                                          <th>الاكشن</th>
                                      </tr>
                                  </thead>

                        @foreach($inboxes as $index=>$inbox)
                              <tr id="tr{{ $inbox->id }}" style="background-color: {{$inbox->statuse == 0 ? '#d2cccc' :'#fffcfc'   }}">
                                  <td>{{ $index + 1 }}</td>
                                  <td>{{ $inbox->name }}</td>
                                  <td>{{ $inbox->title }}</td>
                                
                                  <td>
                                  <span class="badge badge-{{ $inbox->statuse == 0 ? 'danger' :'success' }}" id="read{{ $inbox->id }}">{{ $inbox->statuse == 0 ? 'unread' :'read' }}</span>
                                  </td>
                                  
                                      <!-- Delete button -->
                                     
                                  <td>
                                      <form action='{{route('inboxes.destroy',$inbox->id)}}' method="post" style="display: inline-block;">
                                          {{ csrf_field() }}
                                          {{ method_field('delete') }}
                                          <button type="button"  class="btn btn-danger btn-xs delete delete"data-url="{{ route('inboxes.destroy', $inbox->id) }}"
                                          data-id ="{{ $inbox->id }}"
                                      >
                                      <i class="fa fa-trash"></i>
                                      </button>
                                      </form>
                                

                                                          <!-- Button trigger modal  Show-->
                                                  
                                <button type="button" class="btn btn-success btn-xs success statuse" data-toggle="modal" data-target="#exampleModalCenter-{{ $inbox->id }}"
                                data-url="{{ route('inboxes.update', $inbox->id) }}"
                                data-id ="{{ $inbox->id }}"
                                >
                                <i class="fa fa-eye"></i>
                                </button>
                                
                                <!-- Modal -->
                                <div class="modal fade" id="exampleModalCenter-{{ $inbox->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header" style="background-color: #57a0ca">
                                    <h5 class="modal-title" id="exampleModalLongTitle" style="color: white">Message</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <p>{{ $inbox->message }}</p>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  </div>
                                </div>
                                </div>
                                </div>

                          
                            </td>
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





@push('scripts')

<script>
    $(document).ready(function () {


 
    $('.statuse').on('click', function(e) {

        e.preventDefault();

        var url = $(this).data('url');
        var id = $(this).data('id');
       
        //var method = $(this).data('method');
        $.ajax({
            url: url,
            type:"PUT",
            headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             },
                
            success: function(data) {
                
               $('#read'+id).removeClass('label label-danger').addClass('label label-success');
               $('#read'+id).html('read');
               $('#tr'+id).css('background-color','#fffcfc');
               $('#inbox-count').html( data );
               
                

            }
        });
});//end of statuse read change




    $('.delete').on('click', function(e) {

        e.preventDefault();


        var that = $(this)
        var url = $(this).data('url');
        var id = $(this).data('id');
        var hid = function(){
          $('#success').removeClass('alert alert-success');
            $('#success').addClass('hidden');
        };

                          $.ajax({
                              url: url,
                              type:"DELETE",
                              headers: {
                             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                               },
                                  
                              success: function(data) {
                                
                                 $('#tr'+id).slideUp(300);
                                 $('#success').removeClass('hidden');
                                 $('#message').css('font-size','20px');
                                 $('#message').css('margin-left','247px');
                                 $('#message').html(data.success);
                                 $('#success').addClass('alert alert-success');

                                 setTimeout(hid, 4000);

                              }
                          });

        
        //var method = $(this).data('method');
    
});//end of delete  inbox  




});
  
</script>
@endpush