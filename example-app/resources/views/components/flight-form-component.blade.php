<div>
    <form id="flight-form">
        <x-airline-dropdown-component :airlines="$airlines" />
        <x-city-dropdown-component name="departure_city_id" :cities="$cities" label="Origen" />
        <x-city-dropdown-component name="arrival_city_id" :cities="$cities" label="Destino" />
        <label for="departure_datetime">Hora de Despegue</label>
        <input type="datetime-local" name="departure_datetime" id="departure_datetime" required>
        <label for="arrival_datetime">Hora de Llegada</label>
        <input type="datetime-local" name="arrival_datetime" id="arrival_datetime" required>
        <button type="submit">Guardar</button>
    </form>
</div>

<script>
    document.getElementById('airline').addEventListener('change', function() {
        const airlineId = this.value;
        axios.get(`/api/cities?airline_id=${airlineId}`).then(response => {
            const cities = response.data;
            let departureSelect = document.getElementById('departure_city_id');
            let arrivalSelect = document.getElementById('arrival_city_id');
            departureSelect.innerHTML = '';
            arrivalSelect.innerHTML = '';
            cities.forEach(city => {
                departureSelect.innerHTML += `<option value="${city.id}">${city.name}</option>`;
                arrivalSelect.innerHTML += `<option value="${city.id}">${city.name}</option>`;
            });
        });
    });

    document.getElementById('departure_city_id').addEventListener('change', function() {
        const departureId = this.value;
        let arrivalSelect = document.getElementById('arrival_city_id');
        Array.from(arrivalSelect.options).forEach(option => {
            option.disabled = option.value == departureId;
        });
    });

    document.getElementById('flight-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const data = new FormData(this);
        axios.post('/api/vuelos', data).then(response => {
            const flight = response.data;
            const flightList = document.getElementById('flight-list');
            flightList.innerHTML += `<tr id="flight-${flight.id}">
                                        <td>${flight.airline.name}</td>
                                        <td>${flight.departure_city.name}</td>
                                        <td>${flight.arrival_city.name}</td>
                                        <td>${flight.departure_datetime}</td>
                                        <td>${flight.arrival_datetime}</td>
                                        <td>
                                            <button onclick="confirmDelete(${flight.id})">Eliminar</button>
                                        </td>
                                    </tr>`;
            this.reset();
            showToast('Success', 'Vuelo guardado exitosamente.');
        }).catch(error => {
            showToast('Error', 'Hubo un problema al guardar el vuelo.');
        });
    });

    document.getElementById('departure_datetime').addEventListener('change', function() {
        document.getElementById('arrival_datetime').min = this.value;
    });

    document.getElementById('arrival_datetime').addEventListener('change', function() {
        document.getElementById('departure_datetime').max = this.value;
    });

    function showToast(type, message) {
        const toast = document.getElementById('toast');
        const toastMessage = document.getElementById('toast-message');
        toastMessage.innerText = message;
        toast.style.display = 'block';
        toast.className = type.toLowerCase();
        setTimeout(() => {
            toast.style.display = 'none';
        }, 3000);
    }

    function confirmDelete(flightId) {
        if (confirm('¿Estás seguro que deseas eliminar este vuelo?')) {
            axios.delete(`/api/vuelos/${flightId}`).then(response => {
                document.getElementById(`flight-${flightId}`).remove();
                showToast('Success', 'Vuelo eliminado exitosamente.');
            }).catch(error => {
                showToast('Error', 'Hubo un problema al eliminar el vuelo.');
            });
        }
    }
</script>

<div id="toast" style="display: none;">
    <div id="toast-message"></div>
</div>
