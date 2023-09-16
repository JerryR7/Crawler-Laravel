<tr>
    <td>
        <p class="card-title">
            <a href="{{ $crawledResult['url'] }}" target="_blank">{{ $crawledResult['title'] }}</a>
        </p>
    </td>
    <td>
        <p class="card-text">{{ $crawledResult['description'] }}</p>
    </td>
    <td>
        <p class="card-text">{{ $crawledResult['created_at']->toDateTimeString() }}</p>
    </td>
    <td>
        <button type="button" class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#detailModal{{ $crawledResult['id'] }}">
            Detail
        </button>
    </td>
</tr>
@include('crawler.detail', ['crawledResult' => $crawledRecord])
