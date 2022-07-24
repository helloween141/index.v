export default [{
    path: '/tasks/:id?/',
    name: 'tasks',
    component: () => import('../views/TasksView.vue'),
    meta: {
        middleware: 'auth',
        title: 'Обращения',
        singleTitle: 'Обращение',
        moduleUrl: 'task',
        breadCrumb(route) {
            const paramId = route.params.id
            let result = [
                {
                    text: 'Обращения',
                    link: '/tasks/'
                },
            ]

            if (paramId) {
                result.push({
                    text: paramId,
                    link: ''
                })
            }
            return result
        }
    }
}]