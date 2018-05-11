
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import router from './router'

window.Vue = require('vue');
Vue.axios = window.axios;
Vue.router = router;

Vue.use(require('@websanova/vue-auth'), {
    auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
    http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
    router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
    rolesVar: 'role',
    loginData: {url: 'auth/login', method: 'POST', redirect: '/'},
    logoutData: {url: 'auth/logout', method: 'POST', redirect: 'login', authType: 'bearer'},
    fetchData: {url: 'auth/account', method: 'GET', authType: 'bearer'},
    refreshData: {url: 'auth/refresh', method: 'POST'}
  })

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('main-component', require('./components/Main.vue'));

const app = new Vue({
    router,
    el: '#app'
});
