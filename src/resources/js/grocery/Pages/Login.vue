<template>
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Sign in to your account
                    </h1>
                    <Alert v-if="result?.message" :attributes="result" @click="handleAlert"/>
                    <form autocomplete="off" @submit.prevent="submitForm" class="space-y-4 md:space-y-6" action="#">
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                            <input autocomplete="off" type="email" v-model="email" v-bind="emailAttrs" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
                            <span v-if="errors?.email" class="text-red-500">{{ errors.email }}</span>
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input autocomplete="new-password" v-model="password" v-bind="passwordAttrs" type="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                            <span v-if="errors?.password" class="text-red-500">{{ errors.password }}</span>
                        </div>
                        <div class="flex items-center justify-between">

                            <a href="#" class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">Forgot password?</a>
                        </div>
                        <div class="mb-2">
                            <Button
                                label="Login"
                                :loading="loading"
                                class="w-full text-white bg-blue-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                            />
                        </div>
                        <div class="flex justify-between">
                            <div>
                                <p class="underline">Admin</p>
                                <p>user@admin.com</p>
                                <p>123456</p>
                            </div>
                            <div>
                                <p class="underline">Manager</p>
                                <p>user@manager.com</p>
                                <p>123456</p>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import {useForm} from 'vee-validate';
import Button from "../components/Button.vue";
import {loginSchema} from "../utils/validation.js";
import {useAuthStore} from "../store/auth.js";
// import router from "../router/index.js";
import {ref} from "vue";
import Alert from "../components/Alert.vue";
import {useRouter} from "vue-router";

export default {
    name:'Login',
    components: {Alert, Button},
    setup(){
        const router = useRouter()
        const loading = ref(false);
        const result = ref({})
        const authStore = useAuthStore()
        // Initial form values
        const defaultValues = {
            email: '',
            password: ''
        }

        // Form validation process
        const {errors, handleSubmit, defineField, setErrors, resetForm} = useForm({
            validationSchema: loginSchema,
            initialValues: defaultValues
        });


        const [email, emailAttrs] = defineField('email');
        const [password, passwordAttrs] = defineField('password');

        const submitForm = handleSubmit(async (values) => {
            try {
                loading.value = true;
                result.value = {};
                await authStore.login(values)

                if (authStore.isAuthenticated) {
                    await router.push({name: 'auth'})
                }
            }catch (e) {
                result.value = {
                    type:'error',
                    message:e?.response?.data?.message || null
                }

            }finally {
                loading.value = false;
            }
        })

        const handleAlert = () => {
            result.value = {};
        }
        return {
            handleAlert,
            result,
            loading,
            errors,
            email,
            emailAttrs,
            password,
            passwordAttrs,
            submitForm
        }
    }
}
</script>

