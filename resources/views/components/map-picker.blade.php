@props(['latitude', 'longitude'])
<div x-data="mapPicker()" x-init="initMap()" class="map-container">
    <div id="map" style="height: 400px;"></div>

    <div>
        <input type="text" id="latitude" x-model="tempLatitude" wire:model="form.latitude">
        <input type="text" id="longitude" x-model="tempLongitude" wire:model="form.longitude">
    </div>
</div>

@push('scripts')
    <!-- Leaflet CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        function mapPicker() {
            return {
                map: null,
                tempLatitude: '{{ $latitude }}',
                tempLongitude: '{{ $longitude }}',
                initMap() {
                    this.map = L.map('map').setView([{{ $latitude }}, {{ $longitude }}], 13);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                    }).addTo(this.map);

                    const marker = L.marker([{{ $latitude }}, {{ $longitude }}]).addTo(this.map);

                    this.map.on('click', (event) => {
                        const lat = event.latlng.lat;
                        const lng = event.latlng.lng;

                        marker.setLatLng(event.latlng);
                        // this.$wire.set('form.latitude', lat);
                        // this.$wire.set('form.longitude', lng);

                    });
                },
            }
        }
    </script>
@endpush
