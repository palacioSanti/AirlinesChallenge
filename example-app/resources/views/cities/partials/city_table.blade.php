<table class="min-w-full bg-white border border-gray-200">
    <thead>
        <tr>
            <th class="py-2 px-4 border-b"><a href="#" class="sort" data-sort="id">ID</a></th>
            <th class="py-2 px-4 border-b"><a href="#" class="sort" data-sort="name">Name</a></th>
            <th class="py-2 px-4 border-b">Arriving flights</th>
            <th class="py-2 px-4 border-b">Departing flights</th>
            <th class="py-2 px-4 border-b">Actions</th>
        </tr>
    </thead>
    <tbody id="city-table">
        @foreach ($cities as $city)
            <tr data-id="{{ $city->id }}">
                <td class="py-2 px-4 border-b">{{ $city->id }}</td>
                <td class="py-2 px-4 border-b">{{ $city->name }}</td>
                <td class="py-2 px-4 border-b">{{ $city->arrival_flights_count }}</td>
                <td class="py-2 px-4 border-b">{{ $city->departure_flights_count }}</td>
                <td class="py-2 px-4 border-b">
                    <button class="btn-edit bg-yellow-500 text-white px-3 py-1 rounded">Edit</button>
                    <button class="btn-delete bg-red-500 text-white px-3 py-1 rounded">Delete</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@include('cities.partials.pagination', ['cities' => $cities])
