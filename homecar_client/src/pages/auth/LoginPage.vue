<template>
  <Form class="login w-full max-w-xs p-4 m-auto" @submit="onSubmit" :validation-schema="schema">
    <h3 class="text-lg text-center font-bold uppercase">Đăng nhập</h3>
    <div class="form-control w-full max-w-xs mb-2">
      <label class="label">
        <span class="label-text">Email</span>
      </label>
      <Field 
        type="text" 
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
      <v-btn :loading="loading" type="submit" class="btn btn-primary">Đăng nhập</v-btn>
    </div>
  </Form>
</template>

<script lang="ts">
import { Form, Field, ErrorMessage } from 'vee-validate';
import { useRouter } from 'vue-router';
import { object, string } from "yup";
import { login } from '../../apis/auth';
import { setToken } from '../../utils/token';
import { useToast } from "vue-toastification";
import { useStore, mapState } from 'vuex';

export default {
  name: 'LoginPage',
  components: {
    Form: Form,
    Field: Field,
    ErrorMessage: ErrorMessage,
  },

  setup() {
    const router = useRouter();
    const toast = useToast();
    const schema = object().shape({
      email: string().required('Email chưa được nhập').email('Chưa đúng định dạng email'),
      password: string().required('Mật khẩu chưa được nhập')
    });
    const store = useStore();

    return {
      router,
      schema,
      toast,
      store
    }
  },

  data() {
    return {
      form: {
        email: '',
        password: ''
      },
      loading: false,

    }
  },
  methods: {
    async onSubmit() {
      this.loading = true;
      const { email, password } = this.form;
      try {
        const data = await login({ email, password });
        if (data) {
          setToken(data.access_token);
          this.store.dispatch('userAction', data);
          this.router.push('/');
          this.toast.success("Đăng nhập thành công");
          console.log(data);
          
        }
      } catch (error) {
        this.toast.error("Đăng nhập thất bại, vui lòng kiểm tra lại thông tin đăng nhập.");
      }
      this.loading = false;
    }
  },
  computed: {
    ...mapState(['user']),
  },
}
</script>

<style scoped>
.login {}
</style>
