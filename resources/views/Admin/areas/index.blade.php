@extends('layouts.admin_layout')

@section('content')

<div id="mapid" style="height: 500px;"></div>

{{-- 0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 0000 0000 0000 0000 0000
0000 0000 0000 4065 7874 656e 6473 2827
6c61 796f 7574 732e 6164 6d69 6e5f 6c61
796f 7574 2729 0a0a 4073 6563 7469 6f6e
2827 636f 6e74 656e 7427 290a 0a0a 0a20
2020 203c 212d 2d20 436f 6e74 656e 7420
5772 6170 7065 722e 2043 6f6e 7461 696e
7320 7061 6765 2063 6f6e 7465 6e74 202d
2d3e 0a20 2020 203c 6469 7620 636c 6173
733d 2263 6f6e 7465 6e74 2d77 7261 7070
6572 223e 0a20 2020 2020 2020 203c 212d
2d20 436f 6e74 656e 7420 4865 6164 6572
2028 5061 6765 2068 6561 6465 7229 202d
2d3e 0a20 2020 2020 2020 203c 7365 6374
696f 6e20 636c 6173 733d 2263 6f6e 7465
6e74 2d68 6561 6465 7222 3e0a 2020 2020
2020 2020 2020 2020 3c64 6976 2063 6c61
7373 3d22 636f 6e74 6169 6e65 722d 666c
7569 6422 3e0a 2020 2020 2020 2020 2020
2020 2020 2020 3c64 6976 2063 6c61 7373
3d22 726f 7720 6d62 2d32 223e 0a20 2020
2020 2020 2020 2020 2020 2020 2020 2020
203c 6469 7620 636c 6173 733d 2263 6f6c
2d73 6d2d 3622 3e0a 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 3c2f 6469
763e 0a0a 0a20 2020 2020 2020 2020 2020
2020 2020 2020 2020 203c 6469 7620 636c
6173 733d 2263 6f6c 2d73 6d2d 3622 3e0a
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 3c6f 6c20 636c 6173
733d 2262 7265 6164 6372 756d 6220 666c
6f61 742d 736d 2d72 6967 6874 223e 0a20
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 203c 6c69 2063
6c61 7373 3d22 6272 6561 6463 7275 6d62
2d69 7465 6d22 3e3c 6120 6872 6566 3d22
7b7b 726f 7574 6528 2761 7265 6173 2e63
7265 6174 6527 297d 7d22 3e7b 7b5f 5f28
2761 646d 696e 2e61 6464 5f61 7265 6127
297d 7d3c 2f61 3e3c 2f6c 693e 0a20 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 203c 2f6f 6c3e 0a20 2020 2020
2020 2020 2020 2020 2020 2020 2020 203c
2f64 6976 3e0a 0a0a 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 3c64 6976
2063 6c61 7373 3d22 636f 6c2d 3132 223e
0a0a 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 4069 6620 2873
6573 7369 6f6e 2827 7374 6174 7573 2729
290a 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 3c64
6976 2063 6c61 7373 3d22 616c 6572 7420
616c 6572 742d 7375 6363 6573 7320 616c
6572 742d 6469 736d 6973 7369 626c 6520
6661 6465 2073 686f 7722 2072 6f6c 653d
2261 6c65 7274 223e 0a20 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 207b 7b20 7365 7373
696f 6e28 2773 7461 7475 7327 2920 7d7d
0a20 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
203c 6275 7474 6f6e 2074 7970 653d 2262
7574 746f 6e22 2063 6c61 7373 3d22 636c
6f73 6522 2064 6174 612d 6469 736d 6973
733d 2261 6c65 7274 2220 6172 6961 2d6c
6162 656c 3d22 436c 6f73 6522 3e0a 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 3c73 7061 6e20 6172 6961 2d68 6964
6465 6e3d 2274 7275 6522 3e26 7469 6d65
733b 3c2f 7370 616e 3e0a 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 3c2f 6275 7474
6f6e 3e0a 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
3c2f 6469 763e 0a20 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2040
656e 6469 660a 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 3c2f 6469 763e
0a20 2020 2020 2020 2020 2020 2020 2020
203c 2f64 6976 3e0a 2020 2020 2020 2020
2020 2020 3c2f 6469 763e 3c21 2d2d 202f
2e63 6f6e 7461 696e 6572 2d66 6c75 6964
202d 2d3e 0a20 2020 2020 2020 203c 2f73
6563 7469 6f6e 3e0a 0a20 2020 2020 2020
203c 212d 2d20 4d61 696e 2063 6f6e 7465
6e74 202d 2d3e 0a20 2020 2020 2020 203c
7365 6374 696f 6e20 636c 6173 733d 2263
6f6e 7465 6e74 223e 0a20 2020 2020 2020
2020 2020 203c 6469 7620 636c 6173 733d
2263 6f6e 7461 696e 6572 2d66 6c75 6964
223e 0a20 2020 2020 2020 2020 2020 2020
2020 203c 6469 7620 636c 6173 733d 2272
6f77 223e 0a20 2020 2020 2020 2020 2020
2020 2020 2020 2020 203c 6469 7620 636c
6173 733d 2263 6f6c 2d31 3222 3e0a 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 3c64 6976 2063 6c61 7373
3d22 6361 7264 223e 0a20 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 203c 6469 7620 636c 6173 733d
2263 6172 642d 6865 6164 6572 223e 0a20
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 203c
6833 2063 6c61 7373 3d22 6361 7264 2d74
6974 6c65 223e 7b7b 5f5f 2827 6164 6d69
6e2e 6172 6561 7327 297d 7d3c 2f68 333e
0a20 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 203c 2f64
6976 3e0a 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
3c21 2d2d 202f 2e63 6172 642d 6865 6164
6572 202d 2d3e 0a20 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 203c 6469 7620 636c 6173 733d 2263
6172 642d 626f 6479 223e 0a20 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 203c 7461 626c
6520 6964 3d22 6578 616d 706c 6531 2220
636c 6173 733d 2274 6162 6c65 2074 6162
6c65 2d62 6f72 6465 7265 6420 7461 626c
652d 686f 7665 7222 3e0a 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 3c74
6865 6164 3e0a 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 3c74 723e 0a20
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 203c 7468 3e7b 7b5f 5f28
2761 646d 696e 2e6e 616d 655f 6172 2729
7d7d 3c2f 7468 3e0a 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
3c74 683e 7b7b 5f5f 2827 6164 6d69 6e2e
6e61 6d65 5f65 6e27 297d 7d3c 2f74 683e
0a20 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 203c 7468 3e7b 7b5f
5f28 2761 646d 696e 2e63 6974 7927 297d
7d3c 2f74 683e 0a20 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 203c
7468 3e7b 7b5f 5f28 2761 646d 696e 2e63
6f75 6e74 7279 2729 7d7d 3c2f 7468 3e0a
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 3c74 683e 7b7b 5f5f
2827 6164 6d69 6e2e 7374 6174 7573 2729
7d7d 3c2f 7468 3e0a 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
3c74 683e 7b7b 5f5f 2827 6164 6d69 6e2e
636f 6e74 726f 6c73 2729 7d7d 3c2f 7468
3e0a 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 3c2f 7472 3e0a 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
3c2f 7468 6561 643e 0a20 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 203c 7462
6f64 793e 0a20 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2040 666f 7265 6163
6828 2461 7265 6173 2061 7320 2461 7265
6129 0a20 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 203c 7472 3e0a
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 3c74 643e
7b7b 2461 7265 612d 3e6e 616d 655f 6172
7d7d 3c2f 7464 3e0a 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 3c74 643e 7b7b 2461 7265 612d
3e6e 616d 655f 656e 7d7d 3c2f 7464 3e0a
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 3c74 643e
7b7b 2461 7265 612d 3e61 7265 6163 6974
792d 3e6e 616d 655f 6172 7d7d 3c2f 7464
3e0a 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 3c74
643e 7b7b 2461 7265 612d 3e61 7265 6163
6f75 6e74 7279 2d3e 6e61 6d65 5f61 727d
7d3c 2f74 643e 0a20 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 203c 7464 3e0a 0a20 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2040 6966 2824 6172
6561 2d3e 7374 6174 7573 203d 3d20 2761
6374 6976 6527 2029 0a0a 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 3c66
6f72 6d20 6163 7469 6f6e 3d22 7b7b 2072
6f75 7465 2827 6172 6561 732e 7374 6174
7573 272c 2024 6172 6561 2d3e 6964 2920
7d7d 2220 6d65 7468 6f64 3d22 504f 5354
223e 0a0a 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 4063 7372
660a 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 406d 6574 686f
6428 2770 7574 2729 0a20 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
203c 6275 7474 6f6e 2074 7970 653d 2262
7574 746f 6e22 206f 6e63 6c69 636b 3d22
636f 6e66 6972 6d28 277b 7b20 5f5f 2822
4172 6520 796f 7520 7375 7265 2079 6f75
2077 616e 7420 746f 2063 6861 6e67 6520
7374 6174 7573 206f 6620 7468 6973 2072
6561 736f 6e3f 2229 207d 7d27 2920 3f20
7468 6973 2e70 6172 656e 7445 6c65 6d65
6e74 2e73 7562 6d69 7428 2920 3a20 2727
2220 6872 6566 3d22 7b7b 2072 6f75 7465
2827 6172 6561 732e 7374 6174 7573 272c
2024 6172 6561 2d3e 6964 2920 7d7d 2220
636c 6173 733d 2262 746e 2062 746e 2d62
6c6f 636b 2062 746e 2d6f 7574 6c69 6e65
2d73 7563 6365 7373 223e 7b7b 5f5f 2827
6164 6d69 6e2e 6163 7469 7665 2729 7d7d
3c2f 6275 7474 6f6e 3e0a 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 3c2f
666f 726d 3e0a 0a20 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2040 656c 7365 0a0a 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 3c66 6f72 6d20 6163 7469 6f6e 3d22
7b7b 2072 6f75 7465 2827 6172 6561 732e
7374 6174 7573 272c 2024 6172 6561 2d3e
6964 2920 7d7d 2220 6d65 7468 6f64 3d22
504f 5354 223e 0a0a 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
4063 7372 660a 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 406d
6574 686f 6428 2770 7574 2729 0a20 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 203c 6275 7474 6f6e 2074 7970
653d 2262 7574 746f 6e22 206f 6e63 6c69
636b 3d22 636f 6e66 6972 6d28 277b 7b20
5f5f 2822 4172 6520 796f 7520 7375 7265
2079 6f75 2077 616e 7420 746f 2063 6861
6e67 6520 7374 6174 7573 206f 6620 7468
6973 2072 6561 736f 6e3f 2229 207d 7d27
2920 3f20 7468 6973 2e70 6172 656e 7445
6c65 6d65 6e74 2e73 7562 6d69 7428 2920
3a20 2727 2220 6872 6566 3d22 7b7b 2072
6f75 7465 2827 6172 6561 732e 7374 6174
7573 272c 2024 6172 6561 2d3e 6964 2920
7d7d 2220 636c 6173 733d 2262 746e 2062
746e 2d62 6c6f 636b 2062 746e 2d6f 7574
6c69 6e65 2d64 616e 6765 7222 3e7b 7b5f
5f28 2761 646d 696e 2e69 6e61 6374 6976
6527 297d 7d3c 2f62 7574 746f 6e3e 0a20
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 203c 2f66 6f72 6d3e 0a0a 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 4065 6e64
6966 0a0a 0a20 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
203c 2f74 643e 0a20 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 203c 7464 3e0a 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 3c64 6976 2063 6c61
7373 3d22 6472 6f70 646f 776e 223e 0a20
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 203c 6275 7474 6f6e 2074 7970 653d
2262 7574 746f 6e22 2069 643d 2264 726f
7064 6f77 6e4d 656e 7532 2220 6461 7461
2d74 6f67 676c 653d 2264 726f 7064 6f77
6e22 2061 7269 612d 6861 7370 6f70 7570
3d22 7472 7565 2220 6172 6961 2d65 7870
616e 6465 643d 2266 616c 7365 2220 636c
6173 733d 2264 726f 702d 646f 776e 2d62
7574 746f 6e22 3e0a 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
3c69 2063 6c61 7373 3d22 6661 7320 6661
2d65 6c6c 6970 7369 732d 7622 3e3c 2f69
3e0a 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 3c2f 6275 7474 6f6e 3e0a
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 3c64 6976 2063 6c61 7373 3d22
6472 6f70 646f 776e 2d6d 656e 7522 2061
7269 612d 6c61 6265 6c6c 6564 6279 3d22
6472 6f70 646f 776e 4d65 6e75 3222 3e0a
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 3c66 6f72 6d20 6163
7469 6f6e 3d22 7b7b 2072 6f75 7465 2827
6172 6561 732e 6465 7374 726f 7927 2c20
2461 7265 612d 3e69 6429 207d 7d22 206d
6574 686f 643d 2270 6f73 7422 3e0a 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 4063 7372 660a
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 406d 6574
686f 6428 2764 656c 6574 6527 290a 0a20
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 203c 6120 636c
6173 733d 2264 726f 7064 6f77 6e2d 6974
656d 2220 6872 6566 3d22 7b7b 2072 6f75
7465 2827 6172 6561 732e 6564 6974 272c
2024 6172 6561 2d3e 6964 2920 7d7d 223e
7b7b 5f5f 2827 6164 6d69 6e2e 6d6f 6469
6679 2729 7d7d 3c2f 613e 0a0a 0a0a 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 3c62 7574 746f
6e20 7479 7065 3d22 6275 7474 6f6e 2220
636c 6173 733d 2264 726f 7064 6f77 6e2d
6974 656d 2220 6f6e 636c 6963 6b3d 2263
6f6e 6669 726d 2827 7b7b 205f 5f28 2241
7265 2079 6f75 2073 7572 6520 796f 7520
7761 6e74 2074 6f20 6465 6c65 7465 2074
6869 7320 7665 6e64 6f72 3f22 2920 7d7d
2729 203f 2074 6869 732e 7061 7265 6e74
456c 656d 656e 742e 7375 626d 6974 2829
203a 2027 2722 3e7b 7b5f 5f28 2761 646d
696e 2e64 656c 6574 6527 297d 7d3c 2f62
7574 746f 6e3e 0a0a 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
3c2f 666f 726d 3e0a 0a20 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 203c 2f64
6976 3e0a 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 3c2f 6469 763e 0a20 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 203c 2f74 643e 0a20 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 203c 2f74 723e 0a20 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2040
656e 6466 6f72 6561 6368 0a0a 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
3c2f 7462 6f64 793e 0a20 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 203c 2f74 6162 6c65
3e0a 2020 2020 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 3c2f
6469 763e 0a20 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 2020
203c 212d 2d20 2f2e 6361 7264 2d62 6f64
7920 2d2d 3e0a 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 2020 3c2f
6469 763e 0a20 2020 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 203c 212d
2d20 2f2e 6361 7264 202d 2d3e 0a20 2020
2020 2020 2020 2020 2020 2020 2020 2020
203c 2f64 6976 3e0a 2020 2020 2020 2020
2020 2020 2020 2020 2020 2020 3c21 2d2d
202f 2e63 6f6c 202d 2d3e 0a20 2020 2020
2020 2020 2020 2020 2020 203c 2f64 6976
3e0a 2020 2020 2020 2020 2020 2020 2020
2020 3c21 2d2d 202f 2e72 6f77 202d 2d3e
0a20 2020 2020 2020 2020 2020 203c 2f64
6976 3e0a 2020 2020 2020 2020 2020 2020
3c21 2d2d 202f 2e63 6f6e 7461 696e 6572
2d66 6c75 6964 202d 2d3e 0a20 2020 2020
2020 203c 2f73 6563 7469 6f6e 3e0a 2020
2020 2020 2020 3c21 2d2d 202f 2e63 6f6e
7465 6e74 202d 2d3e 0a20 2020 203c 2f64
6976 3e0a 0a40 656e 6473 6563 7469 6f6e
0a0a 0a0a 0a --}}
@php

	$locations = \App\Models\BranchLocation::Where('city','tanta')->get();
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

var map = L.map('mapid', {
  'center': [0, 0],
  'zoom': 0,
  'layers': [
    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      'attribution': 'Map data &copy; OpenStreetMap contributors'
    })
  ]
});

L.Circle.include({
  contains: function (latLng) {
   this.getLatLng().distanceTo(latLng) < this.getRadius();
  }
});

//var circle = L.circle([30.777718, 30.999327], 1000).addTo(map);
  var circle = L.polygon([
  	@foreach ($locations as  $location) 
		
   			 [{{ $location->lat }},  {{ $location->lon }}] ,
	
	@endforeach
          
]).addTo(map);

map.fitBounds(circle.getBounds());

map.on('click', function (e) {
  var marker = L.marker(e.latlng).addTo(map);
  //console.log(marker.getLatLng(), circle.getBounds().contains(marker.getLatLng()));
  var result = (circle.getBounds().contains(marker.getLatLng())) ? 'inside': 'outside';
  marker.bindPopup('Marker ' + result + ' of the circle');
  marker.openPopup();
});
</script>
@endpush
@endsection
{{-- 
