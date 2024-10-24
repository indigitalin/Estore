import './bootstrap';
import '../../vendor/masmerise/livewire-toaster/resources/js'; // 👈
import 'boxicons'

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


document.addEventListener("input", (event) => {
    const target = event.target;

    if (target.matches("input[type='text'], input[type='number'], input[type='password'], textarea")) {
        // Remove the error message (ul.text-red-600) if it exists
        const errorMessage = target.closest('div').querySelector('ul.text-red-600');
        if (errorMessage) {
            errorMessage.remove();
            console.log("Error message removed for input field.");
        }
    }
});

document.addEventListener("change", (event) => {
    const target = event.target;

    if (target.matches("select, input[type='checkbox'], input[type='radio']")) {
        console.log("Select, checkbox, or radio button changed:", target.value);
        const errorMessage = target.closest('div').querySelector('ul.text-red-600');
        if (errorMessage) {
            errorMessage.remove();
            console.log("Error message removed for select, checkbox, or radio.");
        }
    }
});
