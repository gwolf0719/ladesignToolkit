import request from '@/utils/axiosReq'

// 管理員登入
export function LoginMangerReq(data) {
  return request({
    url: '/Manager/login/',
    data,
    method: 'post',
    bfLoading: false,
    isParams: false,
    isAlertErrorMsg: false
  })
}

export function getInfoReq() {
  return request({
    url: '/Manager/findOneByToken/',
    method: 'get',
    bfLoading: false,
    isParams: false,
    isAlertErrorMsg: false
  })
}
