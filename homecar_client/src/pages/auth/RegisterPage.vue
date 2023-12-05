<template>
  <div class="w-full max-w-xs p-4 m-auto ">
    <h3 class="text-lg text-center font-bold uppercase">Đăng ký tài khoản</h3>
    <Form @submit="onSubmit" :validation-schema="schema">
      <div class="form-control w-full max-w-xs mb-2">
        <label class="label">
          <span class="label-text">Họ tên</span>
        </label>
        <Field
          type="text"
          name="name"
          placeholder="Họ tên" 
          class="input input-bordered w-full max-w-xs" 
          v-model="form.name"
        />
        <ErrorMessage name="name" class="label-text-alt text-red-500" />
      </div>
      <div class="form-control w-full max-w-xs mb-2">
        <label class="label">
          <span class="label-text">Email</span>
        </label>
        <Field 
          type="email"
          name="email"
          placeholder="Email" 
          class="input input-bordered w-full max-w-xs" 
          v-model="form.email"
        />
        <ErrorMessage name="email" class="label-text-alt text-red-500" />
      </div>
      <div class="form-control w-full max-w-xs mb-2">
        <label class="label">
          <span class="label-text">Mật khẩu</span>
        </label>
        <Field 
          type="password"
          name="password"
          placeholder="Mật khẩu" 
          class="input input-bordered w-full max-w-xs"
          v-model="form.password"
        />
        <ErrorMessage name="password" class="label-text-alt text-red-500" />
      </div>
      <div class="form-control w-full max-w-xs mt-3">
        <button class="btn btn-primary">Đăng ký</button>
      </div>
    </Form>
  </div>
</template>

<script lang="ts">
import { Form, Field, ErrorMessage } from 'vee-validate';
import { object, string } from "yup";
import { register } from '../../apis/auth'
import { useRouter } from 'vue-router';
import { useToast } from "vue-toastification";

export default {
  name: 'RegisterPage',
  components: {
    Form: Form,
    Field: Field,
    ErrorMessage: ErrorMessage,
  },
  setup() {
    const router = useRouter();
    const toast = useToast();
    const schema = object().shape({
      name: string()
        .required('Họ tên chưa được nhập'),
      email: string()
        .required('Email chưa được nhập')
        .email('Chưa đúng định dạng email'),
      password: string()
        .required('Mật khẩu chưa được nhập')
        .min(8, 'Mật khẩu tối thiểu 8 ký tự')
        .max(32, 'Mật khẩu tối đa 32 ký tự')
    });

    return {
      router,
      schema,
      toast,
    }
  },
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: ''
      }
    }
  },
  methods: {
    async onSubmit() {
      const { name, email, password } = this.form;
      const data = await register({ name, email, password });
      if (data) {
        this.router.push('/auth/login');
        this.toast.success("Đăng ký thành công");

      }
    }
  }
}
</script>

<style scoped>
</style>
