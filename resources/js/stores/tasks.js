import { defineStore } from 'pinia'
import { fetchInterceptor } from '@/utils/fetchInterceptor'
import { ElNotification, ElMessageBox } from 'element-plus'

export const useTasksStore = defineStore('tasks', {
  state: () => ({
    tableLoading: false,
    tasks: [],
    loading: false,
    error: null,

    drawer: false,
    singleTask: null,
    filters: {
      title: '',
      assigned_to: '',
      is_completed: '',
      dateRange: []
    }
  }),
  
  actions: {
    
    async getAllTasks(filters = {}) {
      this.tableLoading = true
      try {
        const response = await fetchInterceptor.get('/tasks', filters)
        this.tasks = response
      } catch (error) {
        this.error = error.message
        ElNotification.error({
          title: 'Error',
          message: this.error,
          duration: 5000
        })
      } finally {
        this.tableLoading = false
        this.singleTask = null
      }
    },
    async createTask(data) {
      this.loading = true
      try {
        let response
        if (this.singleTask) {
          data.id = this.singleTask.id
           response = await fetchInterceptor.put('/tasks/'+data.id, data)
        } else {         
           response = await fetchInterceptor.post('/tasks', data)
        }
       
        this.getAllTasks() // Refresh the user list
        this.drawer = false
        ElNotification.success({
          title: 'Success',
          message: response.message || 'Task created successfully',
          duration: 5000
        })
      } catch (error) {
        this.error = error.message
        ElNotification.error({
          title: 'Error',
          message: this.error,
          duration: 5000
        })
      } finally {
        this.loading = false
      }
    },
    async deleteTask(id) {
      ElMessageBox.confirm(
        'Are you sure you want to delete this task?',
        'Warning',
        {
          confirmButtonText: 'Delete',
          cancelButtonText: 'Cancel',
          type: 'warning'
        }
      ).then(async () => {
        this.deleteTaskConfirmed(id)
      }).catch(() => {
        ElNotification.info({
          title: 'Cancelled',
          message: 'Task deletion cancelled',
          duration: 5000
        })
      })
    },
    async deleteTaskConfirmed(id) {
      this.loading = true
      try {
        await fetchInterceptor.delete(`/tasks/${id}`)
        this.getAllTasks() // Refresh the task list
        ElNotification.success({
          title: 'Success',
          message: 'Task deleted successfully',
          duration: 5000
        })
      } catch (error) {
        this.error = error.message
        ElNotification.error({
          title: 'Error',
          message: this.error,
          duration: 5000
        })
      } finally {
        this.loading = false
      }
    },
    async updateTaskStatus(taskId, status) {
      this.loading = true
      try {
        await fetchInterceptor.put(`/tasks/${taskId}/status`, { is_completed: status })
        // this.getAllTasks() // Refresh the task list
        ElNotification.success({
          title: 'Success',
          message: 'Task status updated successfully',
          duration: 5000
        })
      } catch (error) {
        this.error = error.message
        ElNotification.error({
          title: 'Error',
          message: this.error,
          duration: 5000
        })
      } finally {
        this.loading = false
      }
    }
  },
})
