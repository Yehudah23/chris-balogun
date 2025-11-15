require('./bootstrap');

// Vue entry: import and mount components
import Vue from 'vue';
import AdminView from './components/AdminView.vue';
import LogIn from './components/LogIn.vue';

// Mount admin app if element exists
if (document.getElementById('admin-app')) {
    const adminApp = new Vue({
        el: '#admin-app',
        components: { AdminView }
    });
}

// Mount login app if element exists
if (document.getElementById('login-app')) {
    const loginApp = new Vue({
        el: '#login-app',
        components: { LogIn }
    });
}