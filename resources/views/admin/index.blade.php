@extends('layout.master')
@section('content')
@push('css')
<link rel="stylesheet" href={{asset('css/admin.css')}}>
@endpush
@section('sidebar')
@include('admin.sidebar',['site'=>'index'])
@endsection
<div class="admin-page  d-flex flex-column w-100 mr-2 ">

      <ul class="nav nav-tabs d-flex justify-content-end">
        <li class="nav-item">
          <a class="nav-link active"href={{route('admin.provider.index')}}>Xem</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href={{route('admin.provider.create')}}>Thêm</a>
        </li>
      </ul>
      
</div>
    


@stop
