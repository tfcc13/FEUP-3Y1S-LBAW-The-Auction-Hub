@extends('layouts.user')

@section('left')
@include('components.user.profileLeft')
@endsection

@section('right')
@include('components.user.dashboardRight')
@endsection
