<div>
    <table>
        <thead>
            <tr>
                <th>Airline</th>
                <th>Departure City</th>
                <th>Arrival City</th>
                <th>Time of departure</th>
                <th>Time of arrival</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="flight-list">
            @foreach($flights as $flight)
                <x-flight-row-component :flight="$flight" />
            @endforeach
        </tbody>
    </table>
</div>
