<template>
  <el-container style="height: 100vh">
    <el-aside width="250px" style="background-color:#545c64">
        <div class="logo" style="text-align: center; padding: 17px; font-size: 24px; color: #fff;">
            Product Engineer
        </div>
      <el-scrollbar>
        <el-menu active-text-color="#ffd04b"
        background-color="#545c64" class="el-menu-vertical-demo" 
        default-active="dashboard" text-color="#fff" >
        
        <el-menu-item index="/dashboard" @click="() => router.push({ name: 'Dashboard' })">
          <el-icon><house /></el-icon>
          <span>Dashboard</span>
        </el-menu-item>

        <el-menu-item index="/users" @click="() => router.push({ name: 'Users' })">
          <el-icon><User /></el-icon>
          <span>Users</span>
        </el-menu-item>
        <el-menu-item index="/teams" @click="() => router.push({ name: 'Teams' })">
          <el-icon><UserFilled /></el-icon>
          <span>Teams</span>
        </el-menu-item>

        <el-menu-item index="/tasks" @click="() => router.push({ name: 'Tasks' })">
          <el-icon><Timer /></el-icon>
          <span>Tasks</span>
        </el-menu-item>
         
<!-- 
        <el-sub-menu index="1">
          <template #title>
            <el-icon><location /></el-icon>
            <span>Navigator One</span>
          </template>
          <el-menu-item-group title="Group One">
            <el-menu-item index="1-1">item one</el-menu-item>
            <el-menu-item index="1-2">item two</el-menu-item>
          </el-menu-item-group>
          <el-menu-item-group title="Group Two">
            <el-menu-item index="1-3">item three</el-menu-item>
          </el-menu-item-group>
          <el-sub-menu index="1-4">
            <template #title>item four</template>
            <el-menu-item index="1-4-1">item one</el-menu-item>
          </el-sub-menu>
        </el-sub-menu> -->
      </el-menu>
      </el-scrollbar>
    </el-aside>

    <el-container>
      <el-header style="text-align: right; font-size: 12px; padding: 0 20px; background-color: #545c64; color: #fff;">
        <div class="toolbar">
          <el-dropdown>
            <el-icon style="margin-right: 8px; margin-top: 18px">
            <div>
                <el-avatar :icon="UserFilled" />
            </div>
            </el-icon>
            <template #dropdown>
              <el-dropdown-menu>
                <el-dropdown-item @click="logout">Logout</el-dropdown-item>
              </el-dropdown-menu>
            </template>
          </el-dropdown> 
        </div>
      </el-header>

      <el-main>
        <el-card>
          <el-breadcrumb separator="/">
            <el-breadcrumb-item v-for="(crumb, index) in breadcrumbs" :key="index">
              {{ crumb }}
            </el-breadcrumb-item>
          </el-breadcrumb>
          
          <router-view />
        </el-card>
      </el-main>
    </el-container>
  </el-container>
</template>

<script setup>
import { computed } from 'vue'
import { UserFilled } from '@element-plus/icons-vue'
import { User, House, SwitchFilled, Timer, Location, Document } from '@element-plus/icons-vue'
import { useRouter, useRoute } from "vue-router";
const router = useRouter();
const route = useRoute();
import { useAuthStore } from '../stores/auth'
const authStor = useAuthStore()

const breadcrumbs = computed(() => {
  return route.meta.breadcrumb || []
})
const logout = async () => {
  await authStor.logout()
  router.push({ name: 'Login' })
}
</script>

<style scoped>
  .layout-container-demo .el-header {
    position: relative;
    background-color: var(--el-color-primary-light-7);
    color: var(--el-text-color-primary);
  }
  .layout-container-demo .el-aside {
    color: var(--el-text-color-primary);
    background: var(--el-color-primary-light-8);
  }
  .layout-container-demo .el-menu {
    border-right: none;
  }
  .layout-container-demo .el-main {
    padding: 0;
  }
  .layout-container-demo .toolbar {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    right: 20px;
  }
</style>
