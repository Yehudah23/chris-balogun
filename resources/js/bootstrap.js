window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Determine API base URL from build-time environment variables.
// Set one of these in your build environment (Vercel):
// - MIX_API_URL
// - VUE_APP_API_URL
// - MIX_APP_URL
// Example value: "https://api.example.com" (do NOT include a trailing slash).
// If none are set we leave axios to use relative URLs (good for local php artisan serve).
try {
	var apiBase = (typeof process !== 'undefined' && process.env && (process.env.MIX_API_URL || process.env.VUE_APP_API_URL || process.env.MIX_APP_URL)) || '';
	if (apiBase) {
		// If the env var contains a path like '/api', keep as-is. Otherwise you can include '/api' in requests.
		window.axios.defaults.baseURL = apiBase;
	}
} catch (e) {
	// Defensive: in some build environments `process` may be unavailable at runtime.
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
