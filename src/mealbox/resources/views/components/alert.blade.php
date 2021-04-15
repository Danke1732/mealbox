@if ($session)
  <div class="alert alert-{{ $type }} w-100">
    {{ $session }}
  </div>
@endif