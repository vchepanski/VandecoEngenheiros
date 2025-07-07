<template>
  <div class="max-w-4xl mx-auto bg-[#1A1D23] p-6 mt-10 rounded-xl shadow-md">
    <div class="flex items-center justify-between mb-6">
      <h2 class="text-2xl font-bold text-[#3B82F6]">User List</h2>
      <RouterLink
        to="/users/create"
        class="px-3 py-1 bg-[#3B82F6] text-white rounded hover:bg-blue-700 transition"
      >
        Create User
      </RouterLink>
    </div>

    <table class="w-full text-sm text-left">
      <thead class="border-b border-[#333] text-[#A0A4AC]">
        <tr>
          <th class="py-2">#</th>
          <th>Name</th>
          <th>Email</th>
          <th class="text-right">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="user in users"
          :key="user.id"
          class="border-b border-[#222] hover:bg-[#0F1115] transition"
        >
          <td class="py-2">{{ user.id }}</td>
          <td>
            <input
              v-model="user.name"
              class="bg-transparent text-white border border-transparent focus:border-[#3B82F6] p-1 rounded"
            />
          </td>
          <td>
            <input
              v-model="user.email"
              class="bg-transparent text-white border border-transparent focus:border-[#3B82F6] p-1 rounded"
            />
          </td>
          <td class="space-x-2 text-right">
            <button
              @click="updateUser(user)"
              class="px-3 py-1 text-sm rounded bg-[#3B82F6] text-white hover:bg-blue-700 transition"
            >
              Save
            </button>
            <button
              @click="deleteUser(user.id)"
              class="px-3 py-1 text-sm text-white transition bg-red-600 rounded hover:bg-red-700"
            >
              Delete
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRouter, RouterLink } from 'vue-router'
import axios from 'axios'

const users = ref([])

const fetchUsers = async () => {
  const response = await axios.get('/api/v1/users')
  users.value = response.data
}

const updateUser = async (user) => {
  try {
    await axios.put(`/api/v1/users/${user.id}`, {
      name: user.name,
      email: user.email,
      password: '', // opcional: deixe vazio para não alterar
    })
    await fetchUsers()
  } catch (error) {
    console.error(error)
  }
}

const deleteUser = async (id) => {
  if (!confirm('Are you sure?')) return

  try {
    await axios.delete(`/api/v1/users/${id}`)
    await fetchUsers()
  } catch (error) {
    console.error(error)
  }
}

onMounted(fetchUsers)
</script>
