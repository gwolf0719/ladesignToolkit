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
        <vue3-tinymce v-model="form.content" :setting="state.setting" />
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="submitForm()">提交</el-button>
        <el-button @click="resetForm()">重置</el-button>
      </el-form-item>
    </el-form>

  </div>
</template>
<script setup>
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import { Plus } from '@element-plus/icons-vue'
import { add,getDetail,edit } from '@/api/article'
import { ElMessage } from 'element-plus'
import router from '@/router';


import Vue3Tinymce from '@jsdawn/vue3-tinymce';

const route = useRoute()



let form = ref({
  id: route.params.id,
  subject: '',
  cover: '',
  content: ''
})


const state = reactive({
  content: form.value.content,
  // editor 配置项
  setting: {
    width: '100%',
    height: 400, // editor 高度
    toolbar:
      'undo redo | fullscreen | blocks alignleft aligncenter alignright alignjustify | link unlink | numlist bullist | image media table | fontsize forecolor backcolor | bold italic underline strikethrough | indent outdent | superscript subscript | removeformat |',
    toolbar_mode: 'sliding',
    quickbars_selection_toolbar:
      'removeformat | bold italic underline strikethrough | fontsize forecolor backcolor',
    plugins: 'link image media table lists fullscreen quickbars imagetools',
    font_size_formats: '12px 14px 16px 18px',
    link_default_target: '_blank',
    link_title: false,
    nonbreaking_force_tab: true,
    // 以中文简体为例
    language: 'zh-Hans',
    // language_url:
    //   'https://unpkg.com/@jsdawn/vue3-tinymce@2.0.2/dist/tinymce/langs/zh-Hans.js',
    custom_images_upload: true,
    images_upload_url: 'api/Media/uploadFromFile',
    custom_images_upload_callback: (res) => res.data.uri,
    custom_images_upload_param: { 'path': 'article' },
  }
});

const Detail = async () => {
  getDetail(route.params.id).then(res => {
    form.value = res.data
    // state.content = res.data.content

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
