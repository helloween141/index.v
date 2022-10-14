<template>
  <div v-if="values && values.data.length > 0">
    <div class="flex">
      <div v-for="item in values.data">
        <img class="max-w-xs h-auto" :src="`/storage/${item.path}`" />
      </div>
    </div>
    <Pagination
        :pages="values"
        @set-page="setPage"
    />
  </div>
  <div v-else>
    <p class="font-normal text-gray-700 dark:text-gray-400">Записи не найдены!</p>
  </div>
</template>

<script lang="ts">
import {defineComponent, onMounted, ref, watch} from "vue";
import Pagination from "@/components/ui/Pagination.vue";
import {getHeadersForEditorTable, getRowsForEditorTable} from "@/utils/utils";
import Draggable from 'vuedraggable'

export default defineComponent({
  name: 'ImageEditorTable',
  components: {Pagination, Draggable},
  emits: ['select-record', 'set-page', 'change-sort'],
  props: {
    model: Object,
    values: Object
  },
  setup(props, { emit }) {
    const onClick = (recordId: number) => {
      emit('select-record', recordId)
    }

    const setPage = (page: number) => {
      emit('set-page', page)
    }

    return {
      onClick,
      setPage
    }
  },
})
</script>

<style scoped>
</style>
