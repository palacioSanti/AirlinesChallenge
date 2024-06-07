<tr id="flight-{{ $flight->id }}">
    <td>{{ $flight->airline->name }}</td>
    <td>{{ $flight->departureCity->name }}</td>
    <td>{{ $flight->arrivalCity->name }}</td>
    <td>{{ $flight->departure_datetime }}</td>
    <td>{{ $flight->arrival_datetime }}</td>
    <td>
        <button onclick="confirmDelete({{ $flight->id }})">Delete</button>
    </td>
</tr>

