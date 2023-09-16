<!-- resources/views/crawler.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mt-5 col-7">
        <div class="text-center mt-5">
            <form class="align-items-center" id="crawlerForm" method="post" action="{{ route('crawler') }}">
                @csrf
                <div class="mb-3">
                    @include('errors.exception')
                    <h1>Please enter the URL.</h1>
                    <div class="input-group mb-3 mt-4">
                        <input type="url" class="form-control {{ $errors->has('url') ? 'is-invalid' : '' }}"
                               placeholder="https://" name="url" id="url" value="https://" required>
                        <button class="btn btn-outline-dark" type="submit">Crawl</button>
                        @if($errors->has('url'))
                            <div class="invalid-feedback">{{ $errors->first('url') }}</div>
                        @endif
                    </div>
                    <div class="form-text">Example: https://www.google.com.tw</div>
                </div>
            </form>
        </div>
        <div id="result">
            @if(isset($crawledResult))
                @include('crawler.result', ['crawledResult' => $crawledResult])
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/crawler.js') }}"></script>
@endsection
