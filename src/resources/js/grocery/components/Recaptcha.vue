<template>
    <div>
        <div ref="recaptcha" class="g-recaptcha" :data-sitekey="siteKey" @recaptcha-success="onSuccess"></div>
    </div>
</template>

<script>
import { ref, onMounted } from 'vue';

export default {
    name: 'Recaptcha',
    props: {
        siteKey: {
            type: String,
            required: true
        }
    },
    setup(props, { emit }) {
        const recaptcha = ref(null);

        const onSuccess = (token) => {
            emit('recaptcha-success', token);
        };

        const renderRecaptcha = () => {
            if (window.grecaptcha) {
                window.grecaptcha.render(recaptcha.value, {
                    sitekey: props.siteKey,
                    callback: onSuccess
                });
            } else {
                console.error('reCAPTCHA script not loaded.');
            }
        };

        onMounted(() => {
            renderRecaptcha();
        });

        return {
            recaptcha
        };
    }
};
</script>
