
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import $ from 'jquery';
window.$ = window.jQuery = $;

import 'jquery-ui/ui/disable-selection.js';
import 'jquery-ui/ui/widgets/sortable.js';
import 'jquery-ui/ui/widgets/tooltip.js';

window.Vue = require('vue');

import Vue from 'vue'

/* ### Like Button ### */
import VuePromiseBtn from 'vue-promise-btn';
// not required. Styles for built-in spinner
import 'vue-promise-btn/dist/vue-promise-btn.css';
Vue.use(VuePromiseBtn);

/**
 * Music player
 * @see https://github.com/SevenOutman/vue-aplayer/blob/develop/docs/README.md
 */
import VueAPlayer from 'vue-aplayer';
Vue.component('aplayer', VueAPlayer);

/**
 * Sharing buttons
 * @see https://github.com/koddr/vue-goodshare
 */
import VueGoodshare from "vue-goodshare";
Vue.component('vue-goodshare', VueGoodshare);

/**
 * Star rating
 * @see https://www.tallent.us/vue-stars/
 */
import VueStars from 'vue-stars'
Vue.component('vue-stars', VueStars);

// Toastr
import VueToastr2 from 'vue-toastr-2';
import 'vue-toastr-2/dist/vue-toastr-2.min.css'
window.toastr = require('toastr');
Vue.use(VueToastr2);

// Vue.component('v-toastr', require('./components/ToastrComponent.vue'));

// Prevue
import LinkPrevue from 'link-prevue'
Vue.component('link-prevue-base', LinkPrevue);
// Vue.use(LinkPrevue);

const BaseLinkPrevue = Vue.options.components['link-prevue-base'];
const CustomLinkPrevue = BaseLinkPrevue.extend({
  methods: {
        httpRequest: function(success, error) {
            const self = this;
            const http = new XMLHttpRequest()
            const params = 'url=' + this.url
            let token = document.head.querySelector('meta[name="csrf-token"]');
            
            http.open('POST', this.apiUrl, true)
            http.setRequestHeader('X-CSRF-TOKEN', token.content);
            http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded')
            http.onreadystatechange = function() {
                    if (http.readyState === 4 && http.status === 200) {
                        let json = JSON.parse(http.responseText);
                        if (json['error']) {
                            error();
                            self.$emit('error', json['error']);
                        } else {
                            success(http.responseText);
                        }
                    }
                if (http.readyState === 4 && http.status === 500) {
                    error()
                    }
            }
            http.send(params)
        }
  }
});

Vue.component('link-prevue', CustomLinkPrevue);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    el: '#app',
    mixins: [ (typeof __vue_mixin != 'undefined' ? __vue_mixin : {}) ], // check if the page defined a mixin
    methods: {
        $: $,
        /**
         * Toggle Like for like button
         */
        toggleLike (model, id, event) {
            var target = $(event.target).parent(); // It's always the parent
            return axios.post(BASE_URL+'/likes/toggle', {
                    model: model,
                    id: id
                })
            .then((response)  =>  {
                if(response.data.likedBy) {
                    target.find('.unlike-toggle').show();
                    target.find('.like-toggle').hide();
                } else {
                    target.find('.unlike-toggle').hide();
                    target.find('.like-toggle').show();
                }
                target.find('.btn-label').text(response.data.likesCount);
            }, (error)  =>  {
                console.log(error);
                this.$toastr.error(error, ''); // TODO: Exception error
                // TODO: Error managing in Vue
            })
        },
        /**
         * Star rating
         */
        rate (model, id, rating) {
            return axios.post(BASE_URL+'/likes/rate', {
                    model: model,
                    id: id,
                    rating: rating
                })
            .then((response)  =>  {
//                 if(response.data.likedBy) {
//                     target.find('.unlike-toggle').show();
//                     target.find('.like-toggle').hide();
//                 } else {
//                     target.find('.unlike-toggle').hide();
//                     target.find('.like-toggle').show();
//                 }
//                 target.find('.btn-label').text(response.data.likesCount);
            }, (error)  =>  {
                console.log(error);
                this.$toastr.error(error, ''); // TODO: Exception error
                // TODO: Error managing in Vue
            })
        }
    }
});
