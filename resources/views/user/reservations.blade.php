@extends('layouts.user')

@section('content')
    <div class="container">
        <h3>Reservation History</h3>
        <br>
        <table class="table">
            <thead>
            <tr>
                <th>Trip</th>
                <th>Tickets</th>
                <th>Cost</th>
            </tr>
            </thead>
            <tbody>
            @forelse($reservations as $reservation)
                <tr>
                    <td>{{$reservation->title}}</td>
                    <td>{{$reservation->pivot->tickets}}</td>
                    <td>{{$reservation->pivot->cost}} $</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No reservations found.</td>
                </tr>
            @endforelse
            </tbody>
            <tfoot>
            <tr>
                <td>
                    <strong>Total trips: {{$reservations->count()}}</strong>
                </td>
                <td>
                    <strong>Total tickets bought: {{$reservations->sum('pivot.tickets')}}</strong>
                </td>
                <td>
                    <strong>Total Cost: {{$reservations->sum('pivot.cost')}} $</strong>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
@endsection
