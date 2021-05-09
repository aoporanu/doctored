import Vue from "vue";

require('./bootstrap');
window.Vue = require('vue');
window.$ = require('jquery');
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'


Vue.component('video-component', require('./components/VideoComponent').default);
Vue.component('log-component', require('./components/LogComponent').default);
Vue.component('video-form', require('./components/VideoForm').default);
// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

const app = new Vue({
    el: '#main',

    data: {
        isActive: false
    },

    methods: {
        miniPhotoWrapper: function () {
            this.isActive = !this.isActive;
        }
    }
})

