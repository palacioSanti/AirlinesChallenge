document.addEventListener('DOMContentLoaded', function () {
    $('.select2').select2();

    $('#airline').on('change', function() {
        const airlineId = $(this).val();
        axios.get(`/api/cities?airline_id=${airlineId}`).then(response => {
            const cities = response.data.cities;
            let departureSelect = $('#departure_city_id');
            let arrivalSelect = $('#arrival_city_id');
            departureSelect.empty();
            arrivalSelect.empty();
            cities.forEach(city => {
                const option = new Option(city.name, city.id, false, false);
                departureSelect.append(option).trigger('change');
                arrivalSelect.append(option.cloneNode(true)).trigger('change');
            });
        });
    });

    $('#departure_city_id').on('change', function() {
        const departureId = $(this).val();
        let arrivalSelect = $('#arrival_city_id');
        arrivalSelect.find('option').each(function() {
            $(this).prop('disabled', $(this).val() == departureId);
        });
        arrivalSelect.trigger('change');
    });

    $('#flight-form').on('submit', function(event) {
        event.preventDefault();
        let departureSelect = $('#departure_city_id');
        let arrivalSelect = $('#arrival_city_id');
        if (departureSelect.val() === arrivalSelect.val()) {
            showToast('Error', 'Departure and arrival cities must be different.');
            return;
        }
        let airlineSelect = $('#airline').val();
        const data = new FormData(this);
        axios.post('/api/flights', {
            airline_id: airlineSelect,
            departure_city_id: data.get('departure_city_id'),
            arrival_city_id: data.get('arrival_city_id'),
            departure_datetime: data.get('departure_datetime'),
            arrival_datetime: data.get('arrival_datetime'),
        }).then(response => {
            const flight = response.data.flight;
            const flightList = $('#flight-list');
            this.reset();
            $('.select2').val(null).trigger('change');
            showToast('Success', 'Flight saved successfully.');
        }).catch(error => {
            if (error.response && error.response.data && error.response.data.message) {
                showToast('Error', error.response.data.message);
            } else {
                showToast('Error', 'There was a problem saving the flight.');
            }
        });
    });

    $('#departure_datetime').on('change', function() {
        $('#arrival_datetime').attr('min', this.value);
    });

    $('#arrival_datetime').on('change', function() {
        $('#departure_datetime').attr('max', this.value);
    });

    function showToast(type, message) {
        const toast = $('#toast');
        const toastMessage = $('#toast-message');
        toastMessage.text(message);
        toast.show().addClass(type.toLowerCase());
        setTimeout(() => {
            toast.hide().removeClass(type.toLowerCase());
        }, 3000);
    }

    window.confirmDelete = function(flightId) {
        if (confirm('¿Are you sure you want to delete this flight?')) {
            axios.delete(`/api/flights/${flightId}`).then(response => {
                $(`#flight-${flightId}`).remove();
                showToast('Success', 'Flight deleted successfully.');
            }).catch(error => {
                showToast('Error', 'There was a problem deleting the flight.');
            });
        }
    }
});
