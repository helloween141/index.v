<template>
  <div>
    <div class="mb-5">
      <div class="mb-5">
        <h1 class="text-2xl dark:text-white">Текущие обращения</h1>
      </div>

      <div class="w-full border-t dark:border-gray-700 mb-5"></div>

      <div class="flex items-center mb-5">
        <label class="mr-5 dark:text-white">Исполнитель:</label>
        <select
            @change="changeExecutor"
            v-model="currentExecutorId"
            class="block py-2.5 px-0 w-64 text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
          <option v-for="(executor, key) in executors"
                  :key="key"
                  :value="executor.id"
                  :selected="executor.id === currentExecutorId"
          >
            {{ executor.name }}
          </option>
        </select>
      </div>
    </div>

    <div v-if="!loading" class="relative overflow-x-auto">

      <div class="flex justify-between flex-wrap mb-5">
        <ul class="flex items-center flex-wrap w-full md:w-auto">
          <li class="pr-4 mt-3 md:mt-0 text-sm hover:underline">
            <a href="#" class="dark:text-white" @click="applyTypeFilter('')">Все обращения ({{ tasks.length }})</a>
          </li>
          <li v-for="(count, name) in typeFilters" class="pr-4 mt-3 md:mt-0 text-sm hover:underline">
            <a href="#" class="dark:text-white" @click="applyTypeFilter(name)">{{ taskTypes[name] }} ({{ count }})</a>
          </li>
        </ul>

        <div class="relative w-full md:w-1/3 md:mt-0 mt-3">
          <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
            <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20"
                 xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                    clip-rule="evenodd"></path>
            </svg>
          </div>
          <input type="text"
                 id="email-address-icon"
                 class="block w-full md:w-full p-2 pl-10 text-gray-900 bg-gray-50 rounded-lg border border-gray-300 sm:text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                 placeholder="Поиск по обращениям..." v-model="searchString" @input="applySearchFilter"/>
        </div>
      </div>

      <div class="overflow-y-auto rounded shadow-md mb-10">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" class="px-6 py-3">Номер</th>
            <th scope="col" class="px-6 py-3">Дата</th>
            <th scope="col" class="px-6 py-3">Клиент/персона</th>
            <th scope="col" class="px-6 py-3">Тип</th>
            <th scope="col" class="px-6 py-3">Суть обращения</th>
            <th scope="col" class="px-6 py-3">Статус</th>
            <th scope="col" class="px-6 py-3">Приоритет</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="task in currentTasks"
              class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50">
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
              <RouterLink :to="{ name: 'tasks', params: { id: task.id }}">
                {{task.id}}
              </RouterLink>
            </th>
            <td class="px-6 py-4">{{ formatDate(task.created_at) }}</td>
            <td class="px-6 py-4">
              <a href="#" class="text-blue-600 dark:text-blue-500 hover:underline">{{ task.client_id.name }}</a>
            </td>
            <td class="px-6 py-4">
              {{ taskTypes[task.type] }}
            </td>
            <td class="px-6 py-4">
              {{ task.short_description }}
            </td>
            <td class="px-6 py-4">
              {{ taskStatuses[task.status] }}
            </td>
            <td class="px-6 py-4">
              <span v-if="task.priority"
                    :class="{'text-red-500': task.priority === 'high',
                            'text-yellow-500': task.priority === 'middle',
                            'text-green-500': task.priority === 'low'}"
              >
                {{taskPriorities[task.priority]}}
              </span>
              <span v-else-if="task.deadline_at" class="text-green-500">Выполнить до: {{ task.deadline_at }}</span>
            </td>
          </tr>
          </tbody>
        </table>
      </div>

    </div>
    <div v-else-if="loading">
      <Spinner />
    </div>
    <div v-else>
      <div class="mb-10">
        <span class="dark:text-white">Обращения не найдены!</span>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from 'vue'
import {taskStatuses, taskTypes, taskPriorities} from '@/data/constants'
import axios from "axios";
import {useUserStore} from "@/stores/user";
import Spinner from "@/components/ui/Spinner.vue";
import moment from "moment";

export default defineComponent({
  name: 'CurrentTasks',
  components: {Spinner},
  data() {
    return {
      tasks: [],
      currentTasks: [],
      executors: [],
      taskTypes,
      taskStatuses,
      taskPriorities,
      searchString: '',
      currentExecutorId: 0,
      loading: false
    }
  },
  async mounted() {
    this.currentExecutorId = useUserStore().user.id
    await this.fetchData()
  },
  computed: {
    typeFilters() {
      return this.tasks.reduce((prev: any, cur: any) => (prev[cur.type] = prev[cur.type] + 1 || 1, prev), {})
    }
  },
  methods: {
    async fetchData() {
      try {
        this.loading = true
        const resultExecutors = await axios.get('/api/users/executors/')
        this.executors = resultExecutors.data?.data || []

        const resultTasks = await axios.get('/api/dashboard/active-tasks/', {
          params: {
            'user_id': this.currentExecutorId
          }
        })
        this.tasks = this.currentTasks = resultTasks.data?.data || []
        console.log(this.tasks)
        this.loading = false
      } catch (error) {
        console.error(error)
      }
    },
    applySearchFilter() {
      const searchStr: string = (this.searchString).trim()
      if (searchStr) {
        this.currentTasks = this.currentTasks.filter((task: any) => (
            task.short_description.includes(searchStr) || task.client_id.name.includes(searchStr) || (task.id.toString()).includes(searchStr)
        ))
      } else {
        this.currentTasks = this.tasks
      }
    },
    applyTypeFilter(type: string) {
      this.searchString = ''
      if (type) {
        this.currentTasks = this.tasks.filter((task: any) => (task.type === type))
      } else {
        this.currentTasks = this.tasks
      }
    },
    formatDate(value) {
      return moment(value).format('DD.MM.YYYY HH:mm')
    },
    changeExecutor() {
      this.fetchData()
    }
  }
})
</script>