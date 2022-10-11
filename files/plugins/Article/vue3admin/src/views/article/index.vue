<template>
  <div class="app-container">
    <!--操作-->
    <div class="mr-3 rowSS">
      <el-button type="primary" :icon="ElementPlusIconsVue.CirclePlusFilled"
        v-on:click="router.push('/articleList/add')">
        增加
      </el-button>

    </div>



    <el-table :data="dataList" style="width: 100%">
      <el-table-column prop="subject" label="標題" />
      <el-table-column prop="cover" label="封面">
        <template #default="scope">
          <img :src="scope.row.cover" style="width: 50px; height: 50px;" />
        </template>
      </el-table-column>
      <el-table-column prop="created_at" label="建立時間" />
      <el-table-column prop="updated_at" label="更新時間" />
      <!-- 工具欄 -->
      <el-table-column fixed="right" label="操作" width="120">
        <template #default="scope">
          <el-button link type="primary" size="small"
            @click="router.push({name:'articleEdit', params:{id:scope.row.id} })">編輯</el-button>
          <el-button link type="danger" size="small" @click="remove(scope.row.id)">刪除</el-button>
        </template>
      </el-table-column>
    </el-table>

  </div>
</template>

<script setup>
import { ElMessage,ElMessageBox } from 'element-plus'

import * as ElementPlusIconsVue from '@element-plus/icons-vue'
import { getList, del } from '@/api/article'
import { onMounted, reactive, ref } from 'vue'
const router = useRouter()

onMounted(() => {
  getArticleList()
})

let dataList = ref([])
let getArticleList = () => {
  getList({}).then(res => {
    console.log(res)
    dataList.value = res.data
  })
}

let remove = (id) => {
  // 先跳出確認刪除的視窗
  ElMessageBox.confirm('確定要刪除嗎？', '提示', {
    confirmButtonText: '確定',
    cancelButtonText: '取消',
    type: 'warning'
  }).then(() => {
    const sendJson = {
      id: id
    }
    del(sendJson).then(res => {
      if (res.sysCode == 200) {
        ElMessage.success('刪除成功')
        getArticleList()
      }
    })
  }).catch(() => {
    ElMessage.info('已取消刪除')
  })



}


</script>
