<style>
    .autocomplete-input{
        padding-left: 48px !important;
    }
</style>
<template>
    <div id="locationField">
        <autocomplete 
            :placeholder="`Type to search for ${label}`"
            :search="search" 
            :get-result-value="({name}) => name"
            :debounceTime="300"
            @submit="handleSubmit"
        />

        <div v-if="mapLocation && mapLocation.length" class="mt-3">
            <FieldPreview type="location" :url="mapLocation" />
        </div>
    </div>
</template>

<script>
import Autocomplete from '@trevoreyre/autocomplete-vue'
import '@trevoreyre/autocomplete-vue/dist/style.css'
import FieldPreview from "../components/FieldPreview";
import { getMapLocation } from '../../../Utils';

async function getLocation(location){
    const response = await fetch(`https://nominatim.openstreetmap.org/search?q=${location}&format=json&limit=10&addressdetails=1`);
    const results = await response.json();

    return results.map(({display_name, lon, lat}) => ({
        name: display_name,
        coords: [lon, lat]
    }));
}


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
                    const results = await getLocation(input);
                    resolve(results);
                } catch (error) {
                    reject("Failed to search for field.");
                    console.log("Failed to search for field.", error);
                }
            });
        },
        handleSubmit(result) {
            this.val = JSON.stringify(result)
        }
    },
    computed: {
        mapLocation(){
            return getMapLocation(this.val, 170, 170);
        }
    },
    watch: {
        val: function(newValue){
            this.$emit('input', newValue);
        }
    },
    components: {
        Autocomplete,
        FieldPreview
    }
}
</script>