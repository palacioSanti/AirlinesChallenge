@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Airlines Administration</h1>
        <div id="errorContainer" class="text-red-500 mb-4"></div>

        <div class="mb-4">
            <input type="number" id="flightsCountFilter" placeholder="Minimum Active Flights" class="border p-2 rounded mr-2">
            <select id="cityFilter" class="border p-2 rounded mr-2">
                <option value="">All Cities</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                @endforeach
            </select>
            <button onclick="applyFilters()" class="bg-green-500 text-white p-2 rounded">Apply Filters</button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Name</th>
                        <th class="py-2 px-4 border-b">Description</th>
                        <th class="py-2 px-4 border-b">Amount of flights</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody id="airlineTable">
                    <!-- Data will be dynamically inserted here -->
                </tbody>
            </table>
        </div>

        <div class="mt-4 pagination-container">
            <!-- Pagination links will be dynamically inserted here -->
        </div>

        <div class="mt-8 padding-top">
            <input type="text" id="newName" placeholder="Nombre" class="border p-2 rounded mr-2">
            <input type="text" id="newDescription" placeholder="Descripción" class="border p-2 rounded mr-2">
            <button onclick="addAirline()" class="bg-blue-500 text-white p-2 rounded">Add Airline</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadAirlines();

            document.querySelector('.pagination-container').addEventListener('click', function(e) {
                if (e.target.tagName === 'A') {
                    e.preventDefault();
                    const page = e.target.href.split('page=')[1];
                    loadAirlines(page);
                }
            });
        });

        async function loadAirlines(page = 1) {
            const flightsCount = document.getElementById('flightsCountFilter').value;
            const city = document.getElementById('cityFilter').value;

            const params = new URLSearchParams();
            if (flightsCount) params.append('flights_count', flightsCount);
            if (city) params.append('city', city);
            params.append('page', page);

            try {
                const response = await fetch(`/api/airlines?${params.toString()}`, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                const data = await response.json();
                updateTable(data);
                updatePagination(data.links);
            } catch (error) {
                showError('Error fetching airlines: ' + error.message);
            }
        }

        function applyFilters() {
            loadAirlines();
        }

        function updateTable(data) {
            const tableBody = document.getElementById('airlineTable');
            tableBody.innerHTML = '';

            data.data.forEach(airline => {
                const row = `
                    <tr id="airline-${airline.id}">
                        <td class="py-2 px-4 border-b">${airline.id}</td>
                        <td class="py-2 px-4 border-b">${airline.name}</td>
                        <td class="py-2 px-4 border-b">${airline.description}</td>
                        <td class="py-2 px-4 border-b">${airline.flights_count}</td>
                        <td class="py-2 px-4 border-b">
                            <button onclick="editAirline(${airline.id})" class="bg-yellow-500 text-white p-2 rounded mr-2">Edit</button>
                            <button onclick="deleteAirline(${airline.id})" class="bg-red-500 text-white p-2 rounded">Delete</button>
                        </td>
                    </tr>
                `;
                tableBody.insertAdjacentHTML('beforeend', row);
            });
        }

        function updatePagination(links) {
            const paginationContainer = document.querySelector('.pagination-container');
            paginationContainer.innerHTML = links.map(link => {
                return link.active
                    ? `<span class="px-2 py-1 bg-blue-500 text-white">${link.label}</span>`
                    : `<a href="${link.url}" class="px-2 py-1 text-blue-500">${link.label}</a>`;
            }).join(' ');
        }

        function showError(message) {
            const errorContainer = document.getElementById('errorContainer');
            errorContainer.textContent = message;
            setTimeout(() => {
                errorContainer.textContent = '';
            }, 5000);
        }

        async function addAirline() {
            const name = document.getElementById('newName').value;
            const description = document.getElementById('newDescription').value;

            if (!name || !description) {
                showError('Name and description are required.');
                return;
            }

            try {
                const response = await fetch('/api/airlines', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name,
                        description
                    })
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.errors ? Object.values(errorData.errors).flat().join(', ') : 'Error adding airline');
                }

                const airlineJson = await response.json();
                const airline = airlineJson.airline;
                const row = `
                    <tr id="airline-${airline.id}">
                        <td class="py-2 px-4 border-b">${airline.id}</td>
                        <td class="py-2 px-4 border-b">${airline.name}</td>
                        <td class="py-2 px-4 border-b">${airline.description}</td>
                        <td class="py-2 px-4 border-b">0</td>
                        <td class="py-2 px-4 border-b">
                            <button onclick="editAirline(${airline.id})" class="bg-yellow-500 text-white p-2 rounded mr-2">Edit</button>
                            <button onclick="deleteAirline(${airline.id})" class="bg-red-500 text-white p-2 rounded">Delete</button>
                        </td>
                    </tr>
                `;
                document.getElementById('airlineTable').insertAdjacentHTML('beforeend', row);
                document.getElementById('newName').value = '';
                document.getElementById('newDescription').value = '';
            } catch (error) {
                showError(error.message);
            }
        }

        async function deleteAirline(id) {
            try {
                const response = await fetch(`/api/airlines/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.error || 'Error deleting airline');
                }

                document.getElementById(`airline-${id}`).remove();
            } catch (error) {
                showError(error.message);
            }
        }

        async function editAirline(id) {
            const row = document.getElementById(`airline-${id}`);
            const name = prompt('The name of the airline is:', row.querySelector('td:nth-child(2)').innerText);
            const description = prompt('The description is:', row.querySelector('td:nth-child(3)').innerText);

            if (!name || !description) {
                showError('Name and description are required.');
                return;
            }

            try {
                const response = await fetch(`/api/airlines/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name,
                        description
                    })
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.errors ? Object.values(errorData.errors).flat().join(', ') : 'Error editing airline');
                }

                const airlineJson = await response.json();
                row.querySelector('td:nth-child(2)').innerText = airlineJson.airline.name;
                row.querySelector('td:nth-child(3)').innerText = airlineJson.airline.description;
            } catch (error) {
                showError(error.message);
            }
        }
    </script>
@endsection
