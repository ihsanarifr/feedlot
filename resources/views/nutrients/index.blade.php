@extends('layouts.app')

@section('title')
  Nutrisi - Admin {{ config('configuration.site_name') }}
@endsection

@section('content')
  <div class="container">
    <div class="row">
        @include('layouts.menu')
      <div class="col-md-9">
        <ul class="breadcrumb">
          <li><a href="{{ url('/home') }}">Dashboard</a></li>
          <li class="active">Nutrient</li>
        </ul>
        <div class="panel panel-default">
          <div class="panel-heading">
            <div class="btn-group pull-right">
                <a class="btn btn-primary btn-sm" href="{{ route('nutrients.create') }}"><i class="fa fa-pencil"></i> Tambah</a>
            </div>
            <h2 class="panel-title" style="padding-bottom:5px;padding-top:5px;">Nutrient</h2>
          </div>
          <div class="panel-body">
            {!! $html->table(['class'=>'table table-striped table-hover']) !!}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  {!! $html->scripts() !!}
@endsection
