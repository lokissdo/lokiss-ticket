@extends('layout.master')
@section('content')
@push('css')
<link rel="stylesheet" href={{asset('css/admin.css')}}>
@endpush
@section('sidebar')
@include('employee.sidebar',['site'=>'index'])
@endsection

<div class="admin-page  d-flex flex-column w-100 mr-2 ">
   
      
</div>
    


@stop
