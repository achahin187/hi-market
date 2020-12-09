@extends('layouts.admin_layout')

@section('content')

<div id="mapid" style="height: 500px;"></div>


@php

	$locations = \App\Models\polygon::Where('area_id',2)->get();
	

		// foreach ($locations as $key => $location) {

  //  			dd(   $location->lat ,   $location->lat  );
		// }
		
	
	
@endphp

@push('scripts')
  {{-- maps --}}

<script>
  
// var mymap = L.map('mapid').setView([30.010, 31.190], 18);

//   L.tileLayer('https://tiles.stadiamaps.com/tiles/outdoors/{z}/{x}/{y}{r}.png', {
//     maxZoom: 10,
//     attribution: 'Rep iN',
//     tileSize: 512,
//     zoomOffset: -1
//   }).addTo(mymap);

//   var polygon = L.polygon([
//     [30.164126, 31.879373],
//     [30.259067, 31.171228],
//     [29.267233, 31.670153]
// ]).addTo(mymap);

//   var radius = polygon.getRadius(); //in meters
// var circleCenterPoint = polygon.getLatLng(); //gets the circle's center latlng
// var isInCircleRadius = Math.abs(circleCenterPoint.distanceTo(pointToTest)) <= radius;
// console.log(isInCircleRadius);

// var map = L.map('mapid', {
//   'center': [26.863281, 29.539216],
//   'zoom': 6,
//   'layers': [
//     L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//       'attribution': 'Map data &copy; OpenStreetMap contributors'
//     })
//   ]
// });

// L.Circle.include({
//   contains: function (latLng) {
//    this.getLatLng().distanceTo(latLng) < this.getRadius();
//   }
// });

var circle = L.circle([30.777718, 30.999327], 1000).addTo(map);
  var circle = L.polygon([
  	@foreach ($locations->city->locations as  $location) 
		
   			 [{{ $location->lat }},  {{ $location->lon }}] ,
	
	@endforeach
          
]).addTo(map);

map.fitBounds(circle.getBounds());

var locationPoint = [];

map.on('click', function (e) {

  var marker = L.marker(e.latlng).addTo(map);

  locationPoint.push(e.latlng)
 

  
  var result = (circle.getBounds().contains(marker.getLatLng())) ? 'inside': 'outside';
  marker.bindPopup('Marker ' + result + ' ' );
  marker.openPopup();
});





	// var mymap = L.map('mapid').setView([26.863281, 29.539216], 6);

	// L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
	// 	maxZoom: 18,
	// 	attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
	// 		'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
	// 	id: 'mapbox/streets-v11',
	// 	tileSize: 512,
	// 	zoomOffset: -1
	// }).addTo(mymap);

	

	// L.polygon([
	// 		@foreach ($locations as  $location) 
			
 //    			 [{{ $location->lat }},  {{ $location->lon }}] ,
	
 // 			@endforeach
	// ]).addTo(mymap).bindPopup("inside ");


	// var popup = L.popup();

	// function onMapClick(e) {
	// 	popup
	// 		.setLatLng(e.latlng)
	// 		.setContent("outside"+ "" )
	// 		.openOn(mymap);
	// }

	// mymap.on('click', onMapClick);


</script>


@endpush
<button class="add-polygon">add</button>
@endsection
{{-- 
