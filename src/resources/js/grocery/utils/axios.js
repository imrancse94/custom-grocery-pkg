import axios from 'axios';
import {deleteCookie, getCookie, setCookie} from "./cookie.js";
import router from "./../router/index.js";
import { useLoader } from '../store/auth.js';

const axiosInstance = axios.create({
    baseURL: '/grocery'
});


let requestsPending = 0;
const req = {
    pending: () => {
        const loader = useLoader()
        requestsPending++;
        loader.setLoader(true)
    },
    done: () => {
        const loader = useLoader()
        requestsPending--;
        if (requestsPending <= 0) {
            loader.setLoader(false)
        }
    }
};

axiosInstance.interceptors.request.use(
    (config) => {
        req.pending();
        const authToken = getCookie('access_token');
        if (authToken) {
            config.headers.Authorization = `Bearer ${authToken}`;
        }
        return config;
    },
    (error) => {
        req.done();
       return Promise.reject(error)
    }
);

// Add a response interceptor
axiosInstance.interceptors.response.use(
    (response) => {
        req.done();
       return response
    },
    async (error) => {
        req.done();
        const originalRequest = error.config;

        // If the error status is 401 and there is no originalRequest._retry flag,
        // it means the token has expired and we need to refresh it
        if (error.response.status === 401 && !originalRequest._retry) {
            originalRequest._retry = true;

            try {
                const response = await axios.post(`/grocery/refresh-token`, {
                    refresh_token: getCookie('refresh_token') || null
                }, {
                    headers: {
                        'Content-Type': 'application/json',
                        "Authorization": 'Bearer ' + getCookie('access_token')
                    }
                });

                const {access_token, refresh_token} = response.data;

                if (access_token && refresh_token) {
                    setCookie('access_token', access_token)
                    setCookie('refresh_token', refresh_token)
                    originalRequest.headers.Authorization = `Bearer ${access_token}`;
                    return axios(originalRequest);
                }

            } catch (error) {
                // we can log the reason from error message
            }
        }

        deleteCookie('access_token')
        deleteCookie('refresh_token')
        await router.push({name: 'login'})

        return Promise.reject(error);
    })

export default axiosInstance;


// npm i vue@latest vue-router yup clsx pinia sweetalert2 tailwind-merge vee-validate @vitejs/plugin-vue

// @php artisan vendor:publish --tag=grocery

