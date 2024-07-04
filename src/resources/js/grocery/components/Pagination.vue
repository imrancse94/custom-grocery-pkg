<template>
    <div class="flex items-center justify-between p-2">
        <p class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
            Showing {{from}} to {{to}} of {{total}} entries
        </p>
        <div class="flex gap-2">
            <nav aria-label="Page navigation example">
                <ul v-if="links?.length > 0" class="flex items-center -space-x-px h-8 text-sm">
                    <li>
                        <a href="#"
                           :class="{'pointer-events-none cursor-default':current === 1}"
                           @click.prevent="handleRoute(current - 1)"
                           class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span class="sr-only">Previous</span>
                            <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2" d="M5 1 1 5l4 4"/>
                            </svg>
                        </a>
                    </li>
                    <li v-for="link in links">
                        <a href="#"
                            v-if="link.label > 0 && last != 1"
                            @click.prevent="handleRoute(link.label)"
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300"
                            :class="{'bg-blue-700 text-white':link.active}"
                        >
                            {{link.label}}
                        </a>
                    </li>

                    <li>
                        <a href="#"
                           :class="{'pointer-events-none cursor-default':current === last}"
                           @click.prevent="handleRoute(current + 1)"
                           class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <span class="sr-only">Next</span>
                            <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>

import Link from "./Link.vue";
import { useRoute,useRouter } from 'vue-router'
export default {
    components: {Link},
    props: {
        last: {
            type: Number,
            required: true
        },
        current: {
            type: Number,
            required: true
        },
        to: {
            type: Number,
            required: true
        },
        from: {
            type: Number,
            required: true
        },
        total: {
            type: Number,
            required: true
        },
        links: {
            type: Array,
            required: true
        }
    },

    setup(props,{emit}){
        const route = useRoute()
        const router = useRouter();

        const updateQueryParams = (obj) => {
            router.push({
                path: route.path,
                query: { ...route.query,...obj}
            })
        }
        const handleRoute = (currentPage) => {
            emit('query',{...route.query,page:currentPage})
            updateQueryParams({page: currentPage})
        }

        return {
            handleRoute
        }
    }
}

</script>

