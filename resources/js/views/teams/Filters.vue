<template>

 <div style="text-align: end;">
  <el-button type="primary" @click="() => createTeam()">Create Team</el-button>
 </div>

  <div style="font-size: 15px; margin-bottom: 4px;">
    Filters
  </div>
  <el-row :gutter="4">
    <el-col :span="6">
      <el-input v-model="teamStore.filters.name" placeholder="Name" />
    </el-col>
    
    <el-col :span="4">
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
import { useTeamsStore } from '../../stores/teams'
import { useUsersStore } from '../../stores/users'

import { Search, Refresh } from '@element-plus/icons-vue'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()

const teamStore = useTeamsStore()
const userStore = useUsersStore()

const createTeam = () => {
 teamStore.singleTeam = null
 teamStore.drawer = true
} 

const applyFilters = () => {
  const filters = teamStore.filters
  const query = {}

  if (filters.name) query.name = filters.name
  router.push({ query })
  teamStore.getAllTeams(query)
}

const clearFilters = () => {
  teamStore.filters = {
    name: ''
  }

  router.push({ query: {} })
  teamStore.getAllTeams()
}


onMounted(async () => {
 const query = route.query

  teamStore.filters.name = query.name || ''
  teamStore.getAllTeams(query)
})

</script>
