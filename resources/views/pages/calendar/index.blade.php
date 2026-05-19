@extends('layouts.base')

@section('page.title', 'Календарь')

@section('content')
    <div class="h-[75vh]">
        @include('includes.calendar')
    </div>
@endsection
