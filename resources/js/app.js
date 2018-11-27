import Vue from "vue"
import VueAWN from "vue-awesome-notifications"
require("vue-awesome-notifications/dist/styles/style.css")
// import router from './router/router.js'
// import App from './views/App.vue'
import VueI18n from 'vue-i18n'
import translate from './lang/translate.js'
import BetterInputTag from 'better-vue-input-tag'

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');

Vue.use(VueAWN);
Vue.use(VueI18n);
Vue.use(require('vue-moment'));

const lang = document.documentElement.lang.substr(0, 2); 

// Create VueI18n instance with options
const i18n = new VueI18n({
  locale: lang, // set locale
  messages: translate, // set locale messages
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import VueTagsInput from '@johmun/vue-tags-input';

Vue.component('vue-tags-input', VueTagsInput)

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('languages', require('./components/navbar/Languages.vue'));
Vue.component('editor-component', require('./components/post/EditorComponent.vue'));
Vue.component('form-component', require('./components/FormComponent.vue'));
Vue.component('edit-component', require('./components/post/EditComponent.vue'));
Vue.component('timeline-component', require('./components/TimelineComponent.vue'));
Vue.component('chat-component', require('./components/chat/ChatComponent.vue'));
Vue.component('user-component', require('./components/chat/UserComponent.vue'));
Vue.component('chat-form-component', require('./components/chat/ChatFormComponent.vue'));
Vue.component('message-component', require('./components/chat/MessageComponent.vue'));
Vue.component('chat-messages-component', require('./components/chat/ChatMessagesComponent.vue'));
Vue.component('post-component', require('./components/post/PostComponent.vue'));
Vue.component('welcome-component', require('./components/welcome/WelcomeComponent.vue'));
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('comments-component', require('./components/comment/CommentsComponent.vue'));
Vue.component('like-component', require('./components/like/LikeComponent.vue'));
Vue.component('my-favorite', require('./components/like/MyFavorite.vue'));
Vue.component('settings-component', require('./components/settings/SettingsComponent.vue'));
Vue.component('upload', require('./components/settings/Upload.vue'));
Vue.component('info-component', require('./components/user/InfoComponent.vue'));
Vue.component('main-info', require('./components/user/MainInfo.vue'));
Vue.component('following-component', require('./components/user/FollowingComponent.vue'));
Vue.component('following-list', require('./components/user/FollowingList.vue'));
Vue.component('follower-list', require('./components/user/FollowerList.vue'));
Vue.component('follow-component', require('./components/user/FollowComponent.vue'));
Vue.component('portfolio-form', require('./components/portfolio/PortfolioForm.vue'));
Vue.component('portfolio-edit', require('./components/portfolio/PortfolioEdit.vue'));
Vue.component('portfolio-index', require('./components/portfolio/PortfolioIndex'));
Vue.component('portfolio-show', require('./components/portfolio/PortfolioShow'));

const app = new Vue({
    el: '#app',
    i18n
    // components: { App },
    // // router
});
