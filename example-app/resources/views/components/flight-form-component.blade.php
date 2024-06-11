<div class="max-w-2xl mx-auto mb-8 p-4 bg-white shadow-md rounded">
    <form id="flight-form" class="space-y-4">
        <x-airline-dropdown-component name="airline_id" :airlines="$airlines" />

        <div class="flex space-x-4">
            <x-city-dropdown-component name="departure_city_id" :cities="$cities" label="Departure city" />
            <x-city-dropdown-component name="arrival_city_id" :cities="$cities" label="Arrival city" />
        </div>

        <div class="flex flex-col">
            <label for="departure_datetime" class="text-sm font-medium text-gray-700">Departure time:</label>
            <input type="datetime-local" name="departure_datetime" id="departure_datetime" required class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>

        <div class="flex flex-col">
            <label for="arrival_datetime" class="text-sm font-medium text-gray-700">Arrival time:</label>
            <input type="datetime-local" name="arrival_datetime" id="arrival_datetime" required class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>

        <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white font-medium rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save</button>
    </form>
</div>



<div id="toast" style="display: none;">
    <div id="toast-message"></div>
</div>
