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

export function RemoveOne(data){
  return request({
    url: '/Manager/deleteOne/',
    data,
    method: 'post',
    bfLoading: false,
    isParams: false,
    isAlertErrorMsg: false
  })
}
export function getList(){
  return request({
    url: '/Manager/findAll/',
    method: 'get',
    bfLoading: false,
    isParams: false,
    isAlertErrorMsg: false
  })
}
export function setOnce(data){
  return request({
    url: '/Manager/setOne/',
    data,
    method: 'post',
    bfLoading: false,
    isParams: false,
    isAlertErrorMsg: false
  })
}

export function createOne(data){
  return request({
    url:'/Manager/createOne/',
    data,
    method: 'post',
    bfLoading: false,
    isParams: false,
    isAlertErrorMsg: false
  })
}
