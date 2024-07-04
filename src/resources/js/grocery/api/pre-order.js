import {ref} from "vue";

export default function usePreOrder() {

    const prefix = 'preorder';
    const preorders = ref([])
    const createPreOrder = async (params) => {
        try {
            return await axios.post(`/${prefix}/create`, params);
        } catch (err) {
            throw err.response;
        }

    }

    const fetchPreOrderList = async (params) => {
        try {
            const response = await axios.get(`/${prefix}/list`, {
                params
            });
            // console.log('response', response)
            preorders.value = response.data || []
        } catch (err) {

            throw err.response;
        }

    }

    const deletePreOrder = async (id) => {
        try {
            const response = await axios.delete(`/${prefix}/delete/${id}`);
            await fetchPreOrderList({})
            return response?.data || []
        } catch (err) {
            throw err.response;
        }

    }


    return {
        preorders,
        createPreOrder,
        fetchPreOrderList,
        deletePreOrder
    }

}
