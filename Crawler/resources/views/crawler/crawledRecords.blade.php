{{--@extends('layouts.app')--}}

{{--@section('content')--}}
{{--    <div class="mt-4 mb-5">--}}
{{--        <div>--}}
{{--            @foreach ($crawledRecords as $crawledRecord)--}}
{{--                @include('crawler.result', ['crawledResult' => $crawledRecord])--}}
{{--            @endforeach--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}

@extends('layouts.app')

@section('content')
    <div class="container mt-5 col-10">
        <main>
            <div class="container-fluid px-4">
                <h1 class="text-center mt-4">
                    <a class="navbar-brand" href="{{ route('records') }}">Crawled Records</a>
                </h1>
                <div class="container mt-3 col-7">
                    <form class="align-items-center" id="searchForm" method="post" action="{{ route('search') }}">
                        @csrf
                        @include('errors.exception')
                        <div class="input-group mb-3">
                            <input type="text" class="form-control {{ $errors->has('query') ? 'is-invalid' : '' }}"
                                   placeholder="Search..." name="query" id="query" required>
                            <button class="btn btn-outline-dark" type="submit">Search</button>
                            @if($errors->has('query'))
                                <div class="invalid-feedback">{{ $errors->first('query') }}</div>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="card mt-5">
                    <div class="card-body">
                        <table
                            class="table table-light table-striped table-hover table-bordered border-dark-subtle table-sm">
                            <thead class="table-dark">
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Created At</th>
                                <th>Detail</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($crawledRecords as $crawledRecord)
                                @include('crawler.dataTable', ['crawledResult' => $crawledRecord])
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="container mt-5 col-2">
                    <div class="justify-content-center pagination">
                        {{ $crawledRecords->links() }}

                    </div>
                </div>

            </div>
        </main>
    </div>
    {{--    @include('crawler.detail')--}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
            crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
@endsection
