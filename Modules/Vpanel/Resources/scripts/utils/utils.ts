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