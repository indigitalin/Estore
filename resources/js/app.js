import './bootstrap';
import '../../vendor/masmerise/livewire-toaster/resources/js'; // 👈
import 'boxicons'

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