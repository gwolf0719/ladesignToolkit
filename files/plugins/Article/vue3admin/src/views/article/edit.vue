<template>
  <div class="app-container">
    <el-form :rules="rules" label-width="100px">
      <el-form-item label="ID">
        <el-input v-model="form.id" readonly/>
      </el-form-item>
      <el-form-item label="標題">
        <el-input v-model="form.subject" />
      </el-form-item>
      <el-form-item label="封面" prop="cover">
        <!-- 上傳圖檔 -->
        <el-upload class="avatar-uploader" action="api/Media/uploadFromFile" :show-file-list="false"
          :on-success="handleAvatarSuccess" :before-upload="beforeAvatarUpload" :data="uploadData">

          <img v-if="form.cover" :src="form.cover" class="avatar" />
          <el-icon v-else class="avatar-uploader-icon">
            <Plus />
          </el-icon>
        </el-upload>

      </el-form-item>
      <el-form-item label="內容" prop="content">
        <Tinymce ref="refTinymce"  />
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="submitForm()">提交</el-button>
        <el-button @click="resetForm()">重置</el-button>
      </el-form-item>
    </el-form>

  </div>
</template>
<script setup>

import { Plus } from '@element-plus/icons-vue'
import { getDetail,edit } from '@/api/article'
import { ElMessage } from 'element-plus'
import router from '@/router';
const route = useRoute()


import Tinymce from "@/components/Tinymce/index.vue";
/*tinymce操作*/
const refTinymce = ref(null);

let form = ref({
  id: route.params.id,
  subject: '',
  cover: '',
  content: ''
})






const Detail = async () => {
  getDetail(route.params.id).then(res => {
    form.value = res.data
    refTinymce.value.setContent(res.data.content)

  })
}
Detail()


let uploadData = reactive({
  path: 'article'
})
// 檔案上傳成功後處理
let handleAvatarSuccess = (res, file) => {
  console.log(res.data.uri)
  form.value.cover = res.data.uri
  console.log(form.value)
}
let submitForm = () => {
  console.log(form.value)
  edit(form.value).then(res => {
    if (res.sysCode == 200) {
      ElMessage.success('修改成功')
      router.push('/articleList/index')
    } else {
      ElMessage.error('新增失敗')
    }
    console.log(res)
  }).catch(err => {
    console.log(err)
  })
}
let resetForm = () => {
  Detail()
}


</script>

<style scoped>
.avatar-uploader .avatar {
  width: 178px;
  height: 178px;
  display: block;
}
</style>

<style>
.avatar-uploader .el-upload {
  border: 1px dashed var(--el-border-color);
  border-radius: 6px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
  transition: var(--el-transition-duration-fast);
}

.avatar-uploader .el-upload:hover {
  border-color: var(--el-color-primary);
}

.el-icon.avatar-uploader-icon {
  font-size: 28px;
  color: #8c939d;
  width: 178px;
  height: 178px;
  text-align: center;
}
</style>
