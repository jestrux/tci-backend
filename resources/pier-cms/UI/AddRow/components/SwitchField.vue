<template>
    <label style="display: flex" class="capitalize items-center">
        <vs-switch val="false" v-model="val" />

        <span class="ml-4" style="margin-bottom: 0.3rem;">
            {{ label }}
        </span>
    </label>
</template>

<script>
import { vsSwitch } from 'vuesax';
import 'vuesax/dist/vuesax.css';

export default {
    name: "SwitchField",
    props: {
        label: String,
        value: Boolean
    },
    mounted() {
        if(this.value)
            this.val = this.value;
    },
    data() {
        return {
            val: false
        }
    },
    watch: {
        val: function(newValue){
            this.$emit('input', newValue);
        }
    },
    components: {
        vsSwitch
    }
}
</script>