<!-- Modal -->
<div class="modal fade" id="detailModal{{ $crawledResult['id'] }}" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="detailModalLabel"><a href="{{ $crawledResult['url'] }}" target="_blank">{{ $crawledResult['title'] }}</a></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="card-text"><strong>Description: </strong>{{ $crawledResult['description'] }}</p>
                <p class="card-text"><small class="text-body-secondary"><strong>Created At: </strong>{{ $crawledResult['created_at']->toDateTimeString() }}</small></p>
                <a href="{{ asset($crawledResult['body']) }}" target="_blank">View Body XML</a>
                <img src="{{ asset($crawledResult['screenshot']) }}" class="card-img-bottom" alt="Screenshot">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
