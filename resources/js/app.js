import '@popperjs/core';

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

import Chart from 'chart.js/auto';

import Swal from 'sweetalert2';

import '@tabler/core';

import '../../vendor/aliqasemzadeh/livewire-bootstrap-modal/resources/js/modals';


import Alpine from 'alpinejs';
import persist from '@alpinejs/persist'

Alpine.plugin(persist);

window.Alpine = Alpine;

Alpine.start();
