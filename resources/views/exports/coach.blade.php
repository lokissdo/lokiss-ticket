<table>
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Tên</th>
            <th scope="col">Loại</th>
            <th scope="col">Số chỗ ngồi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($coaches as $coach)
            <tr>
                <th scope="row">{{ $coach['id'] }}</th>
                <td>{{ $coach['name'] }}</td>
                <td>{{ $coach['type_name'] }}</td>
                <td>{{ $coach['seat_number'] }}</td>
            </tr>
            @endforeach
    </tbody>
</table>