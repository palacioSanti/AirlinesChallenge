<div class="mt-4 pagination-container">
    {!! $cities->appends(request()->query())->links() !!}
</div>
