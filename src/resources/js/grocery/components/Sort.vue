<template>
    <svg :class="newClass" @click="handleDirection" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" class="p-2 stroke-3" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
    </svg>
</template>

<script>
import {computed, ref} from "vue";
import cn from "../utils/cn.js";
import {useRoute} from "vue-router";

export default {
    name:'Sort',
    props:{
       column:{
           type: String,
           required:true
       }
    },
    setup(props,{emit}){
        const route = useRoute()
        const direction = ref('asc')
        const newClass = computed(()=>{
            return cn(
                'ml-1 w-2.5 h-2.5 cursor-pointer text-black',
                // {
                //     'rotate-0': direction.value === 'asc',
                //     'rotate-180': direction.value === 'desc',
                // },
                {
                    'rotate-0': route?.query?.sort === 'asc' && route?.query?.column === props.column,
                    'rotate-180': route?.query?.sort === 'desc' && route?.query?.column === props.column,
                }
            )
        })

        const handleDirection = () => {
            direction.value === 'asc' ? direction.value = 'desc' : direction.value = 'asc'
            emit('sort',direction.value)
        }
        return {
            newClass,
            handleDirection
        }
    }
}
</script>
