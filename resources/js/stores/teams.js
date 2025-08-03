import { defineStore } from 'pinia'
import { fetchInterceptor } from '@/utils/fetchInterceptor'
import { ElNotification, ElMessageBox } from 'element-plus'

export const useTeamsStore = defineStore('teams', {
  state: () => ({
    tableLoading: false,
    teams: [],
    loading: false,
    error: null,

    drawer: false,
    singleTeam: null,
    filters: {
      name: ''
    }
  }),
  
  actions: {
    
    async getAllTeams(filters = {}) {
      this.tableLoading = true
      try {
        const response = await fetchInterceptor.get('/teams', filters)
        this.teams = response
      } catch (error) {
        this.error = error.message
        ElNotification.error({
          title: 'Error',
          message: this.error,
          duration: 5000
        })
      } finally {
        this.tableLoading = false
        this.singleTeam = null
      }
    },
    async createTeam(data) {
      this.loading = true
      try {
        let response
        if (this.singleTeam) {
          data.id = this.singleTeam.id
           response = await fetchInterceptor.put('/teams/'+data.id, data)
        } else {         
           response = await fetchInterceptor.post('/teams', data)
        }
       
        this.getAllTeams() // Refresh the user list
        this.drawer = false
        ElNotification.success({
          title: 'Success',
          message: response.message || 'Team created successfully',
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
    async deleteTeam(id) {
      ElMessageBox.confirm(
        'Are you sure you want to delete this team?',
        'Warning',
        {
          confirmButtonText: 'Delete',
          cancelButtonText: 'Cancel',
          type: 'warning'
        }
      ).then(async () => {
        this.deleteTeamConfirmed(id)
      }).catch(() => {
        ElNotification.info({
          title: 'Cancelled',
          message: 'Team deletion cancelled',
          duration: 5000
        })
      })
    },
    async deleteTeamConfirmed(id) {
      this.loading = true
      try {
        await fetchInterceptor.delete(`/teams/${id}`)
        this.getAllTeams() // Refresh the team list
        ElNotification.success({
          title: 'Success',
          message: 'Team deleted successfully',
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
