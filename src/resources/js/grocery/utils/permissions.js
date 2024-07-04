import {useAuthStore} from "../store/auth.js";

const $can = (key)=>{
    const authStore = useAuthStore();

    return authStore.permission.includes('*') || authStore.permission.includes(key)
}

export default $can
