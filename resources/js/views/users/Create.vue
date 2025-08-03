<template>
  <el-drawer v-model="userStore.drawer" title="User" >
    
    <el-form :model="form" :rules="rules" ref="userForm" label-width="80px" :label-position="'top'">
      <el-form-item label="Name" prop="name">
        <el-input v-model="form.name" />
      </el-form-item>
      <el-form-item label="Email" prop="email">
        <el-input v-model="form.email" />
      </el-form-item>
      <el-form-item label="Phone" prop="phone">
        <el-input v-model="form.phone" />
      </el-form-item>
      <el-form-item label="Type" prop="is_admin">
        <el-select v-model="form.is_admin" placeholder="Select Type">
          <el-option label="User" value="0" />
          <el-option label="Admin" value="1" />
        </el-select>
      </el-form-item>
      <el-form-item>
        <el-button :loading="userStore.loading" type="primary" @click="submitForm">Submit</el-button>
      </el-form-item>
    </el-form>

  </el-drawer>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue'
import { useUsersStore } from '../../stores/users'
const userStore = useUsersStore()

const form = reactive({
  name: '',
  email: '',
  phone: '',
  is_admin: '',
})

const rules = {
  name: [{ required: true, message: 'Name is required', trigger: 'blur' }],
  email: [{ required: true, message: 'Email is required', trigger: 'blur' }],
  is_admin: [{ required: true, message: 'Type is required', trigger: 'change' }]
}

const userForm = ref(null)
const submitForm = () => {     
  userForm.value.validate(async (valid) => {
    if (valid) {
        userStore.loading = true
        await userStore.createUser(form)
    }
  })
}

</script>
