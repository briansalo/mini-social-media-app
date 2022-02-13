require('./bootstrap');

require('alpinejs');

window.axios = require('axios');

import { createApp } from 'vue';

import ExampleComponent from './components/ExampleComponent.vue';
import ChatMessage from './components/ChatMessage.vue';

const app = createApp({
    components:{
    	'example-component': ExampleComponent,
    	'chat-message': ChatMessage,
    	}
 }).mount('#app');