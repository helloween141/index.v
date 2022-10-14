<template>
  <div v-if="rows && rows.length > 0">
    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
      {{rows}}
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead v-if="headers" class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th v-for="header in headers" scope="col" class="py-3 px-6">
              {{ header.title }}
            </th>
          </tr>
        </thead>
        <Draggable
            v-model="rows"
            :disabled="!model.sortable"
            @change="onChangeSort"
            tag="tbody"
            item-key="sort"
        >
            <template #item="{element}">
              <tr
                  @click="onClick(element.id)"
                  class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 cursor-pointer">
                <td v-for="(val, key, index) in element"
                  :key="index"
                  v-show="key !== 'id'"
                  class="py-4 px-6"
                >
                  <img v-if="val.isImage" :src="val.src" />
                  <span v-if="!val.isImage">{{ val }}</span>
                </td>
              </tr>
            </template>
          </Draggable>
      </table>
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
  name: 'DefaultEditorTable',
  components: {Pagination, Draggable},
  emits: ['select-record', 'set-page', 'change-sort'],
  props: {
    model: Object,
    values: Object
  },
  setup(props, { emit }) {
    let headers = ref()
    let rows = ref()

    const init = () => {
      if (props.model) {
        headers.value = getHeadersForEditorTable(props.model.fields)
      }

      if (props.values) {
        rows.value = getRowsForEditorTable(props.model.fields, props.values.data)
      }
    }

    onMounted(() => {
      init()
    })

    watch(() => props.values, () => {
      init()
    }, { deep: true })

    const onClick = (recordId: number) => {
      emit('select-record', recordId)
    }

    const setPage = (page: number) => {
      emit('set-page', page)
    }

    const onChangeSort = () => {
      const sortData = []
      rows.value.forEach((row, key) => {
        sortData.push(row.id)
      })
      emit('change-sort', sortData)
    }

    return {
      headers,
      rows,
      onClick,
      onChangeSort,
      setPage
    }
  },
})
</script>

<style scoped>
</style>
