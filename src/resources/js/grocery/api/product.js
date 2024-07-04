import { ref } from 'vue'

export default function useProducts() {
    const products = ref([])

    const getProducts = async () => {
        try{
            const response  = await axios.get('/products')
            products.value = response?.data?.products || []
        }catch (err){
            throw new err.response
        }


    }

    return { products, getProducts }
}
