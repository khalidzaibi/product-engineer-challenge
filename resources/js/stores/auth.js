import { defineStore } from 'pinia'
import { fetchInterceptor } from '@/utils/fetchInterceptor'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    token: localStorage.getItem('token') || null,
    user: JSON.parse(localStorage.getItem('user')) || null,
    loading: false,
    error: null
  }),
  getters: {
    isAuthenticated: (state) => !!state.token
  },
  actions: {
    async logout() {
      try {
        await fetchInterceptor.post('/logout')
      } catch (error) {
        console.error('Logout Error:', error.message)
      } finally {
        this.token = null
        this.user = null
        localStorage.removeItem('token')
        localStorage.removeItem('user')
      }
    }
  },
})
