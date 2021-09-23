<style scoped>
.pier-th.image,
.pier-th.phone,
.pier-th.email,
.pier-th.video,
.pier-th.rating,
.pier-th.boolean,
.pier-th.date {
  text-align: center;
}
</style>
<template>
  <div class="h-screen flex-1 flex flex-col relative">
    <header id="mainNav">
      <span id="pageTitle" class="mr-3">
        <!-- {{ modelName }} -->
      </span>

      <span class="flex-1"></span>
    </header>
        
    <div id="mainContent" class="flex items-start justify-center">
      <Loader :size="90" v-if="fetchingRecords || !records || !selectedModel || !selectedModel.fields || !selectedRecord" />
      <div
        v-else
        class="px-8 pt-2 pb-8 border-red border-2 rounded-md"
        style="width:100%; max-width: 800px;"
      >
        <TableRow :fields="selectedModel.fields" :data="selectedRecord" />
      </div>
    </div>
  </div>
</template>

<script>
import TableRow from "./TableRow";
import { mapState, mapGetters } from "vuex";

export default {
  name: "PierCMSDetail",
  props: {
    rowId: {
      type: String,
      required: true
    }
  },
  mounted() {
    if (!this.records && !this.fetchingRecords) {
      this.$store.dispatch("fetchRecords");
      this.$store.subscribe(mutation => {
        if (mutation.type === "SET_RECORDS")
          this.$store.dispatch("setSelectedRecord", this.rowId);
      });
    } else this.$store.dispatch("setSelectedRecord", this.rowId);
  },
  beforeDestroy() {
    this.$store.dispatch("setSelectedRecord", null);
  },
  computed: {
    ...mapState(["records", "fetchingRecords", "selectedModelName"]),
    ...mapGetters(["selectedModel", "selectedRecord"])
  },
  watch: {
    rowId: function(rowId) {
      this.$store.dispatch("setSelectedRecord", rowId);
    },
    selectedModel: function(newValue){
      this.$store.dispatch("fetchRecords");
    }
  },
  components: {
    TableRow
  }
};
</script>