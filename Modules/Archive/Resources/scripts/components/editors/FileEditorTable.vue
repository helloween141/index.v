<template>
  <div v-if="values && values.data.length > 0">
    <div class="container grid grid-cols-4 gap-fx mx-auto">
      <div v-for="item in values.data"
           class="w-full rounded cursor-pointer text-center"
           @click="onClick(item.id)"
      >
        <div class="border w-full">
          <img :src="getLink(item.path)" :alt="item.name" class="inline"/>
        </div>
        <div>
          <span>{{item.name}}</span>
        </div>
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
import {defineComponent} from "vue";
import Pagination from "../../../../../Vpanel/Resources/scripts/components/ui/Pagination.vue";
import {getLink} from "../../../../../Vpanel/Resources/scripts/utils/utils";
import Draggable from 'vuedraggable'

export default defineComponent({
  name: 'FileEditorTable',
  components: {Pagination, Draggable},
  emits: ['select-record', 'set-page', 'change-sort'],
  props: {
    model: Object,
    values: Object
  },
  setup(props, {emit}) {
    const onClick = (recordId: number) => {
      emit('select-record', recordId)
    }

    const setPage = (page: number) => {
      emit('set-page', page)
    }

    return {
      onClick,
      setPage,
      getLink
    }
  },
})
</script>

<style scoped>
.gap-fx {
  gap: 1rem;
}
</style>
