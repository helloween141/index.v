import moment from 'moment';
import {STORAGE_PATH} from "@/api/config";

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
          let mergeValue = {}

          if (field.type === 'date') {
            mergeValue = {[fName]: formatDate(fValue)}
          } else if (field.type === 'select' && fValue) {
            mergeValue = {[fName]: field.options[fValue]}
          } else if (field.type === 'image' && fValue) {
            mergeValue = {[fName]: {
              'src': fValue.value ? getLink(fValue.value) : '',
              'isImage': true
            }}
          } else if (field.type === 'pointer' && fValue) {
            const identifyKey = Object.keys(fValue)[1] || ''
            mergeValue = {[fName]: fValue[identifyKey]}
          } else {
            mergeValue = {[fName]: (fValue !== null) ? fValue : ''}
          }

          obj = {...obj, ...mergeValue}
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

export const getLink = (value) => {
  return `${STORAGE_PATH}${value}`
}

export const parseModelPath = (path: string) => {
  const prsr = path.split('\\')

  return {
    module: prsr[1],
    model: prsr[3]
  }
}

export const getModelTabs = (childModels: any, masterId: Number) => {
  const tabs = []
  if (childModels) {
    for (const childModel of childModels) {
      const path = parseModelPath(childModel.model)
      if (childModel.tab) {
        tabs.push({
          title: childModel.title,
          module: path.module,
          model: path.model,
          filter: {
            [childModel.relationKey]: masterId
          }
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

export const getAdditionalModels = (childModels: any, masterId: Number) => {
  const result = []
  if (childModels) {
    for (const childModel of childModels) {
      const path = parseModelPath(childModel.model)
      result.push({
        module: path.module,
        model: path.model,
        filter: {
          [childModel.relationKey]: masterId
        }
      })
    }
  }
  return result
}

export const getShowConditions = (fields: any) => {
  let result = {}
  if (fields) {
    fields.forEach(field => {
      const condition = field.showCondition
      if (condition) {
        result = {...result, [field.name]: condition}
      }
    })
  }
  return result
}
