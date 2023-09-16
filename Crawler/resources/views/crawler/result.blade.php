<div class="mt-4 mb-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">
                <a href="{{ $crawledResult['url'] }}" target="_blank">{{ $crawledResult['title'] }}</a>
            </h5>
            <p class="card-text"><strong>Description: </strong>{{ $crawledResult['description'] }}</p>
            <p class="card-text"><small class="text-body-secondary"><strong>Created At: </strong>{{ $crawledResult['created_at']->toDateTimeString() }}</small></p>
        </div>
        <img src="{{ asset($crawledResult['screenshot']) }}" class="card-img-bottom" alt="Screenshot">
    </div>
</div>
