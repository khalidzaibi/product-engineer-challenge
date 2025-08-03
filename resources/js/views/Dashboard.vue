<template>
  <el-row :gutter="16">

    <el-col :span="8">
      <el-skeleton :rows="3" v-if="dashboardStore.loading"/>
      <div v-else class="statistic-card">
        <el-statistic :value="dashboardStore.dashboardData?.totalUsers || 0">
          <template #title>
            <div style="display: inline-flex; align-items: center"> Total Users </div>
          </template>
        </el-statistic>
      </div>
    </el-col>

     <el-col :span="8">
      <el-skeleton :rows="3" v-if="dashboardStore.loading"/>
      <div v-else class="statistic-card">     
        <el-statistic :value="dashboardStore.dashboardData?.totalTeams || 0">
          <template #title>
            <div style="display: inline-flex; align-items: center"> Total Teams </div>
          </template>
        </el-statistic>
      </div>
    </el-col>

     <el-col :span="8">
      <el-skeleton :rows="3" v-if="dashboardStore.loading"/>
      <div v-else class="statistic-card">
        <el-statistic :value="dashboardStore.dashboardData?.totalTasks || 0  ">
          <template #title>
            <div style="display: inline-flex; align-items: center"> Total Tasks </div>
          </template>
        </el-statistic>

        <div class="statistic-footer">
          <div class="footer-item">
            <span>Completed: </span>
            <span class="green">{{ dashboardStore.dashboardData?.completedTasks || 0 }}<el-icon> <CaretTop /> </el-icon> </span>
          </div>
        </div>
        <div class="statistic-footer">
          <div class="footer-item">
            <span>Pending: </span>
            <span class="red">{{ dashboardStore.dashboardData?.pendingTasks || 0 }} <el-icon> <CaretBottom />  </el-icon> </span>
          </div>  
        </div>

      </div>
    </el-col>

  </el-row>

  <el-divider class="my-1"></el-divider>
  <h4>Filter Tasks By Date</h4>
  <el-row :gutter="16" style="margin-top: 20px;">
    <el-col :span="12">
      <el-skeleton :rows="3" v-if="dashboardStore.loading"/>
      <span v-else>
        <el-date-picker
          v-model="dateRange"
          type="daterange"
          range-separator="to"
          start-placeholder="Start Date"
          end-placeholder="End Date"
          value-format="YYYY-MM-DD"
          style="width: 100%;"
          :shortcuts="shortcuts"
          @change="dashboardRangeData(dateRange)"
      />  
      </span>

      <el-row v-if="dashboardStore.dashboardDataRange" :gutter="4" style="margin-top: 10px;">
      
        <el-col :span="8">
          <el-card>
            <el-skeleton :rows="3" v-if="dashboardStore.dashboardLoading"/>
            <div v-else-if="dashboardStore.dashboardDataRange" class="statistic-card">
              <el-statistic :value="dashboardStore.dashboardDataRange?.totalTasks || 0">
                <template #title>
                  <div style="display: inline-flex; align-items: center"> Total </div>
                </template>
              </el-statistic>
            </div>
          </el-card>
        </el-col>

        <el-col :span="8">
          <el-card>
            <el-skeleton :rows="3" v-if="dashboardStore.dashboardLoading"/>
            <div v-else-if="dashboardStore.dashboardDataRange" class="statistic-card">
              <el-statistic :value="dashboardStore.dashboardDataRange?.completedTasks || 0">
                <template #title>
                  <div style="display: inline-flex; align-items: center"> Completed </div>
                </template>
              </el-statistic>
            </div>
          </el-card>
        </el-col>

        <el-col :span="8">
          <el-card>
            <el-skeleton :rows="3" v-if="dashboardStore.dashboardLoading"/>
            <div v-else-if="dashboardStore.dashboardDataRange" class="statistic-card">
              <el-statistic :value="dashboardStore.dashboardDataRange?.pendingTasks || 0">
                <template #title>
                  <div style="display: inline-flex; align-items: center"> Pending </div>
                </template>
              </el-statistic>
            </div>
          </el-card>
        </el-col>
        
      </el-row>
     
    </el-col>
  </el-row>

</template>

<script lang="ts" setup>
import { onMounted, ref } from 'vue'
import { useDashboardStore } from '../stores/dashboard'
import { CaretBottom, CaretTop } from '@element-plus/icons-vue'


const dashboardStore = useDashboardStore()

const dateRange = ref([new Date(), new Date()])
onMounted(async () => {
  dashboardStore.dashboardDataRange = null
  await dashboardStore.getDashboard()
})

const dashboardRangeData = async (range) => {
  if (range && range.length === 2) {
    const formData = {
      start_date: range[0],
      end_date: range[1],
    }
    await dashboardStore.getDashboardRange(formData)
  }
}

const shortcuts = [
  {
    text: 'This week',
    value: () => {
      const end = new Date()
      const start = new Date()
      const day = start.getDay() || 7
      start.setDate(start.getDate() - day)
      return [start, end]
    },
  },
  {
    text: 'Last week',
    value: () => {
      const end = new Date()
      const start = new Date()
      start.setTime(start.getTime() - 3600 * 1000 * 24 * 7)
      return [start, end]
    },
  },
  {
    text: 'Last month',
    value: () => {
      const end = new Date()
      const start = new Date()
      start.setTime(start.getTime() - 3600 * 1000 * 24 * 30)
      return [start, end]
    },
  },
  {
    text: 'Last 3 months',
    value: () => {
      const end = new Date()
      const start = new Date()
      start.setTime(start.getTime() - 3600 * 1000 * 24 * 90)
      return [start, end]
    },
  },
]
</script>

<style scoped>
:global(h2#card-usage ~ .example .example-showcase) {
  background-color: var(--el-fill-color) !important;
}

.el-statistic {
  --el-statistic-content-font-size: 28px;
}

.statistic-card {
  height: 100%;
  padding: 20px;
  border-radius: 4px;
  background-color: var(--el-bg-color-overlay);
}

.statistic-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  font-size: 12px;
  color: var(--el-text-color-regular);
  margin-top: 16px;
}

.statistic-footer .footer-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.statistic-footer .footer-item span:last-child {
  display: inline-flex;
  align-items: center;
  margin-left: 4px;
}

.green {
  color: var(--el-color-success);
}
.red {
  color: var(--el-color-error);
}
</style>
