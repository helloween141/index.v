import {createApp} from 'vue'
import {createPinia} from 'pinia'
import App from './App.vue'
import Toast from "vue-toastification"
import Spinner from './components/ui/Spinner.vue'
import router from './router'
import 'flowbite'
import vfmPlugin from 'vue-final-modal'
import Datepicker from '@vuepic/vue-datepicker'
import vSelect from 'vue-select'
import { QuillEditor } from '@vueup/vue-quill'

import 'vue-toastification/dist/index.css'
import '@vuepic/vue-datepicker/dist/main.css'
import 'vue-select/dist/vue-select.css'
import '@vueup/vue-quill/dist/vue-quill.snow.css';

const app = createApp(App)
app.use(createPinia())
app.use(Toast, {});
app.use(router)
app.use(vfmPlugin)
app.component('QuillEditor', QuillEditor);
app.component('v-select', vSelect)
app.component('Datepicker', Datepicker)
app.component('Spinner', Spinner)
app.mount('#app')
