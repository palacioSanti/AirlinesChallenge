<tr id="flight-{{ $flight->id }}" class="hover:bg-gray-50">
    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $flight->airline->name }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $flight->departureCity->name }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $flight->arrivalCity->name }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $flight->departure_datetime }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $flight->arrival_datetime }}</td>
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <button onclick="confirmDelete({{ $flight->id }})" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
            Delete
        </button>
    </td>
</tr>

