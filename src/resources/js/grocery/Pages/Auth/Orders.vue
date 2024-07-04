<template>
    <div class="p-6 relative flex flex-col w-full h-full text-gray-700 bg-white shadow-md rounded-xl bg-clip-border">
        <div class="relative mt-4 overflow-hidden text-gray-700 bg-white rounded-none bg-clip-border">
            <div class="flex items-center justify-between gap-8 mb-10">
                <div>
                    <h5
                        class="block font-sans text-xl antialiased font-semibold leading-snug tracking-normal text-blue-gray-900">
                        Order list
                    </h5>

                </div>

            </div>
            <div class="flex flex-col items-center justify-between gap-4 md:flex-row">
                <div class="block w-full overflow-hidden md:w-max">
                    <label for="countries_disabled"
                        class="block mb-2 text-xs font-medium text-gray-900 dark:text-white">Show per page</label>
                    <select v-model="filter.pagination" @change="handlePagination($event.target.value)"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="5">5</option>
                        <option selected value="10">10</option>
                        <option value="15">15</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="w-full md:w-72">
                    <div class="relative h-10 w-full min-w-[200px]">
                        <div
                            class="cursor-pointer absolute grid w-5 h-5 top-2/4 right-3 -translate-y-2/4 place-items-center text-blue-gray-500">
                            <svg @click="handleSearch" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                                class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z">
                                </path>
                            </svg>
                        </div>
                        <input
                            class="peer h-full w-full rounded-[7px] border border-gray-500 bg-transparent px-3 py-2.5 !pr-9 font-sans text-sm font-normal text-blue-gray-700 outline outline-0 transition-all placeholder-shown:border placeholder-shown:border-blue-gray-200 placeholder-shown:border-t-blue-gray-200 focus:border-2 focus:border-gray-900 focus:border-t-transparent focus:outline-0 disabled:border-0 disabled:bg-blue-gray-50"
                            placeholder=" " v-model="filter.search" />
                        <label
                            class="before:content[' '] after:content[' '] pointer-events-none absolute left-0 -top-1.5 flex h-full w-full select-none !overflow-visible truncate text-[11px] font-normal leading-tight text-gray-500 transition-all before:pointer-events-none before:mt-[6.5px] before:mr-1 before:box-border before:block before:h-1.5 before:w-2.5 before:rounded-tl-md before:border-t before:border-l before:border-blue-gray-200 before:transition-all after:pointer-events-none after:mt-[6.5px] after:ml-1 after:box-border after:block after:h-1.5 after:w-2.5 after:flex-grow after:rounded-tr-md after:border-t after:border-r after:border-blue-gray-200 after:transition-all peer-placeholder-shown:text-sm peer-placeholder-shown:leading-[3.75] peer-placeholder-shown:text-blue-gray-500 peer-placeholder-shown:before:border-transparent peer-placeholder-shown:after:border-transparent peer-focus:text-[11px] peer-focus:leading-tight peer-focus:text-gray-900 peer-focus:before:border-t-2 peer-focus:before:border-l-2 peer-focus:before:!border-gray-900 peer-focus:after:border-t-2 peer-focus:after:border-r-2 peer-focus:after:!border-gray-900 peer-disabled:text-transparent peer-disabled:before:border-transparent peer-disabled:after:border-transparent peer-disabled:peer-placeholder-shown:text-blue-gray-500">
                            Search
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-6 px-0 overflow-auto">
            <table class="w-full mt-4 text-left table-auto min-w-max">
                <thead>
                    <tr>
                        <th
                            class="p-4 transition-colors cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 hover:bg-blue-gray-50">
                            <p
                                class="flex items-center font-sans text-sm antialiased font-bold leading-none text-blue-gray-900 opacity-70">
                                Id
                                <Sort @sort="handleSortId" :direction="filter.sort" column="id" />
                            </p>
                        </th>
                        <th
                            class="p-4 transition-colors cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 hover:bg-blue-gray-50">
                            <p
                                class="flex items-center font-sans text-sm antialiased font-bold leading-none text-blue-gray-900 opacity-70">
                                Name
                                <Sort @sort="handleSortName" :direction="filter.sort" column="name" />
                            </p>
                        </th>
                        <th
                            class="p-4 transition-colors cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 hover:bg-blue-gray-50">
                            <p
                                class="flex items-center font-sans text-sm antialiased font-bold leading-none text-blue-gray-900 opacity-70">
                                Email
                                <Sort @sort="handleSortEmail" column="email" />
                            </p>
                        </th>
                        <th
                            class="p-4 transition-colors cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 hover:bg-blue-gray-50">
                            <p
                                class="flex items-center font-sans text-sm antialiased font-bold leading-none text-blue-gray-900 opacity-70">
                                Product Name
                                <Sort @sort="handleSortProductName" column="product_name" />
                            </p>
                        </th>

                        <th
                            class="p-4 transition-colors cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 hover:bg-blue-gray-50">
                            <p
                                class="flex items-center font-sans text-sm antialiased font-bold leading-none text-blue-gray-900 opacity-70">
                                Created At
                                <Sort @sort="handleSortCreatedAt" column="created_at" />
                            </p>
                        </th>
                        <th v-if="$can('preorder.delete')"
                            class="p-4 transition-colors cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 hover:bg-blue-gray-50">
                            <p
                                class="flex items-center font-sans text-sm antialiased font-bold leading-none text-blue-gray-900 opacity-70">
                                Action
                            </p>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="preorders?.data?.length > 0" v-for="order in preorders.data">
                        <td class="p-4 border-b border-blue-gray-50">
                            <div class="flex flex-col">
                                <p
                                    class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    {{ order.id }}
                                </p>
                            </div>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <div class="flex flex-col">
                                <p
                                    class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    {{ order.name }}
                                </p>
                            </div>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <div class="flex flex-col">
                                <p
                                    class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    {{ order.email }}
                                </p>
                            </div>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <div class="flex flex-col">
                                <p
                                    class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    {{ order.product_name }}
                                </p>
                            </div>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <div class="flex flex-col">
                                <p
                                    class="block font-sans text-sm antialiased font-normal leading-normal text-blue-gray-900">
                                    {{ setFormatDate(order.created_at, 'Y-m-d H:i A') }}
                                </p>
                            </div>
                        </td>
                        <td v-if="$can('preorder.delete')" class="p-4 border-b border-blue-gray-50">
                            <button
                                @click="handleDelete(order.id)"
                                class="relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase text-gray-900 transition-all hover:bg-gray-900/10 active:bg-gray-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                type="button">
                                <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        aria-hidden="true" class="w-4 h-4 text-red-700">
                                        <path fill-rule="evenodd"
                                            d="M3 6h18v2H3V6zm3 3v10a2 2 0 002 2h8a2 2 0 002-2V9H6zm3-6h6v2H9V3z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </button>
                        </td>
                    </tr>
                    <tr v-else>
                        <td colspan="6" class="text-center bg-gray-200 p-2 font-bold">No data found</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <Pagination
            :from="preorders?.from || 0"
            :to="preorders?.to || 0"
            :total="preorders?.total || 0"
            :links="preorders?.links || []"
            :current="preorders?.current_page || 0"
            :last="preorders?.last_page || 0"
            @query="getPreOrderList"
        />
    </div>
</template>

<script>
import Sort from "../../components/Sort.vue";
import usePreOrder from "../../api/pre-order.js";
import { onMounted, ref } from "vue";
import { setFormatDate } from "../../utils/date-format.js";
import Pagination from "../../components/Pagination.vue";
import { useRoute, useRouter } from 'vue-router'
import $can from "../../utils/permissions.js";
import swal from "../../utils/sweetalert.js";

export default {
    name: 'Orders',
    methods: { $can },
    components: { Pagination, Sort },
    setup() {
        const route = useRoute()
        const router = useRouter();
        const filter = ref({
            pagination: 10
        })
        const { preorders, fetchPreOrderList,deletePreOrder } = usePreOrder();

        const getPreOrderList = (params) => {
            filter.value = { ...filter.value, ...params }
            return fetchPreOrderList(filter.value)
        }
        const updateQueryParams = (obj) => {
            router.push({
                path: route.path,
                query: { ...obj }
            })
        }

        onMounted(async () => {
            filter.value = { ...filter.value, ...route?.query }
            await getPreOrderList(filter.value)
        })

        const handlePagination = async (p) => {
            const newParams = { ...filter.value }
            delete newParams.page;
            await getPreOrderList(newParams)
            updateQueryParams(newParams)
        }
        const sortBy = async (column, direction) => {
            const mergedParams = { ...filter.value, column, sort: direction }
            filter.value = mergedParams;
            await getPreOrderList(mergedParams)
            updateQueryParams(mergedParams)
        }

        const handleSortId = async (direction) => {
            await sortBy('id', direction);
        }

        const handleSortName = async (direction) => {
            await sortBy('name', direction);
        }

        const handleSortEmail = async (direction) => {
            await sortBy('email', direction);
        }

        const handleSortProductName = async (direction) => {
            await sortBy('product_name', direction);
        }

        const handleSortCreatedAt = async (direction) => {
            await sortBy('created_at', direction);
        }
        const handleSearch = async () => {
            await getPreOrderList({ ...filter.value })
            updateQueryParams({ ...filter.value })
        }

        const handleDelete = async (id) => {
            try {
                const result = await swal({type: 'delete'})
                if (result.isConfirmed) {
                    const response = await deletePreOrder(id)
                    if (response?.message) {
                        await swal({type: 'success', message: response?.message})
                    }
                }

            }catch (e) {
                await swal({type: 'error', message: 'Something went wrong.Please try again.'})
            }

        }

        return {
            handleDelete,
            handleSortId,
            handleSortName,
            handleSortEmail,
            handleSortProductName,
            handleSortCreatedAt,
            filter,
            preorders,
            setFormatDate,
            getPreOrderList,
            handlePagination,
            handleSearch
        }
    }
}
</script>
