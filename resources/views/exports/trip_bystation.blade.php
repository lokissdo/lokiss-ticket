@php
$ticketsByStation = [];
foreach ($tickets as $ticket) {
    $ticketsByStation[$ticket['departure_station']['name']][] = $ticket;
    $ticketsByStation[$ticket['arrival_station']['name']][] = $ticket;
}
@endphp
<!DOCTYPE html>
<html lang="en">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{ env('APP_NAME') }}</title>
    <style>
        * {
            font-family: DejaVu Sans !important;
        }

        ;
    </style>
</head>

<body style="            display: flex;
justify-content: center;
font-size: 0.6rem;">
    <div style="    width: 75vw;
    ">
        <table style="width: 100%">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Khởi hành</th>
                    <th scope="col">Ngày Khởi hành</th>
                    <th scope="col">Đến</th>
                    <th scope="col">Thời gian di chuyển</th>
                    <th scope="col">Xe</th>
                    <th scope="col">Giá</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $trip['schedule']['departure_province_name'] }}</td>
                    <td>{{ date('H:i', strtotime($trip['schedule']['departure_time'])) . ' | ' . date('d-m-Y', strtotime($trip['departure_date'])) }}
                    </td>
                    <td>{{ $trip['schedule']['arrival_province_name'] }}</td>
                    <td>{{ $trip['schedule']['hour_duration'] }}
                    </td>
                    <td>{{ $trip['coach']['name'] . ' (' . $trip['coach']['seat_number'] . ' chỗ )' }}</td>
                    <td>{{ number_format($trip['price']) . ' VND' }}</td>
                </tr>
            </tbody>
        </table>

        <table>
            <thead>
                <tr>
                    <th scope="col">Bến</th>
                    <th scope="col">Hàng khách</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($scheduleDetail as $station)
                    <tr>
                        <th scope="row">{{ $station['name'] }}</th>
                        <td
                            style="display: flex;
                flex-wrap:wrap;
                border: 2px solid black;
              margin:10px;
              width:100%;
              padding-top:10px;
                ">
                            @php
                                if (empty($ticketsByStation[$station['name']])) {
                                    continue;
                                }
                            @endphp
                            @foreach ($ticketsByStation[$station['name']] as $ticket)
                                <div
                                    style="    display: inline-block;
                  border: 1px dotted black;
                  border-radius: 10px;
                  width: 250px;
                  height: 120px;
                  margin-right:10px;
                    margin-top:30px
                  
                  ">
                                    @if ($station['name'] == $ticket['departure_station']['name'])
                                        <div style="color:rgb(14, 166, 14);text-align:center">
                                            ĐÓN
                                        </div>
                                    @else
                                        <div style="color:rgb(148, 97, 4);text-align:center">
                                            TRẢ
                                        </div>
                                    @endif
                                    <div style="color:rgb(19, 60, 207)">Mã ghế:<span
                                            style="color:rgb(255, 0, 0)">{{ $ticket['seat_position'] }}</span></div>
                                    <div>Tên: {{ $ticket['user']['name'] }}</div>
                                    <div>Email: {{ $ticket['user']['email'] }}</div>
                                    <div>Sđt: {{ $ticket['user']['phone_number'] }}</div>
                                    <div>Đón :
                                        {{ $ticket['departure_station']['name'] . '(' . $ticket['departure_station']['district_name'] . ',' . $ticket['departure_station']['province_name'] . ')' }}
                                    </div>
                                    <div>Xuống:
                                        {{ $ticket['arrival_station']['name'] . '(' . $ticket['arrival_station']['district_name'] . ',' . $ticket['arrival_station']['province_name'] . ')' }}
                                    </div>
                                </div>
                            @endforeach
                        </td>
                    </tr>
                @endforeach

    </div>

</body>

</html>
