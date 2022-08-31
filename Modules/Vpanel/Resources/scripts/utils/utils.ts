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

export const getFieldsForFilter = (fields: any) => {
    if (fields) {
        return fields.filter(field => field.inFilter)
    }
    return []
}

export const getPlaceholderForSearch = (fields: any) => {
    if (fields) {
        return fields.filter(field => field.inSearch).map(field => field.title.toLowerCase()).join(', ')
    }
    return ''
}
