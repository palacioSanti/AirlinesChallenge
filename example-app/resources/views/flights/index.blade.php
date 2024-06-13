@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-4">
    <h1 class="text-3xl font-bold mb-6 text-center">Flights Administration</h1>
    <div >
        <x-flight-form-component :airlines="$airlines" :cities="$cities" :flights="$flights" />
    </div>
    <div>
        <x-flight-list-component id="flight-list" :flights="$flights" />
    </div>
</div>
@endsection



