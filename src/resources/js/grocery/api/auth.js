export default function useAuth(){

    const login = async (params) => {
        try{
            const response = await axios.post('/login', params);
            return response?.data || null

        }catch (error){
            throw error.response
        }
    }

    const getUser = async () => {
        try{
            const response = await axios.get('/user');
            return response?.data || null

        }catch (error){
            throw error
        }
    }


    return {
        login,
        getUser
    }
}
