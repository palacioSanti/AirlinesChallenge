@extends('layouts.app')

@section('content')
<div>
    <h1>Flights Administration</h1>
    <x-flight-form-component :airlines="$airlines" :cities="$cities" />
    <x-flight-list-component :flights="$flights" />
</div>
@endsection
