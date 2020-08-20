@section('table')


<table>
    <tr>
        @foreach($ths as $th)
            <th>{{ $th }}</th>
        @endforeach
    </tr>
        @forelse($data as $val)
            $val -> 
</table>


@endsection