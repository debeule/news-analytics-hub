@extends('layout.app')

@section('title', 'Home')

@section('content')

    <form action="{{ route('dispatch') }}">
        <input type="submit" value="dispatch">
    </form>
aaab
@endsection