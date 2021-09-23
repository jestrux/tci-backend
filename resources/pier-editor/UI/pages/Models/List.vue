<template>
  <div v-if="models" class="h-full w-full flex items-center justify-center">
    <c-text v-if="models.length" fontSize="4xl" color="#444">
      Add your first Pier model to get started.
    </c-text>
    <c-text v-else fontSize="4xl" color="#444">
      Pick a model to edit or add a new one.
    </c-text>
  </div>
</template>

<script>

import { CBox, CText, CButton, CIcon, CLink, CStack, 
  CCircularProgress, CCircularProgressLabel 
} from '@chakra-ui/vue';
import { mapState } from 'vuex';

export default {
  name: "ModelsList",
  mounted() {
    if(!this.models)
        this.fetchModels();
  },
  data() {
    return {};
  },
  computed: {
    ...mapState(['models', 'fetchingModels'])
  },
  methods: {
    fetchModels(page = 1){
      this.$store.dispatch('getModels', page);
    },
    deleteModel(modelId) {
      this.$store.dispatch('removeModel', modelId);
    },
  },
  components: {
    CBox, CText, CButton, CIcon, CLink, CStack, 
    CCircularProgress, CCircularProgressLabel
  }
};
</script>