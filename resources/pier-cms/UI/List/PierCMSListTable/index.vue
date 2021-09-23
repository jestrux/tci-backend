<style scoped>
  .pier-th.image,
  .pier-th.phone,
  .pier-th.email,
  .pier-th.video,
  .pier-th.rating,
  .pier-th.location,
  .pier-th.boolean,
  .pier-th.status,
  .pier-th.color,
  .pier-th.date{
    text-align: center;
  }
</style>
<style>
  .PierPagination{
    background: #e0e0e0;
  }

  .PierPagination li a{
    display: inline-block;
    padding: 0.25rem 0.9rem;
    border: 1px solid transparent;
    border-radius: 50%;
    font-weight: bold;
    outline: none;
  }

  .PierPagination li.active a{
    pointer-events: none;
    background: #9a9c9f;
    color: #fff;
  }

  .PierPagination li:not(:first-child):not(:last-child).disabled a{
    padding: 0.25rem;
    margin: 0;
    border: none;
  }
  
  .PierPagination li:first-child,
  .PierPagination li:last-child{
    margin: 0 1rem;
    flex: 1;
    display: flex;
  }
  
  .PierPagination li:first-child a,
  .PierPagination li:last-child a{
    border-color: #555;
  }
  
  .PierPagination li:last-child a{
    margin-left: auto;
  }
</style>
<template>
  <div>
    <table class="pure-table pure-table-striped" 
      style="border-top: none !important; width:100%; min-width: 500px;">
      <thead>
        <tr>
          <template v-for="(field, index) in model.fields">
            <th class="capitalize" :class="['pier-th', field.type, field.meta ? field.meta.type : '']" 
              v-if="field.type !== 'password'"
              :key="index">
              {{ field.label.replace(/_/g, ' ') }}
            </th>
          </template>
          <th style="width: 120px" class="text-center">
            Actions
          </th>
        </tr>
      </thead>
      <tbody>
        <template v-if="records && records.length && !fetchingRecorsds && !populatingRecords">
          <TableRow v-for="record in records"
            :key="record._id"
            :fields="model.fields"
            :data="record"
          />
        </template>
        <tr v-else>
          <td :colspan="model.fields.length + 1"
            class="text-center">

            <Loader v-if="!records || fetchingRecorsds || populatingRecords" :size="90" />

            <div class="py-3" v-else>
              <p class="block mb-5 text-lg">
                This model doesn't contain any records yet.
              </p>

              <button class="mb-2 mr-2 rounded-btn border border-blue-800 capitalize text-blue-800 text-base mt-0 ml-3"
                @click="populateRecords(30)">
                Populate <span class="font-bold">30</span> sample records
              </button>

              <button class="mb-2 rounded-btn border border-blue-800 capitalize text-blue-800 text-base mt-0 ml-3"
                @click="populateRecords(50)">
                Populate <span class="font-bold">50</span> sample records
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <paginate v-if="records && records.length && !populatingRecords && !fetchingRecorsds && recordsPagination"
      :value="recordsPagination.current_page"
      :page-count="recordsPagination.last_page"
      :click-handler="fetchRecords"
      :prev-text="'Prev'"
      :next-text="'Next'"
      container-class="PierPagination py-2 flex items-center" 
    />
  </div>
</template>

<script>
  import Paginate from 'vuejs-paginate';
  import { populateModel } from "../../../API";
  import TableRow from "./TableRow";
  import { mapState } from 'vuex';

  export default {
    name: 'PierCMSListTable',
    props: {
      model: {
        type: Object,
        default: function(){
          return {}
        }
      }
    },
    mounted(){
      this.fetchRecords();
    },
    computed: {
      ...mapState(['fetchingRecorsds', 'records', 'recordsPagination', 'populatingRecords'])
    },
    watch: {
      model: function(newValue){
        if(newValue)
          this.fetchRecords();
      },
    },
    methods: {
      fetchRecords(page = 1){
        if(!this.model.fields)
          return;
        
        this.$store.dispatch('fetchRecords', page);
      },
      populateRecords(itemCount){
        this.$store.dispatch('populateRecords', itemCount);
      },
    },
    components: {
      TableRow,
      Paginate
    }
  }
</script>