import { LoginMangerReq, getInfoReq } from '@/api/manager'
import { setToken, removeToken } from '@/utils/auth'
import router, { asyncRoutes } from '@/router'
import { defineStore } from 'pinia'
import { usePermissionStore } from '@/store/permission'
import { useTagsViewStore } from '@/store/tagsView'



const resetRouter = () => {
  const asyncRouterNameArr = asyncRoutes.map((mItem) => mItem.name)
  asyncRouterNameArr.forEach((name) => {
    if (router.hasRoute(name)) {
      router.removeRoute(name)
    }
  })
}

export const useManagerStore = defineStore('manager', {
  state: () => {
    return {
      managerId: '',
      managerPassword: '',
      managerName: '',
      roles: []
    }
  },
  actions: {
    M_username(managerName) {

      this.$patch((state) => {
        state.managerName = managerName
      })
    },
    M_roles(roles) {
      console.log('M_roles', roles)
      this.$patch((state) => {
        state.roles = roles
      })
    },
    login(data) {
      console.log(data)
      return new Promise((resolve, reject) => {
        LoginMangerReq(data)
          .then((res) => {
            console.log("res success")
            console.log(res)
            if (res.sysCode === '200') {
              console.log(res)
              //commit('SET_Token', res.data?.jwtToken)
              setToken(res.data?.authToken)
              console.log(res.data?.authToken)
              resolve(null)
            } else {
              reject(res)
            }
          })
          .catch((error) => {
            console.log("res catch")
            reject(error)
          })
      })
    },
    // get user info
    getInfo() {
      return new Promise((resolve, reject) => {
        getInfoReq()
          .then((response) => {
            console.log('res getInfoReq', response)

            data.roles = ['admin']
            console.log('hello', data)
            const { roles, managerName } = data
            this.M_username(managerName)
            this.M_roles(['admin'])
            resolve(data)
          })
          .catch((error) => {
            console.log('error', error)
            reject(error)
          })
      })
    },
    // user logout
    logout() {
      return new Promise((resolve, reject) => {
        this.resetState()
        resolve(null)
      })
    },
    resetState() {
      return new Promise((resolve) => {
        this.M_username('')
        this.M_roles([])
        removeToken() // must remove  token  first
        resetRouter() // reset the router
        const permissionStore = usePermissionStore()
        permissionStore.M_isGetUserInfo(false)
        const tagsViewStore = useTagsViewStore()
        tagsViewStore.delAllViews()
        resolve(null)
      })
    }
  }
})
