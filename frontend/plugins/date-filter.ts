import Vue from 'vue'

const months = [
  'January',
  'February',
  'March',
  'April',
  'May',
  'June',
  'July',
  'August',
  'September',
  'October',
  'November',
  'December'
]

const dateFilter = (value: Date): string => {
  return formatDate(value)
}

function formatDate (inputDate: Date): string {
  const date = new Date(inputDate)
  const day = date.getDate()
  const month = date.getMonth()
  const year = date.getFullYear()
  return `${day} ${months[month]}, ${year}`
}

Vue.filter('date', dateFilter)
