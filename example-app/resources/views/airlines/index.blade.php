@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Airlines Administration</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">ID</th>
                    <th class="py-2 px-4 border-b">Name</th>
                    <th class="py-2 px-4 border-b">Description</th>
                    <th class="py-2 px-4 border-b">Ammount of flights</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody id="airlineTable">
                @foreach($airlines as $airline)
                <tr id="airline-{{ $airline->id }}">
                    <td class="py-2 px-4 border-b">{{ $airline->id }}</td>
                    <td class="py-2 px-4 border-b">{{ $airline->name }}</td>
                    <td class="py-2 px-4 border-b">{{ $airline->description }}</td>
                    <td class="py-2 px-4 border-b">{{ $airline->flights_count }}</td>
                    <td class="py-2 px-4 border-b">
                        <button onclick="editAirline({{ $airline->id }})" class="bg-yellow-500 text-white p-2 rounded mr-2">Edit</button>
                        <button onclick="deleteAirline({{ $airline->id }})" class="bg-red-500 text-white p-2 rounded">Delete</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-8">
        {{ $airlines->links() }}
    </div>


    <div class="mb-4 padding-top">
        <input type="text" id="newName" placeholder="Nombre" class="border p-2 rounded mr-2">
        <input type="text" id="newDescription" placeholder="Descripción" class="border p-2 rounded mr-2">
        <button onclick="addAirline()" class="bg-blue-500 text-white p-2 rounded">Add Airline</button>
    </div>
</div>

<script>
    async function addAirline() {
        const name = document.getElementById('newName').value;
        const description = document.getElementById('newDescription').value;

        if (!name || !description) {
            alert('Name and description are required.');
            return;
        }

        const response = await fetch('/api/airlines', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ name, description })
        });

        if (response.ok) {
            const airline = await response.json();
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
        } else {
            console.error('Error adding airline');
        }
    }

    async function deleteAirline(id) {
        const response = await fetch(`/api/airlines/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        if (response.ok) {
            document.getElementById(`airline-${id}`).remove();
        } else {
            console.error('Error deleting airline');
        }
    }

    async function editAirline(id) {
        // Implement the edit feature
    }
</script>
@endsection
