<template>

  <Filters />
  <el-divider class="my-1"></el-divider>
  <el-table 
        :data="teamStore.teams" 
        stripe
        style="width: 100%"
        v-loading="teamStore.tableLoading"
        empty-text="No teams found"
        row-key="id">
         <el-table-column type="selection" width="55" />
        <el-table-column label="ID" width="50" prop="id"/>
        <el-table-column label="Name" show-overflow-tooltip>
          <template #default="scope">
            {{ scope.row.name }}
          </template>
        </el-table-column>
        <el-table-column label="Users" show-overflow-tooltip>
          <template #default="scope">
            
            <el-dropdown>
              <span class="el-dropdown-link">
                <el-tag v-if="scope.row.user_count">{{ scope.row.user_count }}</el-tag>
                <el-icon class="el-icon--right"> <arrow-down /> </el-icon>
              </span>
              <template #dropdown>
                <el-dropdown-menu>
                  <el-dropdown-item v-for="user in scope.row.users" :key="user.id">{{ user.name }}</el-dropdown-item>
                </el-dropdown-menu>
              </template>
            </el-dropdown>
                      
          </template>
        </el-table-column>
        
        <el-table-column label="Created By" prop="created_by">
          <template #default="scope">
            <span>{{ scope.row.created_by.name }}</span>
          </template>
        </el-table-column>
        <el-table-column label="Created At" prop="created_at">
          <template #default="scope">
            {{ scope.row.created_at }}
          </template>
        </el-table-column>
      
        <el-table-column label="Actions" width="150">
          <template #default="scope">
            <el-button-group>
            <el-button size="small" type="primary" @click="() => editTeam(scope.row)">
              <el-icon><Edit /></el-icon>
            </el-button>
            <el-button size="small" type="danger" @click="() => teamStore.deleteTeam(scope.row.id)">
              <el-icon><Delete /></el-icon>
            </el-button>
            </el-button-group>
          </template>
        </el-table-column>
  </el-table>

  <Create v-if="teamStore.drawer" />
</template>

<script setup>
import { onMounted } from 'vue'
import { useTeamsStore } from '../../stores/teams'
import { useUsersStore } from '../../stores/users'
import Create from './Create.vue'
import { Edit, Delete, ArrowDown } from '@element-plus/icons-vue'
import Filters from './Filters.vue'
import { ElMessage, ElMessageBox } from 'element-plus'

const teamStore = useTeamsStore()
const userStore = useUsersStore()


onMounted(async () => {
  await userStore.getAllUsers();
});
const editTeam = (team) => {
  teamStore.singleTeam = team
  teamStore.drawer = true
}
</script>
