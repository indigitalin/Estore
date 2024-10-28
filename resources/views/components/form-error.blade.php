@props(['errors'])
@if ($errors->any())
    @php
        \Toaster::error("Opps, there are some error in this form submission.");
    @endphp
@endif
