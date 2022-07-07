@extends('layout.master')
@section('content')
@push('css')
<link rel="stylesheet" href={{asset('css/admin.css')}}>
@endpush
@section('sidebar')
@include('employer.sidebar')
@endsection
<div class="admin-page  d-flex flex-column w-100 mr-2 ">

      <ul class="nav nav-tabs d-flex justify-content-end">
        <li class="nav-item">
          <a class="nav-link active"href={{route('employer.employee.index')}}>Xem</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href={{route('employer.index')}}>Thêm</a>
        </li>
      </ul>
      <h2> Nhà xe <strong>{{Session::get('user')['service_provider_name']}}</strong></h2>
      <div>Danh sách nhân viên</div>
    <table class="table border mb-0 mr-auto bg-light border-1 align-self-stretch">
        <thead class="thead-dark">
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên</th>
                <th scope="col">Email</th>
                <th scope="col">Địa chỉ</th>
                <th scope="col">###</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <th scope="row">{{$employee['id']}}</th>
                    <td>{{$employee['name']}}</td>
                    <td>{{$employee['email']}}</td>
                    <td>{{$employee['address_name']}}</td>

                    {{-- <td>
                      <a class="btn btn-primary btn-sm" href={{route('employer.employee.edit',['id' => $employee['id']])}} role="button">Sửa</a>
                        <form id="delete_form"  method="POST" action={{route('employer.employee.destroy',['id' => $employee['id']])}} >
                          @method('DELETE')
                          <button id="delete_employee" class="btn btn-danger btn-sm" type="submit">
                            Xóa
                          </button>
                        </form>
                    </td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script type="text/javascript">
// const deleteButton=document.querySelector("#delete_provider");
// const form=document.querySelector("#delete_form");

// deleteButton.onclick=(e)=>{
//   e.preventDefault();
// if(window.confirm('Bạn có chắc chắn muốn xóa nhà xe  này?')){
//   form.submit();
// }
// }
  </script>
@endsection
