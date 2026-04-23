@extends("layouts.base")

@section("page.title", "Календарь")

@push("head.js")
    <script>
        window.translations = @json([
            "calendar" => __("calendar"),
        ]);
    </script>
@endpush

@section("content")
    @include("includes.calendar")
@endsection
