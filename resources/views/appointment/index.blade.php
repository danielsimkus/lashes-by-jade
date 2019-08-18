@extends('layouts.app')

@section('content')
    @forelse (auth()->user()->upcomingAppointments as $appointment)
        <div class="text-md-left">You have an appointment on {{ $appointment->day() }} at {{ $appointment->time() }}</div>
    @empty
        <div class="text-md-left">You have no upcoming appointments, why not <a href="{{ route('appointments.create') }}">make one now?</a></div>
    @endforelse
@endsection