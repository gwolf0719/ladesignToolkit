<template>
  <div class="app-container">
    <div class="mr-3 rowSS">
      <el-button type="primary" @click="dialogVisibleShow" :icon="ElementPlusIconsVue.CirclePlusFilled">
        增加
      </el-button>
      <!--增加地址簿-->
      <el-dialog title="增加地址簿" v-model="addDialogVisible">
        <el-form label-width="100px">
          <el-form-item label="帳號" prop="account">
            <el-input v-model="form.account" placeholder="帳號" readonly="true" />
          </el-form-item>
          <el-form-item label="省" prop="province">
            <el-input v-model="form.province" placeholder="省" />
          </el-form-item>
          <el-form-item label="市" prop="city">
            <el-input v-model="form.city" placeholder="市" />
          </el-form-item>
          <el-form-item label="區" prop="area">
            <el-input v-model="form.area" placeholder="區" />
          </el-form-item>
          <el-form-item label="地址" prop="address">
            <el-input v-model="form.address" placeholder="地址" />
          </el-form-item>
          <el-form-item label="收件人" prop="target">
            <el-input v-model="form.target" placeholder="收件人" />
          </el-form-item>
          <el-form-item label="電話" prop="phone">
            <el-input v-model="form.phone" placeholder="電話" />
          </el-form-item>

          <el-button type="primary" class="login-btn" size="default" @click="doAdd">
            送出
          </el-button>
        </el-form>
      </el-dialog>
      <!--增加地址簿-->
    </div>

    <!-- 列表 -->
    <el-table :data="addressList">
      <el-table-column prop="province" label="省" />
      <el-table-column prop="city" label="市" />
      <el-table-column prop="area" label="區" />
      <el-table-column prop="address" label="地址" />
      <el-table-column prop="target" label="收件人" />
      <el-table-column prop="phone" label="電話" />
      <el-table-column label="操作">
        <template #default="scope">
          <el-button type="danger" size="mini" @click="handleDelete(scope.row.id)">刪除</el-button>
          <el-button type="primary" size="mini" @click="handleEdit(scope.row)">編輯</el-button>
        </template>
      </el-table-column>
    </el-table>
    <!-- 列表 -->


    <!--修改地址簿-->
    <el-dialog title="修改地址簿" v-model="editDialogVisible">
        <el-form label-width="100px">
          <el-form-item label="帳號" prop="account">
            <el-input v-model="form.account" placeholder="帳號" readonly="true" />
          </el-form-item>
          <el-form-item label="省" prop="province">
            <el-input v-model="form.province" placeholder="省" />
          </el-form-item>
          <el-form-item label="市" prop="city">
            <el-input v-model="form.city" placeholder="市" />
          </el-form-item>
          <el-form-item label="區" prop="area">
            <el-input v-model="form.area" placeholder="區" />
          </el-form-item>
          <el-form-item label="地址" prop="address">
            <el-input v-model="form.address" placeholder="地址" />
          </el-form-item>
          <el-form-item label="收件人" prop="target">
            <el-input v-model="form.target" placeholder="收件人" />
          </el-form-item>
          <el-form-item label="電話" prop="phone">
            <el-input v-model="form.phone" placeholder="電話" />
          </el-form-item>

          <el-button type="primary" class="login-btn" size="default" @click="doEdit">
            送出
          </el-button>
        </el-form>
      </el-dialog>
      <!--修改地址簿-->

  </div>
</template>

<script setup>
import { ElMessage,ElMessageBox } from 'element-plus'
import * as ElementPlusIconsVue from '@element-plus/icons-vue'
// import { getList, setOnce, RemoveOne, createOne } from '@/api/member'
import {getList,addOnce,setOnce,RemoveOne} from '@/api/member_address'
const route = useRoute()



const account = ref(route.params.account)

const form = reactive({
  id: '',
  account: account.value,
  province: '',
  city: '',
  area: '',
  address: '',
  target: '',
  phone: ''
})

const addDialogVisible = ref(false)
const dialogVisibleShow = () => {
  addDialogVisible.value = true
}

const editDialogVisible = ref(false)
// 修改地址簿
const handleEdit = (row) => {
  form.id = row.id
  form.account = row.account
  form.province = row.province
  form.city = row.city
  form.area = row.area
  form.address = row.address
  form.target = row.target
  form.phone = row.phone
  editDialogVisible.value = true
}
// 取得地址簿清單
const addressList = ref([])
const getAddressList = async () => {
  const res = await getList(account.value)
  addressList.value = res.data
  console.log(addressList.value)
}
getAddressList()

// 增加地址簿
const doAdd = async () => {
  const res = await addOnce(form)
  console.log(res)
  if (res.sysCode == "200") {
    ElMessage.success('新增成功')
    addDialogVisible.value = false
    getAddressList()
  } else {
    ElMessage.error(res.sysMsg)
    getAddressList()
  }
}

const doEdit = async () => {
  const res = await setOnce(form)
  console.log(res)
  if (res.sysCode == "200") {
    ElMessage.success('修改成功')
    editDialogVisible.value = false
    getAddressList()
  } else {
    ElMessage.error(res.sysMsg)
    getAddressList()
  }
}

// 刪除地址簿
const handleDelete = async (id) => {
  // 刪除前先詢問確認
  ElMessageBox.confirm('確定刪除嗎?', '提示', {
    confirmButtonText: '確定',
    cancelButtonText: '取消',
    type: 'warning'
  }).then(async () => {
    const res = await RemoveOne(account.value,id)
    if (res.sysCode == "200") {
      ElMessage.success('刪除成功')
      getAddressList()
    } else {
      ElMessage.error(res.sysMsg)
      getAddressList()
    }
  }).catch(() => {
    ElMessage.info('已取消刪除')
  })
}

</script>
