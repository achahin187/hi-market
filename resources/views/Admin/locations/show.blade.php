@extends('layouts.admin_layout')

@section('content')
  <div id="mapid" style="height: 500px;"></div>
@endsection

@push('scripts')
  {{-- maps --}}

<script>
  
// var mymap = L.map('mapid').setView([30.010, 31.190], 6);

//   L.tileLayer('https://tiles.stadiamaps.com/tiles/outdoors/{z}/{x}/{y}{r}.png', {
//     maxZoom: 10,
//     attribution: 'Rep iN',
//     tileSize: 512,
//     zoomOffset: -1
//   }).addTo(mymap);

// var map = L.map('mapid', {
//   'center': [26.863281, 29.539216],
//   'zoom':3,
//   'layers': [
//     L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//       'attribution': 'Map data &copy; OpenStreetMap contributors'
//     })
//   ]
// });


// var circle = L.circle([30.777718, 30.999327], 1000).addTo(map);
//   var circle = L.polygon([
//   	oreach ($polygons as  $location) 
		
//    			 [{ $location->lat }},  { $location->lon }}] ,

// 	endforeach
          
// ]).addTo(map);

// map.fitBounds(circle.getBounds());

// var locationPoint = [];

// map.on('click', function (e) {

//   var marker = L.marker(e.latlng).addTo(map);

//   locationPoint.push(e.latlng)
 

  
//   var result = (circle.getBounds().contains(marker.getLatLng())) ? 'inside': 'outside';
//   marker.bindPopup('Marker ' + result + ' ' );
//   marker.openPopup();
// });

@php
	print_r($polygons) ;
@endphp



	var mymap = L.map('mapid').setView([{{ $polygons[0][0] }}, {{   $polygons[0][0] }}], 7);

	L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		maxZoom: 18,
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox/streets-v11',
		tileSize: 512,
		zoomOffset: -1
	}).addTo(mymap);

	

	L.polygon([
			@foreach ($polygons as  $location) 
			
    			 [{{  $location->lat }},  {{   $location->lon }}] ,
	
 			@endforeach
	]).addTo(mymap).bindPopup("inside ");


	var popup = L.popup();

	function onMapClick(e) {
		popup
			.setLatLng(e.latlng)
			.setContent("outside"+ "" )
			.openOn(mymap);
	}

	mymap.on('click', onMapClick);


</script>


@endpush