<template>
    <button :class="buttonClass" :disabled="disabled" @click="handleClick">
        <svg v-if="loading" class="mr-3 h-5 w-5 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
             viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span v-if="loading" class="font-medium">processing...</span>

        <span v-if="!loading" class="font-medium">{{label}}</span>

    </button>
</template>

<script>
import {computed, defineComponent} from "vue";
import cn from "../utils/cn.js";

export default defineComponent({
    name: 'Button',
    props: {
        loading:{
            type: Boolean,
            default: false
        },
        label: {
            type: String,
            required: true
        },
        color:{
            type: String,
            default: ''
        },
        type: {
            type: String,
            default: 'button'
        },
        disabled: {
            type: Boolean,
            default: false
        },
        className: {
            type: String,
            default: 'py-2 px-4 flex justify-center items-center  bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 focus:ring-offset-blue-200 text-white w-full transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg'
        }
    },
    setup(props, {emit}) {
        const buttonClass = computed(() => {
            return cn(
                'px-4 py-2 rounded-md transition-colors duration-200',
                {
                    'bg-blue-500 text-white hover:bg-blue-600': props.color === 'primary',
                    'bg-gray-500 text-white hover:bg-gray-600': props.color === 'secondary',
                    'bg-red-500 text-white hover:bg-red-600': props.color === 'danger',
                    'cursor-not-allowed opacity-50': props.disabled,
                }
                ,
                props.className
            );
        });

        const handleClick = () => {
            emit('click');
        };

        return {
            buttonClass,
            handleClick
        };
    }
});
</script>
