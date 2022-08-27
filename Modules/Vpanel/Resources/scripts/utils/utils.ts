export const prepareFormData = (values: object) => {
    const data = new FormData()
    Object.keys(values).forEach(key => {
        let item = values[key]
        if (item) {
            if (typeof item === 'object' && item.id) {
                data.append(key, item.id)
            } else {
                data.append(key, item)
            }
        }
    })
    return data
}

export const getRouteParameters = (route) => {
    return {
        moduleName: (route.params.module || '').toString(),
        modelName: (route.params.model || '').toString(),
        recordId: (route.params?.id || '').toString()
    }
}

export const getFieldsForFilter = (fields) => {
    return fields.filter(field => field.inFilter)
}

export const getPlaceholderForSearch = (fields) => {
    return fields.filter(field => field.inSearch).map(field => field.title.toLowerCase()).join(', ')
}