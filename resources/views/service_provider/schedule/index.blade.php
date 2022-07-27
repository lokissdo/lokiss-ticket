@extends('layout.master')
@section('content')
@push('css')
<link rel="stylesheet" href={{asset('css/admin.css')}}>
<link rel="stylesheet"  href={{asset('css/admin/show_scheDetail.css')}}>
@endpush
@section('sidebar')
@include(Session::get('user')['role'].'.sidebar',['site'=>'schedule'])
@endsection
<div class="admin-page  d-flex flex-column w-100 mr-2 ">

      <ul class="nav nav-tabs d-flex justify-content-end">
        <li class="nav-item">
          <a class="nav-link active"href={{route('serviceprovider.schedule.index')}}>Xem</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href={{route('serviceprovider.schedule.create')}}>Thêm</a>
        </li>
      </ul>
      <h2> Nhà xe <strong>{{Session::get('user')['service_provider_name']}}</strong></h2>
      <div>Danh sách lịch trình</div>
      @foreach ($schedule_details as $id=> $stations)
      <div class="modal" id="{{$id}}">
        <div class="modal-bg modal-exit"></div>
        <div class="modal-container">
          <h1>ID: {{$id}}</h1>
          @foreach ($stations as $key=>$each)
         <span>{{$each['name']}} ({{$each['district_name']}},{{$each['province_name']}})</span>
          @if($key != count($stations)-1)
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="blue" class="bi bi-arrow-right" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
          </svg>
          @endif
        
         @endforeach
          
          <button class="modal-close modal-exit">X</button>
        </div>
      </div>
      @endforeach
     

    <table class="table border mb-0 mr-auto bg-light border-1 align-self-stretch">
        <thead class="thead-dark">
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Giờ khởi hành</th>
                <th scope="col">Địa điểm khởi hành</th>
                <th scope="col">Giờ đến</th>
                <th scope="col">Địa điểm đến</th>
                <th scope="col">Số ngày di chuyển</th>
                <th scope="col">###</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($schedules as $schedule)
                <tr>
                    <th scope="row">{{$schedule['id']}}</th>
                    <td>{{$schedule['departure_time_str']}}</td>
                    <td>{{$schedule['departure_province']}}</td>
                    <td>{{$schedule['arrival_time_str']}}</td>
                    <td>{{$schedule['arrival_province']}}</td>
                    <td>{{$schedule['total_days']}}</td>

                    <td>
                      <div class="d-flex">
                        <form id="delete_form"  method="POST" action={{route('serviceprovider.schedule.destroy',['id' => $schedule['id']])}} >
                          @method('DELETE')
                          <button id="delete_schedule" class="btn btn-danger btn-sm" type="submit">
                            Xóa
                          </button>
                        </form>
                        <button data-modal="{{$schedule['id']}}" class="btn btn-primary btn-sm">Chi tiết </button>
                      </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script type="text/javascript">
const deleteButtons=document.querySelectorAll("#delete_schedule");
deleteButtons.forEach(deleteButton => {
        deleteButton.onclick = (e) => {
            e.preventDefault();
            if (window.confirm('Bạn có chắc chắn muốn xóa nhân viên  này?')) {
              e.target.parentNode.submit();
            }
        }
    });
  </script>
<script src="{{ asset('js/service_provider/show_scheDetail.js') }}"></script>
@endsection
