<template>
    <router-link :to="href" :class="newClass">
        <slot></slot>
    </router-link>
</template>

<script>
import {computed} from "vue";
import cn from "../utils/cn.js";

export default {
    name:'Link',
    props:{
        href:{
            type:String,
            required:true
        },
        class:{
            type:String,
            default:''
        }
    },
    setup(props){
        const newClass = computed(()=>{
            return cn(
                '',
                props.class
            )
        });

        return {
            newClass
        }
    }
}
</script>
