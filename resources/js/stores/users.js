import { defineStore } from 'pinia'
import { fetchInterceptor } from '@/utils/fetchInterceptor'
import { ElNotification } from 'element-plus'

export const useUsersStore = defineStore('users', {
  state: () => ({
    tableLoading: false,
    users: [],
    loading: false,
    error: null,

    drawer: false,
    singleUser: null
  }),
  
  actions: {
    
    async getAllUsers() {
      this.tableLoading = true
      try {
        const response = await fetchInterceptor.get('/users')
        this.users = response
      } catch (error) {
        this.error = error.message
        ElNotification.error({
          title: 'Error',
          message: this.error,
          duration: 5000
        })
      } finally {
        this.tableLoading = false
      }
    },
    async createUser(user) {
      this.loading = true
      try {
        const response = await fetchInterceptor.post('/users', user)
        this.getAllUsers() // Refresh the user list
        this.drawer = false
        ElNotification.success({
          title: 'Success',
          message: 'User created successfully',
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
  },
})
