<div>
    <label for="airline">Airlines</label>
    <select name="airline" id="airline" class="select2">
        <option value="">All airlines</option>
        @foreach($airlines as $airline)
            <option value="{{ $airline->id }}">{{ $airline->name }}</option>
        @endforeach
    </select>
</div>



