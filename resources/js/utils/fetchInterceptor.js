import api from './axiosInstance'
import { useAuthStore } from '@/stores/auth'

export const fetchInterceptor = {
  async get(url, params = {}, config = {}) {
    // return requestWithTokenCheck('get', url, null, config)
     return requestWithTokenCheck('get', url, null, {
      ...config,
      params,
    })
  },

  async post(url, data = {}, config = {}) {
    return requestWithTokenCheck('post', url, data, config)
  },

  async put(url, data = {}, config = {}) {
    return requestWithTokenCheck('put', url, data, config)
  },

  async delete(url, config = {}) {
    return requestWithTokenCheck('delete', url, null, config)
  }
}

// Shared request handler with token validation
async function requestWithTokenCheck(method, url, data = null, config = {}) {
  const auth = useAuthStore()

  // Check if token exists before making the request
  if (!auth.token) {
    auth.logout()
    throw new Error('unauthenticated.')
  }

  try {
    const response = await api({
      method,
      url,
      data,
      ...config
    })

    return response.data
  } catch (error) {
    if (error.response?.status === 401) {
      auth.logout()
    }

    const message =
      error.response?.data?.message || error.message || 'API request failed'
    throw new Error(message)
  }
}
