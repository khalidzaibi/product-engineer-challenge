<template>

 <div style="text-align: end;">
  <el-button type="primary" @click="() => createTask()">Create Task</el-button>
 </div>

  <div style="font-size: 15px; margin-bottom: 4px;">
    Filters
  </div>
  <el-row :gutter="4">
    <el-col :span="4">
      <el-input v-model="taskStore.filters.title" placeholder="Title" />
    </el-col>
    <el-col :span="4">
      <el-select v-model="taskStore.filters.assigned_to" placeholder="Assigned To" filterable >
        <el-option v-for="user in userStore.users" :key="user.id" :label="user.name" :value="user.id" />
      </el-select>
    </el-col>
     <el-col :span="4">
      <el-select v-model="taskStore.filters.is_completed" placeholder="Status" >
        <el-option label="Pending" :value="0" />
        <el-option label="Completed" :value="1" />
      </el-select>
    </el-col>
    <el-col :span="5">
      <el-date-picker
        v-model="taskStore.filters.dateRange"
        type="daterange"
        range-separator="to"
        start-placeholder="Start Date"
        end-placeholder="End Date"
        value-format="YYYY-MM-DD"
        style="width: 100%;"
        :shortcuts="shortcuts"
      />      
    </el-col>
    <el-col :span="4" style="text-align: right;">
      <el-button-group>
        <el-button type="primary" @click="applyFilters">
          <el-icon><Search /></el-icon>
        </el-button>
        <el-button @click="clearFilters">
          <el-icon><Refresh /></el-icon>
        </el-button>
      </el-button-group>
    </el-col>
   
  </el-row>

</template>

<script setup>
import { onMounted } from 'vue'
import { useTasksStore } from '../../stores/tasks'
import { useUsersStore } from '../../stores/users'

import { Search, Refresh } from '@element-plus/icons-vue'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()

const taskStore = useTasksStore()
const userStore = useUsersStore()

const createTask = () => {
 taskStore.singleTask = null
 taskStore.drawer = true
} 

const applyFilters = () => {
  const filters = taskStore.filters
  const query = {}

  if (filters.title) query.title = filters.title
  if (filters.assigned_to) query.assigned_to = filters.assigned_to
  if (filters.is_completed !== '') query.is_completed = filters.is_completed
  if (filters.dateRange?.length === 2) {
    query.start_date = filters.dateRange[0]
    query.end_date = filters.dateRange[1]
  }

  router.push({ query })
  taskStore.getAllTasks(query)
}

const clearFilters = () => {
  taskStore.filters = {
    title: '',
    assigned_to: '',
    is_completed: '',
    dateRange: []
  }

  router.push({ query: {} })
  taskStore.getAllTasks()
}


onMounted(async () => {
 const query = route.query

  taskStore.filters.title = query.title || ''
  taskStore.filters.assigned_to = query.assigned_to || ''
  taskStore.filters.is_completed = query.is_completed || ''
  taskStore.filters.dateRange = (query.start_date && query.end_date)
    ? [query.start_date, query.end_date]
    : []
  taskStore.getAllTasks(query)
})


const shortcuts = [
  {
    text: 'This week',
    value: () => {
      const end = new Date()
      const start = new Date()
      const day = start.getDay() || 7
      start.setDate(start.getDate() - day)
      return [start, end]
    },
  },
  {
    text: 'Last week',
    value: () => {
      const end = new Date()
      const start = new Date()
      start.setTime(start.getTime() - 3600 * 1000 * 24 * 7)
      return [start, end]
    },
  },
  {
    text: 'Last month',
    value: () => {
      const end = new Date()
      const start = new Date()
      start.setTime(start.getTime() - 3600 * 1000 * 24 * 30)
      return [start, end]
    },
  },
  {
    text: 'Last 3 months',
    value: () => {
      const end = new Date()
      const start = new Date()
      start.setTime(start.getTime() - 3600 * 1000 * 24 * 90)
      return [start, end]
    },
  },
]
</script>
