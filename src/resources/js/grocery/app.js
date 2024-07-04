
import { createApp } from 'vue';
import './grocery.css';
import router from "./router/index.js";
import App from './App.vue';
import { createPinia } from 'pinia';
import { getCookie } from './utils/cookie.js';
import { useAuthStore } from './store/auth.js';

const app = createApp(App);
app.use(createPinia());

import './bootstrap.js'
const main = () => {
    app.use(router);
    app.mount("#app");
}

const token = getCookie('access_token')

if(token){
   useAuthStore().getAuth().then(()=>main())
}else{
    main()
}


