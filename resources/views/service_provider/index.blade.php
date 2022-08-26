@php
$role = Session::get('user')['role'];
@endphp
@extends('layout.master')
@section('content')
    @push('css')
        <link rel="stylesheet" href={{ asset('css/admin.css') }}>
        <link rel="stylesheet" href={{ asset('css/service_provider/index.css') }}>
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
    <div class="row">
        <div class="col-md-6 col-xl-4">
            <div class="card mb-3 widget-content bg-premium-dark">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Total Revenues</div>
                        <div class="widget-subheading">Today </div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-warning"><span>{{number_format($revenues['day'])}} VNĐ</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4">
            <div class="card mb-3 widget-content bg-grow-early ">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Total Revenues</div>
                        <div class="widget-subheading">This week </div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span>{{number_format($revenues['week'])}} VNĐ</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class=" col-md-6 col-xl-4">
            <div class="card mb-3 widget-content bg-arielle-smile">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Total Revenues</div>
                        <div class="widget-subheading">This Month</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span>{{number_format($revenues['month'])}} VNĐ</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class=" d-lg-block offset-xl-4 col-md-6 col-xl-4">
            <div class="card mb-3 widget-content bg-midnight-bloom">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Tickets Sold Today</div>
                        <div class="widget-subheading">Incomings streams</div>
                    </div>
                    <div class="widget-content-right">
                      <div class="widget-numbers text-white">  <span>{{$totalTickets}}</span><img src="https://img.icons8.com/ios-filled/20/FFFFFF/ticket-confirmed.png" alt="" srcset=""></div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="d-flex justify-content-center mb-5">
        <div style="width:70%" class="chart rounded shadow">
            {!! $chartDay->render() !!}
        </div>
    </div>
    <div class="d-flex ">
        <div style="width:50%;" class="chart rounded shadow">
            {!! $chartWeek->render() !!}
        </div>
        <div style="width:45%;">
            <table
                id="table-comments"class="table table-sm ml-2 bg-light border-1 align-self-stretch table-hover rounded shadow">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Comments({{ '*' . $avgAndCount['rate'] . ', ' . $avgAndCount['count'] }}
                            reviews)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ratings as $item)
                        <tr>
                            <td>
                                <div class="rate-comment-container d-flex flex-nowrap  ">
                                    <div class="rate-comment-header ">
                                        <img class="avatar" width="20px" height="20px"
                                            src="{{ $item->user->avatar }}" alt="" srcset="">
                                        <div class="created_at float-right d-inline">
                                            {{ date('d-m-Y', strtotime($item->created_at)) }} </div>
                                        <div>
                                            <div class="name">{{ $item->user->name }} </div>
                                            <div class="star">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $item->rate)
                                                        <img
                                                            src="https://img.icons8.com/emoji/15/000000/star-emoji.png" />
                                                    @else
                                                        <img
                                                            src="https://img.icons8.com/ios-glyphs/15/CCCCCC/star--v1.png" />
                                                    @endif
                                                @endfor

                                            </div>
                                        </div>
                                    </div>
                                    <div class="rate-commemt-content">
                                        {{ $item->comment }}
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
