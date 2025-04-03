@if ($unit_image)
<img src="{{ asset('storage/' . $unit_image) }}" class="zoom-image" width="40" height="40">

@else
    <span>Sin imagen</span>
@endif
