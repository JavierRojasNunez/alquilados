/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('user-component', require('./components/UserComponent.vue').default);
Vue.component('my-profile-component', require('./components/MyProfileComponent.vue').default);
Vue.component('form-component', require('./components/FormComponent.vue').default);
Vue.component('product-component', require('./components/ProductComponent.vue').default);
Vue.component('my-products-component', require('./components/MyProductsComponent.vue').default);
Vue.component('chat-messages-component', require('./components/ChatMessagesComponent.vue').default);
Vue.component('chat-form-component', require('./components/ChatFormComponent.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 


 const app = new Vue({
    el: '#app',

    data: {
        messages: []
    },

    created() {
        this.fetchMessages();
      
        Echo.private('chat')
        .listen('MessageSent', (e) => {
        
          this.messages.push({
            message: e.message.message,
            user: e.user
          });
          
        });
        //this.scrollToElement();
        
    },
    mounted() {
     // this.scrollToElement();
    },
    

    methods: {
        fetchMessages() {
            axios.get('/alquilados/public/messages').then(response => {
                this.messages = response.data;
            });
          //  this.scrollToElement();
        },

        

        addMessage(message) {
          
            this.messages.push(message);

            axios.post('/alquilados/public/messages', message).then(response => {
              console.log(response.data);
            });
        }
    }
});


