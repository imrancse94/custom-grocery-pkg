import { defineStore } from 'pinia';
import useAuth from "../api/auth.js";
import { setCookie } from "../utils/cookie.js";

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: {},
        isAuthenticated: false,
        permission: []
    }),
    actions: {
        async login(params) {
            try {
                const { login } = useAuth();
                const { user, access_token, refresh_token, permission } = await login(params);

                if (access_token && refresh_token) {
                    setCookie('access_token', access_token);
                    setCookie('refresh_token', refresh_token);
                    this.isAuthenticated = true;
                    this.user = { ...user } || {};
                    this.permission = [...permission] || [];
                }
            } catch (err) {
                throw err
            }
        },

        async getAuth() {
            try {
                const { getUser } = useAuth();

                const { user, access_token, refresh_token, permission } = await getUser();

                if (access_token && refresh_token) {
                    setCookie('access_token', access_token);
                    setCookie('refresh_token', refresh_token);
                    this.isAuthenticated = true;
                    this.user = { ...user } || {};
                    this.permission = [...permission] || [];
                }
            } catch (err) {
                console.log('err',err)
                throw err
            }
        }
    }

})

export const useLoader = defineStore('loader', {
    state: () => ({
        isLoading: false
    }),
    actions: {
        setLoader(value) {
            this.isLoading = value;
        }
    }
})
