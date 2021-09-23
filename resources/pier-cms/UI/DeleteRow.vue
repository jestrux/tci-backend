<template>
  <div class="modal open">
    <div class="modal-content" style="width: 450px">		
      <div class="modal-body overflow-y-auto" style="max-height: 480px;">
        <p class="m-0 pt-2 px-4 text-xl text-center">
          Are you sure you want to delete this row?
        </p>
      </div>
      <div class="modal-buttons">
        <button class="p-2 font-bold text-sm tracking-wider"
          :class="{'pointer-events-none opacity-50' : deletingRecord}"
          @click="$router.replace(`/${selectedModelName}`)">
          No, Cancel
        </button>
        <button class="bg-red-100 border-red-200 font-semibold px-4 py-2 rounded text-red-500 text-red-600 text-sm tracking-wider" 
          :class="{'pointer-events-none opacity-50' : deletingRecord}"
          @click="deleteRow(null, true)">
          {{ deletingRecord ? 'Deleting...' : 'Yes, Delete' }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex';
  export default {
    name: 'PierCMSDeleteRow',
    props: {
      rowId: {
        type: String,
        required: true
      }
    },
    computed: {
      ...mapState(['selectedModelName', 'deletingRecord'])
    },
    methods: {
      deleteRow(){
        this.$store.dispatch('removeRecord', this.rowId);
      },
    }
  }
</script>