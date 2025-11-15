<table id="{{ $id }}" class="table {{ $class ?? 'table-striped table-hover' }}">
    <thead>
    <tr>
        @foreach ($columns as $column)
            <th>{{ $column }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach ($rows as $row)
        <tr>
            @foreach ($row as $cell)
                <td>{!! $cell !!}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
