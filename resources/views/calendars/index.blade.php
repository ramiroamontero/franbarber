@extends('layouts.app')
@section('content')
    <h1>Calendars</h1>

    @if (count($calendars) > 0)
        <ul>
            @foreach ($calendars as $calendar)
                <li>{{ $calendar->getSummary() }} ({{ $calendar->getStart()->getDateTime() }})</li>
            @endforeach
        </ul>
    @else
        <p>No calendars found.</p>
    @endif
    {{-- <form action="{{ route('calendars.store') }}" method="POST">     --}}
        {{-- @csrf
        <input type="text" name="summary" placeholder="calendar Title">
        <input type="datetime-local" name="start">
        <input type="datetime-local" name="end">
        <button type="submit">Add calendar</button> --}}
    </form>
@endsection
