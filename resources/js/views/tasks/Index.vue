<template>

  <Filters />
  <el-divider class="my-1"></el-divider>
  <el-table 
        :data="taskStore.tasks" 
        stripe
        style="width: 100%"
        v-loading="taskStore.tableLoading"
        empty-text="No Tasks found"
        row-key="id">
         <el-table-column type="selection" width="55" />
        <el-table-column label="ID" width="50" prop="id"/>
        <el-table-column label="Title" show-overflow-tooltip>
          <template #default="scope">
            {{ scope.row.title }}
          </template>
        </el-table-column>
        <el-table-column label="Assigned To" show-overflow-tooltip>
          <template #default="scope">
            {{ scope.row.assigned_to ? scope.row.assigned_to.name : 'Unassigned' }}
          </template>
        </el-table-column>
        <el-table-column label="Start Date" prop="start_date">
          <template #default="scope">
            {{ scope.row.start_date }}
          </template>
        </el-table-column>
        <el-table-column label="End Date" prop="end_date">
          <template #default="scope">
            {{ scope.row.end_date }}
          </template>
        </el-table-column>
        <el-table-column label="Status">
          <template #default="scope">
            <el-tag v-if="scope.row.is_completed" :type="scope.row.is_completed ? 'success' : 'danger'" effect="dark">
              {{ scope.row.is_completed ? 'Completed' : 'Pending' }}
            </el-tag>
             <el-select v-else v-model="scope.row.is_completed" @change="(val) => updateStatus(scope.row.id, val)"  >
                <el-option label="Pending" :value="0" />
                <el-option label="Completed" :value="1" />
              </el-select>
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
            <el-button size="small" type="primary" @click="() => editTask(scope.row)">
              <el-icon><Edit /></el-icon>
            </el-button>
            <el-button size="small" type="danger" @click="() => taskStore.deleteTask(scope.row.id)">
              <el-icon><Delete /></el-icon>
            </el-button>
            </el-button-group>
          </template>
        </el-table-column>
  </el-table>

  <Create v-if="taskStore.drawer" />
</template>

<script setup>
import { onMounted } from 'vue'
import { useTasksStore } from '../../stores/tasks'
import { useUsersStore } from '../../stores/users'
import Create from './Create.vue'
import { Edit, Delete } from '@element-plus/icons-vue'
import Filters from './Filters.vue'
import { ElMessage, ElMessageBox } from 'element-plus'

const taskStore = useTasksStore()
const userStore = useUsersStore()


onMounted(async () => {
  // await tasks()
  await userStore.getAllUsers()
})

// const tasks = async () => {
//   await taskStore.getAllTasks(taskStore.filters)
// }
const editTask = (task) => {
  taskStore.singleTask = task
  taskStore.drawer = true
}
const updateStatus = async (taskId, status) => {
  ElMessageBox.confirm(
        'Are you sure you want to update this status?',
        'Warning',
        {
          confirmButtonText: 'Update',
          cancelButtonText: 'Cancel',
          type: 'warning'
        }
      ).then(async () => {
        await taskStore.updateTaskStatus(taskId, status)
      }).catch(() => {
        ElMessage({
          type: 'info',
          message: 'Status update cancelled'
        })
        const index = taskStore.tasks.findIndex(t => t.id === taskId)
        if (index !== -1) taskStore.tasks[index].is_completed = status === 1 ? 0 : 1

      })
}
</script>
