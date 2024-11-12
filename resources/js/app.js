import './bootstrap';
import '../../vendor/masmerise/livewire-toaster/resources/js'; // 👈
import 'boxicons'
import { Loader } from '@googlemaps/js-api-loader';
import Tooltip from "@ryangjchandler/alpine-tooltip";
import Sortable from 'sortablejs';

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
document.addEventListener(
    "alpine:init",
    function setupAlpineBindings() {

        Alpine.directive("template-outlet", TemplateOutletDirective);

    }
);
/**
 * I clone and render the given source template.
 */
function TemplateOutletDirective(element, metadata, framework) {

    // Get the template reference that we want to clone and render.
    var templateRef = framework.evaluate(metadata.expression);

    // Clone the template and get the root node - this is the node that we will
    // inject into the DOM.
    var clone = templateRef.content
        .cloneNode(true)
        .firstElementChild;

    // For the clone, all I need to do at the moment is copy the datastack from the
    // template over to the clone. This way, even if the template doesn't have an "x-data"
    // attribute, I'll still have the right stack.
    clone._x_dataStack = Alpine.closestDataStack(element);

    // Instead of leaving the template in the DOM, we're going to swap the
    // template with a comment hook. This isn't necessary; but, I think it leaves
    // the DOM more pleasant looking.
    var domHook = document.createComment(
        ` Template outlet hook (${ metadata.expression }) with bindings (${ element.getAttribute( "x-data" ) }). `
    );
    domHook._template_outlet_ref = templateRef;
    domHook._template_outlet_clone = clone;

    // Swap the template-outlet element with the hook and clone.
    // --
    // NOTE: Doing this inside the mutateDom() method will pause Alpine's internal
    // MutationObserver, which allows us to perform DOM manipulation without
    // triggering actions in the framework. Then, we can call initTree() and
    // destroyTree() to have explicitly setup and teardowm DOM node bindings.
    Alpine.mutateDom(
        function pauseMutationObserver() {

            element.after(domHook);
            domHook.after(clone);
            Alpine.initTree(clone);

            element.remove();
            Alpine.destroyTree(element);

        }
    );

}