@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">City Administration</h1>
        <div class="mb-4">
            <select id="airline-filter" class="form-select block w-full mt-1">
                <option value="">All Airlines</option>
                @foreach ($airlines as $airline)
                    <option value="{{ $airline->id }}" {{ request('airline_id') == $airline->id ? 'selected' : '' }}>
                        {{ $airline->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="city-container">
            @include('cities.partials.city_table', ['cities' => $cities])
        </div>

        <add-city></add-city>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            const currentAirlineId = urlParams.get('airline_id');

            $('.city-container').on('click', '.btn-delete', function() {
                const row = $(this).closest('tr');
                const id = row.data('id');

                $.ajax({
                    url: `{{ url('/api/cities') }}/${id}`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function() {
                        row.remove();
                    },
                    error: function(xhr) {
                        alert('Error deleting the city.');
                    }
                });
            });

            $('.city-container').on('click', '.btn-edit', function() {
                const row = $(this).closest('tr');
                const id = row.data('id');
                const name = prompt('Type the name of the city:', row.find('td:nth-child(2)').text());

                if (!name) {
                    alert('The name of the city can\'t be empty.');
                    return;
                }

                $.ajax({
                    url: `/api/cities/${id}`,
                    type: 'PUT',
                    data: {
                        name: name,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        row.find('td:nth-child(2)').text(response.city.name);
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            alert(xhr.responseJSON.errors.name[0]);
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            alert(xhr.responseJSON.message);
                        } else {
                            alert('Unknown error editing the city.');
                        }
                    }
                });
            });

            function loadCities(params) {
                $.ajax({
                    url: '{{ route('api.cities.index') }}',
                    type: 'GET',
                    data: params,
                    success: function(response) {
                        $('#city-table').html($(response.table).find('#city-table').html());
                        $('.pagination-container').html(response.pagination);
                    },
                    error: function(xhr) {
                        alert('Error loading cities.');
                    }
                });
            }

            let airlineId = '';
            let sortType = 'id';
            let orderAsc = true;

            $('#airline-filter').on('change', function() {
                airlineId = $(this).val();
                loadCities({
                    airline_id: airlineId,
                    sort: sortType,
                    order: 'asc'
                });
                orderAsc = true;
            });

            $('.city-container').on('click', '.sort', function() {
                sortType = $(this).data('sort');
                let order = orderAsc ? 'asc' : 'desc';
                orderAsc = !orderAsc;

                loadCities({
                    sort: sortType,
                    order: order,
                    airline_id: airlineId
                });
            });

            $('.pagination-container').on('click', function(e) {
                e.preventDefault();
                const page = $(e.target).attr('href').split('page=')[1];
                const params = {
                    page: page,
                    airline_id: $('#airline-filter').val(),
                    sort: sortType,
                    order: orderAsc ? 'desc' : 'asc',
                };
                loadCities(params);
            });
        });
    </script>
@endpush
