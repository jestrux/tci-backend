<style>
    .autocomplete-input{
        padding-left: 48px !important;
    }
</style>
<template>
    <autocomplete 
        :placeholder="`Type to search for ${label}`"
        :search="search" 
        :get-result-value="getResultValue"
        :debounceTime="300"
        @submit="handleSubmit"
    />
</template>

<script>
import Autocomplete from '@trevoreyre/autocomplete-vue'
import '@trevoreyre/autocomplete-vue/dist/style.css'
import { searchModel } from '../../../API';

export default {
    name: "ReferenceField",
    props: {
        referenceModel: String,
        label: String,
        value: String
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
    methods: {
        search(input) {
            if (input.length < 1) { return [] }

            return new Promise(async (resolve, reject) => {
                try {
                    const results = await searchModel(this.referenceModel, input);
                    resolve(results);
                } catch (error) {
                    reject("Failed to search for field.");
                    console.log("Failed to search for field.", error);
                }
            });
        },
        getResultValue(result) {
            return result.label;
        },
        handleSubmit(result) {
            this.val = result._id;
        }
    },
    watch: {
        val: function(newValue){
            this.$emit('input', newValue);
        }
    },
    components: {
        Autocomplete
    }
}
</script>