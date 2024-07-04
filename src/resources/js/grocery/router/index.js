import {createRouter, createWebHistory} from "vue-router";
import routes from "./routes.js";
import {getCookie, setCookie} from "../utils/cookie.js";


const router = createRouter({
    history: createWebHistory('grocery'),
    routes,
});


router.beforeEach((to, from, next) => {
    const token = getCookie('access_token') || null;

    if (to.matched.some(record => record.meta.auth)) {

        if (token) {
            next()
        } else {
            next({name: 'login'})
        }
    } else {
        if (token && to.matched.some(record => record?.meta?.disable_after_auth)) {
            next({name: 'auth'})
        } else {
            next()
        }
    }
})
export default router;
