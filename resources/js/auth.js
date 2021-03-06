import bearer from '@websanova/vue-auth/drivers/auth/bearer'
import axios from '@websanova/vue-auth/drivers/http/axios.1.x'
import router from '@websanova/vue-auth/drivers/router/vue-router.2.x'
// Auth base configuration some of this options
// can be override in method calls
const config = {
  auth: bearer,
  http: axios,
  router: router,
  tokenDefaultName: 'laravel-jwt-authentication',
  tokenStore: ['localStorage'],
  rolesVar: 'role',
  registerData: {url: 'api/auth/register', method: 'POST', redirect: '/login'},
  loginData: {url: 'api/auth/login', method: 'POST', redirect: '', fetchUser: true},
  loginAdminData: {url: 'api/auth/admin_login', method: 'POST', redirect: '', fetchUser: true},
  logoutData: {url: 'api/auth/logout', method: 'POST', redirect: '/login', makeRequest: true},
  logoutAdminData: {url: 'api/auth/logout', method: 'POST', redirect: '/admin_login', makeRequest: true},
  fetchData: {url: 'api/auth/user', method: 'GET', enabled: true},
  refreshData: {url: 'api/auth/refresh', method: 'GET', enabled: false, interval:60}
}

export default config