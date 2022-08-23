<table>
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Giờ khởi hành</th>
            <th scope="col">Địa điểm khởi hành</th>
            <th scope="col">Thời gian di chuyển</th>
            <th scope="col">Địa điểm đến</th>
            <th scope="col">Các bến sẽ qua (theo thứ tự)</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($schedules as $schedule)
            <tr>
                <th scope="row">{{ $schedule['id'] }}</th>
                <td>{{ $schedule['departure_time'] }}</td>
                <td>{{ $schedule['departure_province_name'] }}</td>
                <td>{{ $schedule['hour_duration'] }}</td>
                <td>{{ $schedule['arrival_province_name'] }}</td>
                
                    @foreach ($schedule['schedule_detail'] as $each)
                    <td>
                        {{ $each['name'] . ' (' . $each['district_name'] . ', ' . $each['province_name'] }})
                </td>
                    @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
