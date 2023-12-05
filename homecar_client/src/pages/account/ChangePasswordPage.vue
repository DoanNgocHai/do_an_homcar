<template>
  <div class="card card-compact w-full bg-base-100 shadow-xl card-bordered">
    <div class="card-body">
      <h2 class="card-title">Đổi mật khẩu</h2>
      <Form @submit="updateProfile" :validation-schema="schema">
        <div class="form-control w-full mb-2">
          <label class="label">
            <span class="label-text">Mật khẩu hiện tại</span>
          </label>
          <Field
            type="text"
            name="name"
            placeholder="Nhập mật khẩu hiện tại" 
            class="input input-bordered w-full" 
            v-model="form.name"
          />
          <ErrorMessage name="name" class="label-text-alt text-red-500" />
        </div>
        <div class="form-control w-full mb-2">
          <label class="label">
            <span class="label-text">Mật khẩu mới</span>
          </label>
          <Field
            type="text"
            name="name"
            placeholder="Nhập mật khẩu mới" 
            class="input input-bordered w-full" 
            v-model="form.name"
          />
          <ErrorMessage name="name" class="label-text-alt text-red-500" />
        </div>
        <div class="form-control w-full mb-2">
          <label class="label">
            <span class="label-text">Nhập lại mật khẩu mới</span>
          </label>
          <Field
            type="text"
            name="name"
            placeholder="Nhập lại mật khẩu mới" 
            class="input input-bordered w-full" 
            v-model="form.name"
          />
          <ErrorMessage name="name" class="label-text-alt text-red-500" />
        </div>
        <div class="form-control w-full mt-3 text-center">
          <button class="btn btn-primary">Đổi mật khẩu</button>
        </div>
      </Form>
    </div>
  </div>
</template>

<script lang="ts">
import { ErrorMessage, Field, Form } from 'vee-validate';
import { useRouter } from 'vue-router';
import { object, string } from 'yup';

export default {
  name: 'ChangePasswordPage',
  components: {
    Form: Form,
    Field: Field,
    ErrorMessage: ErrorMessage,
  },
  setup() {
    const router = useRouter()

    const schema = object().shape({
      name: string().required('Họ tên chưa được nhập'),
    })

    return {
      router,
      schema,
    }
  },
  data() {
    return {
      form: {
        name: ''
      }
    }
  },
  methods: {
    async updateProfile() {
      const { name } = this.form;
      console.log({ name })
    }
  }
}
</script>

<style scoped>
</style>
