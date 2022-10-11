import request from '@/utils/axiosReq'

export function getList() {
  return request({
    url: '/Article/get/',
    method: 'post',
    bfLoading: false,
    isParams: false,
    isAlertErrorMsg: false
  })
}

export function add(data){
  return request({
    url: '/Article/add/',
    method: 'post',
    data,
  })
}

export function edit(data){
  return request({
    url: '/Article/edit/',
    method: 'post',
    data,
  })
}

export function del(data){
  return request({
    url: '/Article/del/',
    method: 'post',
    data,
  })
}

export function getDetail(id){
  return request({
    url: '/Article/getOne/'+id,
    method: 'get'
  })
}
