/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// Подключение скриптов для работы с angular
require('./angular/angular.min.js');
require('./angular/init-ng-app');
require('./angular/attach-worker-to-device-angular-controller');
require('./angular/attach-worker-to-work-place-angular-controller');

require('./bem/tab-content-wrapper');
require('./bem/modal-window');
require('./bem/attach-component-parts-modal-window');
require('./bem/attach-devices-modal-window');
require('./bem/controllers/admin-devices-tab-content-controller');
require('./bem/controllers/admin-work-places-tab-content-controller');
require('./bem/controllers/admin-component_parts-tab-content-controller');
require('./bem/controllers/admin-workers-tab-content-controller');
require('./bem/controllers/admin-providers-tab-content-controller');
require('./bem/controllers/admin-responsibles-tab-content-controller');
require('./bem/controllers/admin-departments-tab-content-controller');
require('./bem/controllers/admin-categories-tab-content-controller');
require('./bem/controllers/worker-services-tab-content-controller');

//window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app',
// });
