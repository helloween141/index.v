<template>
  <div class="flex-1 h-full pl-5 pt-5">
    <div v-if="loading">
      <Spinner />
    </div>
    <div v-else>

      <div class="mb-5 justify-between items-center">
        <h1 class="text-2xl dark:text-white">
          {{title}}
        </h1>
      </div>

      <Timer
          v-if="formValues.id"
          @set-timer-value="setTimerValue"
          :task-id="formValues.id"
          :timer-field="timerFieldName"
      />

      <ModuleForm
        :inc-fields="formInterface.fields"
        :inc-values="formValues"
        @save-form-data="saveFormData"
      />

    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent} from 'vue'
import Timer from '@/components/ui/Timer.vue'
import ModuleForm from '@/components/modules/ModuleForm.vue';
import {formMixin} from '@/mixins/formMixin'

export default defineComponent({
  name: 'TaskContent',
  components: {ModuleForm, Timer},
  mixins: [formMixin],
  data() {
    return {
      timerFieldName: 'executor_time'
    }
  },
  methods: {
    setTimerValue(timerField, timerValue) {
      console.log(this.formValues[timerField])
      this.formValues[timerField] = timerValue
    }
  }
})
</script>

<style scoped>

</style>
