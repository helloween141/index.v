<template>
  <div>
    <div class="mb-5">
      <h1 class="text-2xl dark:text-white">Работы по сотрудникам</h1>
    </div>

    <div class="w-full border-t dark:border-gray-700 mb-5"></div>
    <div>
      <div class="mb-5">
        <div class="flex-col flex-wrap mb-5 justify-between">
          <div class="flex mb-5">
            <div class="w-32 mr-5">
              <select
                  v-model="monthFilter"
                  class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                <option v-for="(month, key) in months" :value="key">{{ month }}</option>
              </select>
            </div>
            <div class="w-32 mr-5">
              <select
                  v-model="yearFilter"
                  class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent border-0 border-b-2 border-gray-200 appearance-none dark:text-gray-400 dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-gray-200 peer">
                <option v-for="year in years" :value="year">{{ year }}</option>
              </select>
            </div>
            <div>
              <button
                  @click="applyFilter"
                  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Показать
              </button>
            </div>
          </div>
        </div>
      </div>
      <div v-if="loading">
        <Spinner/>
      </div>
      <div v-else-if="!loading && actualPerformers"
           class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div v-if="actualPerformers.length > 0">
          <div class="flex items-center mb-5">
            <span class="dark:text-white">
              Время (норма за месяц: {{performances.month_norm}} ч., на сегодня: {{ performances.today_norm }} ч.)
            </span>
          </div>
          <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-6 py-3">Исполнитель</th>
              <th scope="col" class="px-6 py-3">Всего в этом месяце</th>
              <th v-for="month in performances.months" scope="col" class="px-6 py-3">
                {{ months[month] }}
              </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="performance in actualPerformers"
                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50">
              <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                {{ performance.name }}
              </th>
              <td class="px-6 py-4">{{ formatTime(performance.current_time) }}</td>
              <td class="px-6 py-4">{{ formatTime(performance.last_time) }}</td>
              <td class="px-6 py-4">{{ formatTime(performance.before_last_time) }}</td>
            </tr>
            </tbody>
          </table>
        </div>
        <div v-else>
          <span class="dark:text-white">Нет данных на текущий месяц!</span>
        </div>
      </div>
    </div>
  </div>

</template>

<script lang="ts">
import {defineComponent} from 'vue'
import {months, years, year, month} from '@/data/constants'
import axios from "axios";
import Spinner from "@/components/ui/Spinner.vue";

export default defineComponent({
  name: "Performance",
  components: {Spinner},
  data() {
    return {
      performances: {},
      months,
      years,
      yearFilter: year,
      monthFilter: month,
      loading: false
    }
  },
  async mounted() {
    await this.fetchData()
  },
  computed: {
    actualPerformers() {
      if (this.performances.executors) {
        return this.performances.executors.filter(executor => executor.current_time > 0)
      }
    }
  },
  methods: {
    async fetchData() {
      try {
        this.loading = true
        const resultPerformances = await axios.get('/api/dashboard/performance/', {
          params: {
            'filter_year': this.yearFilter,
            'filter_month': (this.monthFilter + 1)
          }
        })
        this.performances = resultPerformances.data
        this.loading = false
        console.log(this.performances)
      } catch (error) {
        console.error(error)
      }
    },
    async applyFilter() {
      await this.fetchData();
    },
    formatTime(time) {
      const hours = Math.floor(time / 60);
      const min = time - (hours * 60);
      return `${hours} ч. ${min} мин.`
    }
  }
})
</script>

