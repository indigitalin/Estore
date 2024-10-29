@props(['latitude', 'longitude'])
<div wire:ignore x-data="mapPicker()" x-init="initMap()" class="map-container">
    <div id="map" style="height: 400px;"></div>
    <div>
        <input hidden type="hidden" id="latitude" x-model="tempLatitude" wire:model="form.latitude">
        <input hidden type="hidden" id="longitude" x-model="tempLongitude" wire:model="form.longitude">
    </div>
</div>
@push('scripts')
    <script>
        function mapPicker() {
            return {
                map: null,
                marker: null,
                tempLatitude: '{{ $latitude }}',
                tempLongitude: '{{ $longitude }}',

                initMap() {
                    // Call the function from app.js to load the Google Map
                    window.loadGoogleMap('{{ env('MAP_API_KEY') }}', 'map', this.tempLatitude, this.tempLongitude, (map, marker) => {
                        this.map = map;
                        this.marker = marker;

                        this.map.addListener('click', (event) => {
                            const lat = event.latLng.lat();
                            const lng = event.latLng.lng();
                            this.updateLocation(lat, lng);
                        });

                        this.marker.addListener('dragend', (event) => {
                            const lat = event.latLng.lat();
                            const lng = event.latLng.lng();
                            this.updateLocation(lat, lng);
                        });
                    });
                },

                updateLocation(lat, lng) {
                    this.marker.setPosition({ lat, lng });
                    this.tempLatitude = lat;
                    this.tempLongitude = lng;
                    this.$wire.set('form.latitude', lat);
                    this.$wire.set('form.longitude', lng);
                },
            }
        }
    </script>
@endpush
