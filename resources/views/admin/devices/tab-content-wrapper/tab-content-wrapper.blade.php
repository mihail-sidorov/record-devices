@extends('tab-content-wrapper')

@section('filter')
    @include('admin.devices.tab-content-wrapper.__filter')
@endsection

@section('list')
    @include('admin.devices.tab-content-wrapper.__list')
@endsection