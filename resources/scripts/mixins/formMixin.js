import {useToast} from "vue-toastification";
import axios from "axios";

export const formMixin = {
    data() {
        return {
            loading: false,
            formInterface: {},
            formValues: {},
            toast: useToast(),
            recordId: 0,
            title: this.$route.meta.singleTitle,
            moduleUrl: this.$route.meta.moduleUrl,
            moduleName: this.$route.name
        }
    },
    async mounted() {
        this.$watch(
            () => this.$route.params,
            async () => {
                this.recordId = this.$route.params.id
                await this.fetchFormData()
            },
            {
                immediate: true
            }
        )
    },
    methods: {
        async fetchFormData() {
            try {
                this.formValues = {}
                this.loading = true;

                const resultInterface = await axios.get(`/api/core/${this.moduleUrl}/interface`)
                this.formInterface = resultInterface.data
                console.log(this.formInterface)

                if (this.recordId) {
                    const resultData = await axios.get(`/api/core/${this.moduleUrl}/${this.recordId}`)
                    this.formValues = resultData.data.data[0]
                    console.log(this.formValues)
                }

                this.title = (this.recordId ? 'Редактировать' : 'Создать') + ' ' + this.formInterface.accusative_detail_title

                this.loading = false;
            } catch (error) {
                console.error(error)
            }
        },
        async saveFormData(data) {
            try {
                const response = await axios.post(`/api/core/${this.moduleUrl}/save`, data)
                const id = response.data?.id || 0
                if (id) {
                    this.toast.success("Данные сохранены!", {
                        timeout: 3000
                    });

                    await this.$router.push({ name: this.moduleName, params: { id } })
                } else {
                    this.toast.error("Ошибка сохранения данных!", {
                        timeout: 3000
                    });
                }
            } catch (error) {
                console.error(error)
            }
        },
    }
}