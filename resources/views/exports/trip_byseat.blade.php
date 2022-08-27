@php
$seats = [];
foreach ($tickets as $ticket) {
    $seats[$ticket['seat_position']] = $ticket;
}
$seat_number = $trip['coach']['seat_number'];

@endphp
<!DOCTYPE html>
<html lang="en">

<head>
  
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{env('APP_NAME')}}</title>
    <style>
        * {
            font-family: DejaVu Sans !important;
        }
        ;
    </style>
</head>

<body style="            display: flex;
justify-content: center;
font-size: 0.7rem;" >
    <div style="    width: 75vw;
    ">
        <table style="width: 100%">
            <thead   >
                <tr >
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
                    <td>{{ $trip['coach']['name'] . ' (' . $seat_number . ' chỗ )' }}</td>
                    <td>{{ number_format($trip['price']) . ' VND' }}</td>
                </tr>
            </tbody>
        </table>

        <div style="    display: flex; margin-top:50px; width: 100%;
       flex-wrap: wrap;
      ;">

            @for ($i = 1; $i <= $seat_number; $i++)
                <div style="    display: inline-block;
                  border: 1px solid black;
                  border-radius: 10px;
                  width: 300px;
                  height: 120px;
                  margin:8px
                  "
                    class="item">
                    <div style="color:rgb(19, 60, 207)">Mã ghế:<span  style="color:rgb(255, 0, 0)">{{$i}}</span></div>
                    @if (!empty($seats[$i]))
                    @php
                        $ticket=$seats[$i];
                    @endphp
                    <div>Tên: {{  $ticket['user']['name']}}</div>
                    <div>Email: {{  $ticket['user']['email']}}</div>
                    <div>Sđt: {{  $ticket['user']['phone_number']}}</div>
                    <div>Đón :
                        {{ $ticket['departure_station']['name'] . '(' . $ticket['departure_station']['district_name'] . ',' . $ticket['departure_station']['province_name'] . ')' }}
                    </div>
                    <div>Xuống:
                        {{ $ticket['arrival_station']['name'] . '(' . $ticket['arrival_station']['district_name'] . ',' . $ticket['arrival_station']['province_name'] . ')' }}
                    </div>
                    @endif
                </div>
            @endfor
        </div>
    </div>

</body>

</html>
