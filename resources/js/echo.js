import Echo from 'laravel-echo';

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    host: window.location.hostname + ':8080',
    wsPath: '',
    forceTLS: false,
    disableStats: true,
});
