@extends('layout.master')
@section('content')
    <table class="table border mb-0 bg-light border-1">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tên</th>
                <th scope="col">Số điện thoại</th>
                <th scope="col">Đánh giá</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($providers as $provider)
                <tr>
                    <th scope="row">{{$provider['id']}}</th>
                    <td>{{$provider['name']}}</td>
                    <td>{{$provider['phone_number']}}</td>
                    <td>{{$provider['rate']}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


@stop
