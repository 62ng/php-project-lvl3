@extends('layout')

@section('content')

    <div class="container-lg">
        <h1 class="mt-5 mb-3">Сайты</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover text-nowrap">
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Последняя проверка</th>
                    <th>Код ответа</th>
                </tr>
                @foreach($groupedUrls as $url)
                <tr>
                    <td>{{ $url->id }}</td>
                    <td><a href="/urls/{{ $url->id }}">{{ $url->name }}</a></td>
                    <td>{{ $url->check_date }}</td>
                    <td>{{ $url->status_code }}</td>
                </tr>
                @endforeach
            </table>
            <nav class="d-flex justify-items-center justify-content-between">
                <div class="d-flex justify-content-between flex-fill d-sm-none">
                    <ul class="pagination">

                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link">pagination.previous</span>
                        </li>


                        <li class="page-item">
                            <a class="page-link" href="https://php-page-analyzer-ru.hexlet.app/urls?page=2" rel="next">pagination.next</a>
                        </li>
                    </ul>
                </div>

                <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
                    <div>
                        <p class="small text-muted">
                            Showing
                            <span class="font-medium">1</span>
                            to
                            <span class="font-medium">15</span>
                            of
                            <span class="font-medium">16</span>
                            results
                        </p>
                    </div>

                    <div>
                        <ul class="pagination">

                            <li class="page-item disabled" aria-disabled="true" aria-label="pagination.previous">
                                <span class="page-link" aria-hidden="true">&lsaquo;</span>
                            </li>





                            <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
                            <li class="page-item"><a class="page-link" href="https://php-page-analyzer-ru.hexlet.app/urls?page=2">2</a></li>


                            <li class="page-item">
                                <a class="page-link" href="https://php-page-analyzer-ru.hexlet.app/urls?page=2" rel="next" aria-label="pagination.next">&rsaquo;</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

        </div>
    </div>

@endsection
