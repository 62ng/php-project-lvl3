@extends('layout')

@section('content')
        <h1 class="mt-5 mb-3">Сайты</h1>
        <div class="table-responsive">

            <table class="table table-bordered table-hover text-nowrap">
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Последняя проверка</th>
                    <th>Код ответа</th>
                </tr>
                @foreach($urls as $url)
                    <tr>
                        <td>{{ $url->id }}</td>
                        <td><a href="{{ route('urls.show', [$url->id]) }}">{{ $url->name }}</a></td>
                        <td>{{ $checks[$url->id]?->check_date }}</td>
                        <td>{{ $checks[$url->id]?->status_code }}</td>
                    </tr>
                @endforeach
            </table>

            {{ $urls->links() }}

        </div>

@endsection
