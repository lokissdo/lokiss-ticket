@extends('layout.master')
@section('content')
    @push('css')
        <link rel="stylesheet" href={{ asset('css/admin/provider_create.css') }}>
    @endpush
@section('sidebar')
@include('employer.sidebar',['site'=>'coach'])

@endsection
<div class="admin-page  d-flex flex-column w-100 mr-2 ">
    <ul class="nav nav-tabs d-flex justify-content-end">
        <li class="nav-item">
            <a class="nav-link " id="show_list"href={{route('serviceprovider.coach.index')}}>Xem</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href={{route('employer.coach.create')}}>Thêm</a>
          </li>
    </ul>

    <form action="{{ route('employer.coach.store') }}" method="GET">
        <div class="container mt-5 mb-5 d-flex justify-content-center">
            <div class="card px-1 py-4">
                <div class="card-body">
                    <div class="card-body min-20 px-md-5" id="message_display">                 
                      </div>
                    <h2 class="card-title mb-3 text-center">Thêm Xe Khách</h2>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                               <input class="form-control" name="name"type="text"
                                    placeholder="Name">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="input-group"> <input class="form-control" name="seat_number" type="number" min="10" max="50"
                                        placeholder="Seat Number">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="input-group"> <select name="type" class="form-select " >
                                    @foreach ($coach_types as $key=>$val)
                                    <option  class="input-group form-control" value="{{$val}}"> {{$key}} </option>
                                    @endforeach
                                       
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" d-flex flex-column text-center px-5 mt-3 mb-3">
                        <small class="agree-text">By submitting this form you agree to the</small>
                        <a href="#" class="terms">Terms & Conditions</a>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block confirm-button w-100">Confirm</button>
                </div>
            </div>
        </div>
    </form>
</div>
@push('js')
    <script>const object="Xe khách";</script>
    <script src="{{ asset('js/components/create_object.js') }}"></script>
@endpush


@stop
