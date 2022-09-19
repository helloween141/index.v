<template>
  <div class="text-sm font-medium text-center text-gray-500 border-t border-b border-gray-200 dark:text-gray-400 dark:border-gray-700 mb-5">
    <ul class="flex flex-wrap -mb-px">
      <li class="mr-2">
        <a href="#" class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">Profile</a>
      </li>
      <li class="mr-2">
        <a href="#" class="inline-block p-4 text-blue-600 rounded-t-lg border-b-2 border-blue-600 active dark:text-blue-500 dark:border-blue-500" aria-current="page">Dashboard</a>
      </li>
      <li class="mr-2">
        <a href="#" class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">Settings</a>
      </li>
      <li class="mr-2">
        <a href="#" class="inline-block p-4 rounded-t-lg border-b-2 border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300">Contacts</a>
      </li>
      <li>
        <a class="inline-block p-4 text-gray-400 rounded-t-lg cursor-not-allowed dark:text-gray-500">Disabled</a>
      </li>
    </ul>
  </div>
</template>

<script lang="ts">
import {defineComponent, ref} from "vue";

export default defineComponent({
  name: 'FormTabPanel',
  props: {
    model: Object,
    isActive: Boolean,
    isModal: Boolean
  },
  emits: [],
  setup(props, {emit}) {

  }
})
</script>
