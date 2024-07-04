import { useForm } from 'vee-validate';
import * as yup from 'yup';

export const isExistSpecificDomain = (values) => values?.email?.endsWith("@xyz.com")
export const preorderSchema = yup.object({
    name: yup.string().required('Name is required'),
    //recaptcha: yup.string().required('Recaptcha is required'),
    product_id: yup.string().required('Please select a product'),
    email: yup.string().email('Email must be a valid email address').required('Email is required'),
    phone: yup.string().test(
        'email-xyz',
        'Phone is required',
        (value, { parent }) => {
            if(isExistSpecificDomain(parent)){
                return !!value
            }
            return true;
        },
    ),
});

export const loginSchema = yup.object({
    email:yup.string().required('Email is required').email(),
    password:yup.string().required('Password is required')
})
