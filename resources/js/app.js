import './bootstrap';
import '../../vendor/masmerise/livewire-toaster/resources/js'; // 👈
import 'boxicons'
import { Loader } from '@googlemaps/js-api-loader';
import Tooltip from "@ryangjchandler/alpine-tooltip";

// import 'flowbite';
// import { initFlowbite } from 'flowbite';

// document.addEventListener("livewire:navigating", () => {
//     initFlowbite();
// });

// document.addEventListener("livewire:navigated", () => {
//     initFlowbite();
// });


document.addEventListener('livewire:init', () => {
    Livewire.on('navigate_to', (event) => {
        if (event) {
            Livewire.navigate(event);
        } else {
            console.error('No valid URL found in the event.');
        }
    });
});

Alpine.plugin(Tooltip);


document.addEventListener("input", handleInputChange);
document.addEventListener("change", handleInputChange);

function handleInputChange(event) {
    const target = event.target;

    if (target.matches("input[type='text'], input[type='number'], input[type='password'], textarea, select, input[type='checkbox'], input[type='radio']")) {
        // Remove the error message (ul.text-red-600) if it exists
        const errorMessage = target.closest('div').querySelector('ul.text-red-600');
        if (errorMessage) {
            errorMessage.remove();
        }
    }
}

function loadGoogleMap(apiKey, mapElementId, initialLat, initialLng, callback) {
    const loader = new Loader({
        apiKey: apiKey,
        version: 'weekly',
    });

    loader.load().then(() => {
        const map = new google.maps.Map(document.getElementById(mapElementId), {
            center: { lat: parseFloat(initialLat), lng: parseFloat(initialLng) },
            zoom: 13,
            zoomControl: true,
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: false,
        });

        const marker = new google.maps.Marker({
            position: { lat: parseFloat(initialLat), lng: parseFloat(initialLng) },
            map: map,
            draggable: true,
        });

        // Run the callback after loading the map
        if (callback) callback(map, marker);
    }).catch(error => {
        console.error('Error loading Google Maps:', error);
    });
}

window.loadGoogleMap = loadGoogleMap; // Make it globally available for Alpine.js or Blade to call
