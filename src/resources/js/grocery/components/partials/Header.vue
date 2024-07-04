<template>
    <header
        class="print:hidden flex items-center justify-between px-6 py-4 bg-white border-b-4 border-indigo-600">
        <div class="flex items-center">
            <button class="text-gray-500 focus:outline-none lg:hidden">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2"
                          stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </button>
            <div class="relative mx-4 lg:mx-0"><span class="absolute inset-y-0 left-0 flex items-center pl-3">
         </span>
            </div>
        </div>
        <div class="flex items-center">
            <div class="relative">
                <button type="button" @click="handleDropDown" class="relative block w-8 h-8 overflow-hidden rounded-full shadow focus:outline-none">
                    <img class="object-cover w-full h-full"
                         src="https://images.unsplash.com/photo-1528892952291-009c663ce843?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=296&amp;q=80"
                         alt="Your avatar"></button>
                    <div v-show="isDropdownVisible" class="absolute right-0 z-10 w-48 mt-2 overflow-hidden bg-white rounded-md shadow-xl">
<!--                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">Profile</a>-->
                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white" href="#" @click.prevent="handleLogout">Logout</a>
                    </div>
            </div>
        </div>
    </header>
</template>

<script>

import {ref} from "vue";
import {deleteCookie} from "../../utils/cookie.js";
import {useRouter} from "vue-router";

export default {
    name:'Header',
    setup(){
        const router = useRouter();
        const isDropdownVisible = ref(false);

        const handleDropDown = () => isDropdownVisible.value = !isDropdownVisible.value

        const handleLogout = () => {
            deleteCookie('access_token')
            deleteCookie('refresh_token')
            router.push({name:'login'})
        }

        return {
            handleLogout,
            isDropdownVisible,
            handleDropDown
        }
    }
}

</script>
