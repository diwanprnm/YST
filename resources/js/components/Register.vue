<template>
    <div class="mt-4 yst-regis-box">
      <div class="yst-regis-widht">
        <form @submit.prevent="register" class="yst-regis-width" method="post">
          <div class="col-12" v-if="Object.keys(validationErrors).length > 0">
            <div class="alert alert-danger">
              <ul class="mb-0">
                <li v-for="(value, key) in validationErrors" :key="key">{{ value[0] }}</li>
              </ul>
            </div>
          </div>
          <div class="mt-3">
            <a href="Login.vue" class="txt2">Kembali</a>
          </div>
          <div class="mt-4 regis-title">
            <h3>Daftar Akun</h3>
          </div>
          <div class="form-group mt-4 mb-2">
            <input type="text" name="nik" v-model="user.nik" id="nik" placeholder="NIK" class="form-control" Required>
          </div>
          <div class="form-group mt-4 mb-2">
            <input type="text" name="name" v-model="user.name" id="name" placeholder="Nama Lengkap" class="form-control" Required>
          </div> 
          <div class="form-group mt-4 mb-2">
            <input type="text" name="email" v-model="user.email" id="email" placeholder="Email" class="form-control" Required>
          </div>
          <div class="form-group mt-4 mb-2">
            <select
            name="wilayah_id"
            v-model="user.wilayah_id"
            id="wilayah_id"
            class="form-control"
            required
            @change="onWilayahSelect"
          >
            <option value="" disabled selected>Pilih Wilayah</option>
            <!-- Gunakan v-for untuk melakukan iterasi pada wilayahs dan menampilkan opsi wilayah -->
            <option v-for="wilayah in wilayahs" :key="wilayah.id_wilayah" :value="wilayah.id_wilayah">
            {{ wilayah.nama_wilayah }}
            </option>
          </select>
        </div>
          <div class="form-group mt-4 mb-2">
            <input type="password" name="password" v-model="user.password" id="password" placeholder="Password" class="form-control" Required>
          </div>
          <div class="form-group mt-4 mb-2">
            <input type="password" name="password_confirmation" v-model="user.password_confirmation" id="password_confirmation" placeholder="Enter Password" class="form-control" Required>
          </div>
          <div class="mb-2">
            <button type="submit" :disabled="processing" class="btn btn-lg btn-primary w-100 yst-login-btn border-0 mt-4 mb-5">
              <span class="yst-login-btn-fs">{{ processing ? "Please wait" : "Daftar" }}</span>
            </button>
          </div>
          <div class="text-center mt-4 mb-2">
            <label>Sudah Punya Akun? <router-link :to="{name:'login'}">Login Sekarang!</router-link></label>
          </div>
        </form>
      </div>
    </div>
  </template>
  
  <script>
import { mapActions } from 'vuex';

export default {
  name: 'register',
  data() {
    return {
      user: {
        nik: "",
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
        wilayah_id: "",
      },
      validationErrors: {},
      processing: false,
      wilayahs: [], // Tambahkan data wilayahs
    };
  },
  created() {
    this.fetchWilayahs();
  },
  methods: {
    ...mapActions({
      signIn: 'auth/login',
    }),
    async register() {
      this.processing = true;
      try {
        await axios.get('/sanctum/csrf-cookie');
        const response = await axios.post('/register', this.user);
        this.validationErrors = {};
        await this.signIn();
      } catch ({ response }) {
        if (response.status === 422) {
          this.validationErrors = response.data.errors;
        } else {
          this.validationErrors = {};
          alert(response.data.message);
        }
      } finally {
        this.processing = false;
      }
    },
    async fetchWilayahs() {
      try {
        const response = await axios.get('/api/get-wilayahs');
        this.wilayahs = response.data;
        console.log(response.data)   
      } catch (error) {
        
        console.error(error);
      }
    },

    onWilayahSelect() {
      const selectedWilayahId = this.user.wilayah_id;
      const selectedWilayah = this.wilayahs.find((wilayah) => wilayah.id === selectedWilayahId);
      if (selectedWilayah) {
        console.log(selectedWilayah); // Ganti baris ini dengan tindakan yang diinginkan saat wilayah dipilih.
        // Contoh: alert(selectedWilayah.nama_wilayah);
      }
    },
  },
};
</script>

<style src="../../css/login.css"></style>