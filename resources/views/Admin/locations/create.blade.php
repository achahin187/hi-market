@extends('layouts.admin_layout')

@section('content')


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{ __('admin.add') }}</h1>
                        @include('includes.errors')
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
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('supermarket-admins.index')}}">{{ __('admin.delivery_management') }}</a></li>
                            <li class="breadcrumb-item active">{{ __('admin.add') }}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">

                                        {{ __('admin.add_delivery_admin') }}

                                    
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div id="mapid" style="height: 500px;"></div>
                            <button class="add-polygon">add</button>
                            <form role="form" action=" {{route('supermarket-admins.store') }} " method="POST" enctype="multipart/form-data">
                                @csrf


                                <div class="card-body">

                                     <div class="form-group">
                                        <label>{{ __('admin.city') }}</label>
                                        
                                        <select class=" @error('city_id') is-invalid @enderror select2" name="city_id" data-placeholder="Select a State" style="width: 100%;" required>
                                          
                                            @foreach($cities  as $city)
                                                <option value={{ $city->id }}>
                                               {{ $city['name_'.App()->getLocale()] }}</option>
                                            @endforeach    
                                                
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{ __('admin.area') }}</label>
                                        <input type="email" value="" name="area" class="@error('area') is-invalid @enderror form-control"  placeholder="Enter area" required>
                                        @error('area')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

       


                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">{{ __('admin.add') }}</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>


    @endsection


    @push('scripts')

    <script>
// var mymap = L.map('mapid').setView([30.010, 31.190], 18);

//    L.tileLayer('https://tiles.stadiamaps.com/tiles/outdoors/{z}/{x}/{y}{r}.png', {
//      maxZoom: 10,
//      attribution: 'Rep iN',
//      tileSize: 512,
//      zoomOffset: -1
//    }).addTo(mymap);

//    var polygon = L.polygon([
//      [30.164126, 31.879373],
//      [30.259067, 31.171228],
//      [29.267233, 31.670153]
//  ]).addTo(mymap);

//   var radius = polygon.getRadius(); //in meters
// var circleCenterPoint = polygon.getLatLng(); //gets the circle's center latlng
// var isInCircleRadius = Math.abs(circleCenterPoint.distanceTo(pointToTest)) <= radius;
// console.log(isInCircleRadius);

var map = L.map('mapid', {
  'center': [26.863281, 29.539216],
  'zoom': 6,
  'layers': [
    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      'attribution': 'Map data &copy; OpenStreetMap contributors'
    })
  ]
});





var locationPoint = [];

map.on('click', function (e) {

  var marker = L.marker(e.latlng).addTo(map);

  locationPoint.push(e.latlng)
 

  
  // var result = (circle.getBounds().contains(marker.getLatLng())) ? 'inside': 'outside';
  // marker.bindPopup('Marker ' + result + ' ' );
  // marker.openPopup();
});

 $('.add-polygon').on('click', function(e) {

        e.preventDefault();

        var requestData =JSON.stringify(locationPoint)
       
       
        var url = '{{ route('add-polygon') }}';
        var method ='post';
        $.ajax({
            url: url,
            method: method,
            data:{_token: '{{ csrf_token() }}', 'data':requestData, 'count':locationPoint.length },

            success: function(data) {

             console.log(data);
            }
        })

    });//end of order products click

    </script>
    @endpush


