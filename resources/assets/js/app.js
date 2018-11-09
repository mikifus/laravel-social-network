
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
import VuePromiseBtn from 'vue-promise-btn'

// not required. Styles for built-in spinner
import 'vue-promise-btn/dist/vue-promise-btn.css'

Vue.use(VuePromiseBtn) // or with global options Vue.use(VuePromiseBtn, {})

$('.btn-like').each(function(){
    var liked = $(this).data('liked');
    
    /*var like_button = */new Vue({
    el: this,
    data: {
        liked: liked
    },
    methods: {
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
                // TODO: Error managing in Vue
            })
        }
    }
    });
});


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example', require('./components/Example.vue'));
//
//const app = new Vue({
//    el: '#app'
//});
