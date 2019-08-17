@extends('layouts.app')

@section('content')
    <div>
        <div>This appointment is on the {{ $appointment->day() }} at {{ $appointment->time() }} for approx {{ $appointment->length() }}</div>
        <div>...</div>
    </div>
@endsection