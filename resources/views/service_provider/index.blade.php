@php
$role = Session::get('user')['role'];
@endphp
@extends('layout.master')
@section('content')
    @push('css')
        <link rel="stylesheet" href={{ asset('css/admin.css') }}>
        <style>
            .table-comments {
                margin-left: 5%;
            }
            .rate-comment-container{
                font-size: 0.8rem;
            }
            .rate-comment-header{
                white-space: nowrap;
                min-width: 120px;
            }
            .rate-comment-header .created_at{
                width: min-content
            }
        </style>
    @endpush
@section('sidebar')
    @include($role . '.sidebar', ['site' => 'dashboard'])
@endsection
<div class="admin-page  d-flex flex-column w-100 mr-2 ">

    <ul class="nav nav-tabs d-flex justify-content-between">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="{{ route("$role.index") }}"
                        class="text-decoration-none">Home</a>
                </li>
            </ol>
        </nav>

    </ul>
    <h2 class="text-center">@include('icons.company') Nhà xe
        <strong>{{ Session::get('user')['service_provider_name'] }}</strong>
    </h2>
    <div class="d-flex">
        <div style="width:50%;">
            {!! $chartjs->render() !!}
        </div>
        <div style="width:45%;" class="table-comments">
            <table class="table table-sm ml-2 bg-light border-1 align-self-stretch table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Comments({{'*'.$avgAndCount['rate'].', '.$avgAndCount['count']}})</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ratings as $item)
                        
                    <tr>
                        <td>
                            <div class="rate-comment-container d-flex flex-nowrap  ">
                                <div class="rate-comment-header " >
                                    <img class="avatar" width="20px" height="20px" src="{{$item->user->avatar}}"
                                        alt="" srcset="">
                                        <div class="created_at float-right d-inline">{{date("d-m-Y",strtotime($item->created_at))}} </div>

                                    <div>
                                        <div class="name">{{$item->user->name}} </div>
                                        <div class="star">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $item->rate)
                                                        <img src="https://img.icons8.com/emoji/15/000000/star-emoji.png" />
                                                    @else
                                                        <img src="https://img.icons8.com/ios-glyphs/15/CCCCCC/star--v1.png" />
                                                    @endif
                                                @endfor
    
                                        </div>

                                    </div>
                                </div>
                                <div class="rate-commemt-content">
                                    {{$item->comment}}
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('layout.footer')

</div>
<script type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
