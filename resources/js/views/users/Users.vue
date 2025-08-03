<template>

 <div style="text-align: end;">
  <el-button size="small" type="primary" @click="() => createUser()">Create User</el-button>
 </div>

  <el-table :data="userStore.users" 
        stripe
        style="width: 100%"
        v-loading="userStore.tableLoading"
        empty-text="No Users found">
        <el-table-column label="ID" width="50" prop="id"/>
        <el-table-column label="Name" show-overflow-tooltip>
          <template #default="scope">
            {{ scope.row.name }}
          </template>
        </el-table-column>
        <el-table-column label="Email" prop="email" show-overflow-tooltip>
          <template #default="scope">
            {{ scope.row.email }}
          </template>
        </el-table-column>
        <el-table-column label="Role">
          <template #default="scope">
            <el-tag :type="scope.row.is_admin ? 'danger' : 'success'" effect="dark">
              {{ scope.row.is_admin ? 'Admin' : 'User' }}
            </el-tag>
          </template>
        </el-table-column>
        <el-table-column label="Created At" prop="created_at">
          <template #default="scope">
            {{ new Date(scope.row.created_at).toLocaleDateString() }}
          </template>
        </el-table-column>
        <el-table-column label="Updated At" prop="updated_at">
          <template #default="scope">
            {{ new Date(scope.row.updated_at).toLocaleDateString() }}
          </template>
        </el-table-column>
      
        <el-table-column label="Actions" width="150">
          <template #default="scope">
            <el-button-group>
            <el-button size="small" type="primary" @click="() => willAddSoon()">Edit</el-button>
            <el-button size="small" type="danger" @click="() => willAddSoon()">Delete</el-button>
            </el-button-group>
          </template>
        </el-table-column>
  </el-table>

  <Create v-if="userStore.drawer" />
</template>

<script setup>
import { onMounted } from 'vue'
import { useUsersStore } from '../../stores/users'
const userStore = useUsersStore()
import Create from './Create.vue'
import { ElMessage } from 'element-plus'

onMounted(() => {
  users()
})

const users = async () => {
  await userStore.getAllUsers()
}

const createUser = () => {
 userStore.drawer = true
} 

const willAddSoon = () => {
  ElMessage({
    message: 'This feature will be added soon.',
    type: 'info',
    duration: 2000
  });
}

</script>
