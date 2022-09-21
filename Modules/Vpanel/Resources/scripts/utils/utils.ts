import moment from 'moment';

export const prepareFormData = (values: object) => {
  const data = new FormData()
  Object.keys(values).forEach(key => {
    let item = values[key]
    if (typeof item === 'object' && item !== null && item.hasOwnProperty('id')) {
      data.append(key, item.id)
    } else {
      data.append(key, item)
    }
  })
  return data
}

export const getRouteParameters = (route) => {
  return {
    moduleName: (route.params.module || ''),
    modelName: (route.params.model || ''),
    recordId: parseInt(route.params?.id || '')
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

export const getHeadersForEditorTable = (fields: any) => {
  const result = []
  if (fields) {
    fields.forEach(field => {
      if (field.inEditor) {
        result.push({name: field['name'], title: field['title']})
      }
    })
  }
  return result
}

export const getRowsForEditorTable = (fields: any, data: any) => {
  const result = []
  if (data) {
    data.forEach(item => {
      let obj = {id: item['id']}
      fields.forEach(field => {
        if (field.inEditor) {
          const fName = field['name']
          const fValue = item[field['name']]

          if (field.type === 'date') {
            obj = {...obj, [fName]: formatDate(fValue)}
          } else if (field.type === 'select' && fValue) {
            obj = {...obj, [fName]: field.options[fValue]}
          } else {
            obj = {...obj, [fName]: (fValue !== null) ? fValue : ''}
          }
        }
      })
      result.push(obj)
    })
  }
  return result
}

export const setDefaultFieldsValues = (fields: any, data: any) => {
  let result = {}

  if (data) {
    if (data.id) {
      result = {...result, ...{id: data.id}}
    }

    fields.forEach(field => {
      result = {...result, ...{[field.name]: data[field.name] ? data[field.name] : field.defaultValue}}
    })
  }

  return result
}

export const formatDate = (date) => {
  return moment(date).format('DD.MM.YYYY')
}

export const getStoragePath = () => {
  return '/storage/'
}

export const parseModelPath = (path: string) => {
  const prsr = path.split('\\')

  return {
    module: prsr[1],
    model: prsr[3]
  }
}

export const getModelTabs = (childModels: any) => {
  const tabs = []
  if (childModels) {
    for (const childModel of childModels) {
      const path = parseModelPath(childModel.model)
      if (childModel.tab) {
        tabs.push({
          title: childModel.title,
          module: path.module,
          model: path.model
        })
      }
    }
    if (tabs.length > 0) {
      tabs.unshift({
        title: 'Основная информация',
        module: '',
        model: '',
        active: true
      })
    }
  }
  return tabs
}


