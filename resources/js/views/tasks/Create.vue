<template>
  <el-drawer v-model="taskStore.drawer" :title="`${ taskStore.singleTask ? 'Update' : 'Create'} Task`" size="50%">
    
    <el-form :model="form" :rules="rules" ref="taskForm" label-width="80px" :label-position="'top'">

      <el-row :gutter="4">
        <el-col :span="12">
          <el-form-item label="Title" prop="title">
            <el-input v-model="form.title" />
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item label="Assignee" prop="assigned_to">
            <el-select v-model="form.assigned_to" placeholder="Select User" filterable >
              <el-option v-for="user in userStore.users" :key="user.id" :label="user.name" :value="user.id" />
            </el-select>
          </el-form-item>
        </el-col>
      </el-row>
      <el-row :gutter="8">
        <el-col :span="12">
          <el-form-item label="Start Date" prop="start_date">
            <el-date-picker
              v-model="form.start_date"
              type="date"
              placeholder="Start Date"
              value-format="YYYY-MM-DD"
              style="width: 100%;"
            />
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item label="End Date" prop="end_date">
           <el-date-picker
              v-model="form.end_date"
              type="date"
              placeholder="End Date"
              style="width: 100%;"
              value-format="YYYY-MM-DD"
            />
          </el-form-item>
        </el-col>
      </el-row>
      <el-row :gutter="8" v-if="taskStore.singleTask">
        <el-col :span="12">
          <el-form-item label="Status" prop="is_completed">
            <el-select v-model="form.is_completed" placeholder="Select Status">
              <el-option label="Pending" :value="0" />
              <el-option label="Completed" :value="1" />
            </el-select>
          </el-form-item>
        </el-col>
      </el-row>

      <el-row :gutter="8">
        <el-col :span="24">
          <el-form-item label="Description" prop="description">
            <el-input type="textarea" v-model="form.description" />
          </el-form-item>
        </el-col>
      </el-row>
     
      <el-row :gutter="8">
        <el-form-item>
          <el-button :loading="taskStore.loading" type="primary" @click="submitForm">Submit</el-button>
        </el-form-item>
      </el-row>
     
    </el-form>

  </el-drawer>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue'
import { useTasksStore } from '../../stores/tasks'
import { useUsersStore } from '../../stores/users'
import { ta } from 'element-plus/es/locales.mjs'
const taskStore = useTasksStore()
const userStore = useUsersStore()



const form = reactive({
  title: '',
  description: '',
  assigned_to: '',
  start_date: '',
  end_date: ''
})

const rules = {
  title: [{ required: true, message: 'Title is required', trigger: 'blur' }],
  assigned_to: [{ required: true, message: 'Assignee is required', trigger: 'change' }],
  start_date: [{ required: true, message: 'Start date is required', trigger: 'change' }],
  end_date: [
    { required: true, message: 'End date is required', trigger: 'change' },
    {
      validator: (rule, value, callback) => {
        const start = form.start_date
        if (!start || !value) {
          return callback()
        }
        if (new Date(value) < new Date(start)) {
          return callback(new Error('End date must be after start date'))
        }
        return callback()
      },
      trigger: 'change'
    }
  ]
}

const taskForm = ref(null)
const submitForm = () => {     
  taskForm.value.validate(async (valid) => {
    if (valid) {
        await taskStore.createTask(form)
    }
  })
}

onMounted(async () => {
  if (taskStore.singleTask) {
    form.title = taskStore.singleTask.title
    form.description = taskStore.singleTask.description
    form.assigned_to = taskStore.singleTask.assigned_to.id
    form.start_date = taskStore.singleTask.start_date
    form.end_date = taskStore.singleTask.end_date
    form.is_completed = taskStore.singleTask.is_completed
  }
})
</script>
