@extends('layouts.app')

@section('title')
  Tambah Album - Admin {{ config('configuration.site_name') }}
@endsection

@section('content')
  <div class="container">
    <div class="row">
      @include('layouts.menu')
      <div class="col-md-9">
        <ul class="breadcrumb">
          <li><a href="{{ url('/home') }}">Dashboard</a></li>
          <li><a href="{{ url('/admin/album') }}">Album</a></li>
          <li class="active">Tambah Album</li>
        </ul>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h2 class="panel-title">Tambah Album</h2>
        </div>
        <div class="panel-body">
        {!! Form::open(['url' => route('album.store'),'method' => 'post', 'files'=>'true', 'class'=>'form-horizontal']) !!}
        @include('admin.album._form')
        {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

