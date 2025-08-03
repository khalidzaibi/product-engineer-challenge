import { defineStore } from 'pinia'
import { fetchInterceptor } from '@/utils/fetchInterceptor'

export const useDashboardStore = defineStore('dashboard', {
  state: () => ({
    dashboardData: null,
    loading: false,
    dashboardLoading: false,
    dashboardDataRange: null,
    error: null
  }),
  
  actions: {
    async getDashboard() {
      this.loading = true
      try {
        this.dashboardData = await fetchInterceptor.get('/dashboard')
      } catch (error) {
        this.error = error.message
        console.error('Fetch Dashboard Data Error:', error.message)
      } finally {
        this.loading = false
      }
    },
    async getDashboardRange(data) {
      this.dashboardLoading = true
      try {
        this.dashboardDataRange = await fetchInterceptor.post('/dashboard/range', data)
      } catch (error) {
        this.error = error.message
      } finally {
        this.dashboardLoading = false
      }
    }
  },
})
