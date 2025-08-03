<template>
  <el-drawer v-model="teamsStore.drawer" :title="`${teamsStore.singleTeam ? 'Update' : 'Create'} Team`" size="50%">
    
    <el-form :model="form" :rules="rules" ref="teamForm" label-width="80px" :label-position="'top'">

      <el-row :gutter="4">
        <el-col :span="12">
          <el-form-item label="Name" prop="name">
            <el-input v-model="form.name" />
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item label="User" prop="user_ids">
            <el-select  v-model="form.user_ids" multiple placeholder="Select Users" filterable collapse-tags :max-collapse-tags="2">
              <el-option v-for="user in userStore.users" :key="user.id" :label="user.name" :value="user.id" />
            </el-select>
          </el-form-item>
        </el-col>
      </el-row>
     
      <el-row :gutter="8">
        <el-form-item>
          <el-button :loading="teamsStore.loading" type="primary" @click="submitForm">Submit</el-button>
        </el-form-item>
      </el-row>
     
    </el-form>

  </el-drawer>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue'
import { useTeamsStore } from '../../stores/teams'
import { useUsersStore } from '../../stores/users'
import { te } from 'element-plus/es/locales.mjs'

const teamsStore = useTeamsStore()
const userStore = useUsersStore()



const form = reactive({
  name: '',
  user_ids: [],
})

const rules = {
  name: [{ required: true, message: 'Name is required', trigger: 'blur' }],
  user_ids: [{ required: true, message: 'User is required', trigger: 'change' }]
}

const teamForm = ref(null)
const submitForm = () => {     
  teamForm.value.validate(async (valid) => {
    if (valid) {
        await teamsStore.createTeam(form)
    }
  })
}

onMounted(async () => {
  if (teamsStore.singleTeam) {
    form.name = teamsStore.singleTeam.name,
    form.user_ids = teamsStore.singleTeam.user_ids || []
  }
})
</script>
