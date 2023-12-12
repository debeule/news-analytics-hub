@extends('layout.app')

@section('title', 'Home')

@section('content')
    <div class="grid">
        <div>
            <h2>manual</h2>
        </div>
        <div class="grid__form">
            <form action="{{ route('dispatch') }}">
                <label>dispatch ScrapeArticlesListJob</label>
                <input type="submit" value="dispatch">
            </form>
        </div>
        <div class="grid__form">
            <form action="{{ route('test2') }}">
                <label>dispatch ScrapeArticleJob</label>
                <input type="submit" value="dispatch">
            </form>
        </div>
    </div>
@endsection