<template>
    <div class="app-container">
      <!--操作-->
      <div class="mr-3 rowSS">
        <el-button type="primary" @click="dialogVisible = true" :icon="ElementPlusIconsVue.CirclePlusFilled">
          增加
        </el-button>
        <!--增加管理员-->
        <el-dialog title="增加管理員" v-model="dialogVisible">
          <el-form label-width="100px">
            <el-form-item label="管理員帳號" prop="managerId">
              <el-input v-model="form.managerId" placeholder="管理員帳號" />
            </el-form-item>
            <el-form-item label="管理員密碼" prop="managerPassword">
              <el-input v-model="form.managerPassword" placeholder="管理員密碼" type="password" />
            </el-form-item>
            <el-form-item label="管理員姓名" prop="managerName">
              <el-input v-model="form.managerName" placeholder="管理員姓名" />
            </el-form-item>

            <el-button type="info" class="login-btn" size="default" @click="addManager">
              送出
            </el-button>
          </el-form>
        </el-dialog>
        <!--增加管理员-->
      </div>
      <el-table :data="list" style="width: 100%" :default-sort="{ prop: 'lastDateTime', order: 'descending' }">
        <el-table-column prop="managerId" label="ManagerId" />
        <el-table-column prop="managerPassword" label="managerPassword" />
        <el-table-column prop="managerName" label="managerName" />
        <el-table-column prop="level" label="level" />
        <el-table-column prop="updatedAt" label="lastDateTime" sortable />
        <el-table-column fixed="right" label="Operations" width="120">
          <template #default="scope">
            <el-button link type="primary" size="small" @click="handleClick(scope.row)">編輯</el-button>
          </template>
        </el-table-column>
      </el-table>
      <!--編輯管理员-->
      <el-dialog title="編輯管理員" v-model="editDialogVisible">
        <el-form label-width="100px">
          <el-form-item label="管理員帳號" prop="managerId">
            <el-input v-model="editForm.managerId" placeholder="管理員帳號" readonly />
          </el-form-item>
          <el-form-item label="管理員密碼" prop="managerPassword">
            <el-input v-model="editForm.managerPassword" placeholder="管理員密碼" type="password" />
          </el-form-item>
          <el-form-item label="管理員姓名" prop="managerName">
            <el-input v-model="editForm.managerName" placeholder="管理員姓名" />
          </el-form-item>

          <el-button type="info" class="login-btn" size="default" @click="editManager">
            送出
          </el-button>
          <el-button type="danger" class="login-btn" size="default" @click="removeManager(editForm.managerId)">
            刪除
          </el-button>
        </el-form>
      </el-dialog>
      <!--編輯管理员-->
    </div>
  </template>


  <script setup>
  // import settings from '@/settings'
  import { ElMessage } from 'element-plus'
  import * as ElementPlusIconsVue from '@element-plus/icons-vue'
  import { getList, setOnce, RemoveOne,createOne } from '@/api/manager'
  import { onMounted, reactive, ref } from 'vue'

  let { elConfirm } = useElement()
  // 增加管理員 dialogVisible
  const dialogVisible = ref(false)
  const form = reactive({
    managerId: '',
    managerPassword: '',
    managerName: '',
    level: '1',
  })
  // 編輯管理員 dialogVisible
  const editDialogVisible = ref(false)
  const editForm = reactive({
    managerId: '',
    managerPassword: '',
    managerName: '',
    level: '1',
  })



  onMounted(() => {
    setList()
  })


  // 取得清單
  let list = ref([])
  let setList = () => {
    getList({}).then(res => {
      list.value = res.data
    })
  }

  // 點擊詳細資料
  let handleClick = (row) => {
    console.log(row)
    editForm.managerId = row.managerId
    editForm.managerPassword = row.managerPassword
    editForm.managerName = row.managerName
    editDialogVisible.value = true
  }

  // 增加管理員
  let addManager = () => {
    createOne(form).then(res => {
      setList()
      dialogVisible.value = false;
      ElMessage.success('新增成功')
      // 清空表單()
      form.managerId = ''
      form.managerPassword = ''
      form.managerName = ''

    }).catch(err => {
      let dialogVisible = ref(false);
      ElMessage.error(err.message)
    })
  }
  let editManager = () => {
    console.log(editForm)
    setOnce(editForm).then(res => {
      setList()
      editDialogVisible.value = false;
      ElMessage.success('編輯成功')
    }).catch(err => {
      editDialogVisible.value = false;
      ElMessage.error(err.message)
    })
  }
  let removeManager = (managerId) => {
    elConfirm('删除', '您確定要刪除嗎？')
      .then(() => {
        RemoveOne({ managerId: managerId }).then(res => {
          setList()
          editForm.managerId = ''
          editForm.managerPassword = ''
          editForm.managerName = ''
          editForm.level = '1'
          editDialogVisible.value = false;
          ElMessage.success('刪除成功')
        }).catch(err => {
          editDialogVisible.value = false;
          ElMessage.error(err.message)
        })
      })
      .catch(() => {

      })

  }



  </script>
