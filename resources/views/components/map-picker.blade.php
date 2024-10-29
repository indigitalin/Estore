@props(['latitude', 'longitude'])
<div wire:ignore x-data="mapPicker()" x-init="initMap()" class="map-container">
    <div id="map" style="height: 400px;"></div>

    <div>
        <input hidden type="hidden" id="latitude" x-model="tempLatitude" wire:model="form.latitude">
        <input  hidden type="hidden" id="longitude" x-model="tempLongitude" wire:model="form.longitude">
    </div>
</div>

@push('scripts')
    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('MAP_API_KEY') }}&callback=initMap" async defer></script>

    <script>
        function mapPicker() {
            return {
                map: null,
                marker: null,
                tempLatitude: '{{ $latitude }}',
                tempLongitude: '{{ $longitude }}',

                initMap() {
                    const initialLatLng = { lat: parseFloat(this.tempLatitude), lng: parseFloat(this.tempLongitude) };

                    this.map = new google.maps.Map(document.getElementById('map'), {
                        center: initialLatLng,
                        zoom: 13,
                        zoomControl: true,
                        mapTypeControl: false,
                        streetViewControl: false,
                        fullscreenControl: false,
                    });

                    this.marker = new google.maps.Marker({
                        position: initialLatLng,
                        map: this.map,
                        draggable: true,
                    });

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
                },

                updateLocation(lat, lng) {
                    this.marker.setPosition({ lat, lng });
                    this.tempLatitude = lat;
                    this.tempLongitude = lng;
                    // Optional: Update the Livewire model if needed
                    this.$wire.set('form.latitude', lat);
                    this.$wire.set('form.longitude', lng);
                },
            }
        }
    </script>
@endpush
