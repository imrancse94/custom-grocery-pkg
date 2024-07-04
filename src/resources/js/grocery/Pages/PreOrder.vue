<template>
    <div>
        <div class="bg-gray-200 min-h-screen flex items-center">
            <div class="w-full">
                <div class="bg-white mt-2 p-10 rounded-lg shadow md:w-3/4 mx-auto lg:w-1/2">
                    <h2 class="text-center text-blue-600 font-bold text-2xl uppercase mb-4">Pre-Order Form</h2>
                    <Alert v-if="result?.message" :attributes="result" @click="handleAlert" />
                    <form @submit.prevent="submitForm">
                        <div class="mb-3">
                            <label for="name" class="block mb-2 font-bold text-gray-600">Name</label>
                            <input v-model="name" v-bind="nameAttrs" type="text" id="name" name="name"
                                placeholder="Put in your full name."
                                class="border border-gray-300 shadow p-2.5 w-full rounded mb-" />
                            <span v-if="errors?.name" class="text-red-500">{{ errors.name }}</span>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="block mb-2 font-bold text-gray-600">Email</label>
                            <input v-model="email" v-bind="emailAttrs" type="email" id="email" name="email"
                                placeholder="Put in your email."
                                class="border border-gray-300 shadow p-2.5 w-full rounded" />
                            <span v-if="errors?.email" class="text-red-500">{{ errors.email }}</span>
                        </div>

                        <div class="mb-3" v-if="email?.endsWith('@xyz.com')">
                            <label for="phone" class="block mb-2 font-bold text-gray-600">Phone</label>
                            <input v-model="phone" v-bind="phoneAttrs" type="text" id="phone" name="phone"
                                placeholder="Put in your phone number."
                                class="border border-gray-300 shadow p-2.5 w-full rounded " />
                            <span v-if="errors?.phone" class="text-red-500">{{ errors.phone }}</span>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="block mb-2 font-bold text-gray-600">Product</label>
                            <select v-model="product_id" v-bind="productAttrs"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected value="">Choose a product</option>
                                <option v-for="product in products" :value="product.id">{{ product.name }}</option>
                            </select>
                            <span v-if="errors?.product_id" class="text-red-500">{{ errors.product_id }}</span>

                        </div>

                        <div class="mb-5">
                            <Recaptcha :siteKey="siteKey" @recaptcha-success="onRecaptchaSuccess" />
                            <span v-if="errors?.recaptcha" class="text-red-500">{{ errors.recaptcha }}</span>
                        </div>
                        <div class="mb-3">
                            <Button :loading="isSubmitting" label="Submit" class="block w-full py-3" />
                        </div>
                        <div class="text-center">
                            <Link class="underline text-blue-700" href="/login">
                            User Login
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { useForm } from 'vee-validate';
import { onMounted, ref } from "vue";
import useProducts from "../api/product.js";
import { isExistSpecificDomain, preorderSchema } from "../utils/validation.js";
import usePreOrder from "../api/pre-order.js";
import Recaptcha from "../components/Recaptcha.vue";
import Button from "../components/Button.vue";
import Alert from "../components/Alert.vue";
import Link from "../components/Link.vue";


export default {
    components: { Link, Alert, Button, Recaptcha },
    setup() {

        const result = ref({})
        const isSubmitting = ref(false);
        const { products, getProducts } = useProducts()
        const { createPreOrder } = usePreOrder()

        onMounted(async () => {
            await getProducts()
        })

        // start Recaptcha
        const siteKey = ref(import.meta.env.VITE_GOOGLE_RECAPTCHA_KEY);
        const recaptchaToken = ref('');

        // recaptcha event
        const onRecaptchaSuccess = (token) => {
            recaptchaToken.value = token;
        };

        // Initial form values
        const defaultValues = {
            name: '',
            email: '',
            phone: '',
            product_id: ''
        }

        // Form validation process
        const { errors, handleSubmit, defineField, setErrors, resetForm } = useForm({
            validationSchema: preorderSchema,
            initialValues: defaultValues
        });


        const [email, emailAttrs] = defineField('email');
        const [name, nameAttrs] = defineField('name');
        const [phone, phoneAttrs] = defineField('phone');
        const [product_id, productAttrs] = defineField('product_id');

        const submitForm = handleSubmit(async (values) => {
            if (!recaptchaToken.value) {
                setErrors({ recaptcha: 'Captcha is required' })
                return;
            }
            if (!isExistSpecificDomain(values)) {
                values.phone = "";
            }

            try {
                result.value = null;
                isSubmitting.value = true;
                const params = { ...values, recaptchaToken: recaptchaToken.value };
                const response = await createPreOrder(params);

                if (response?.data?.message) {
                    result.value = {
                        type: 'success',
                        message: response?.data?.message
                    }
                } else {
                    result.value = {
                        type: 'error',
                        message: response?.data?.error
                    }
                }

            } catch (error) {

                result.value = {
                    type: 'error',
                    message: error?.data?.errors?.recaptchaToken || 'Unknown error. Please try again'
                }

                if (error?.status === 429) {
                    result.value = {
                        type: 'error',
                        message: error?.data?.message || 'Unknown error. Please try again'
                    }
                }
            } finally {
                isSubmitting.value = false;
                resetForm()
                grecaptcha.reset();
            }

        });

        const handleAlert = () => {
            result.value = null
        }


        return {
            result,
            handleAlert,
            isSubmitting,
            siteKey,
            onRecaptchaSuccess,
            defaultValues,
            products,
            errors,
            name,
            nameAttrs,
            product_id,
            productAttrs,
            email,
            emailAttrs,
            phone,
            phoneAttrs,
            submitForm
        };
    }
};
</script>
