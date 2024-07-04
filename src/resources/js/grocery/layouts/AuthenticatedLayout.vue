<script setup>
import Loader from "../components/Loader.vue";
import Sidebar from "../components/partials/Sidebar.vue";
import Header from "../components/partials/Header.vue";
import {useLoader} from "../store/auth.js";

const loader = useLoader()
</script>

<template>
    <div class="flex h-screen bg-gray-200">
        <Loader v-if="loader.isLoading"/>
        <div class="hidden fixed inset-0 z-20 transition-opacity bg-black opacity-50 lg:hidden"></div>
        <Sidebar/>
        <div class="flex flex-col flex-1 overflow-hidden">
            <Header/>
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                <div class="container px-6 py-8 mx-auto">
                    <router-view></router-view>
                </div>
            </main>
        </div>
    </div>
</template>
