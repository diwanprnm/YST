<template>
<body>
    <div class="text-center login-container">
        <div class="yst-login-box ">
            <form action="javascript:void(0)" class="yst-login-width " method="post">
                            <div class="col-12" v-if="Object.keys(validationErrors).length > 0">
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        <li v-for="(value, key) in validationErrors" :key="key">{{ value[0] }}</li>
                                    </ul>
                                </div>
                            </div>
                        <div class="kembali-konten pt-3">
                            <a href="index.php" class="txt3 hov1"> Kembali </a>
                        </div>        
                        <img class="mt-4 mb-4" src="../../../img/logo-yst.png" alt="YST Logo" height="100">
                            <div class="form-group ">
                                <input type="text" v-model="auth.email" name="email" id="email" class="form-control mb-2" placeholder="Email" Required autofocus>
                            </div>
                            <div class="form-group  my-0">
                                <input type="password" v-model="auth.password" name="password" id="password" class="form-control mb-3" placeholder="Password">
                            </div>
                            <div class=" mb-2">
                                <button type="submit" :disabled="processing" @click="login" class="btn btn-lg btn-primary w-100 yst-login-btn border-0">
                                <span class="yst-login-btn-fs">{{ processing ? "Please wait" : "Login" }}</span>
                                </button>
                            </div>
                            <div class="text-center">
                                <label>Belum Punya Akun? <router-link :to="{name:'register'}">Daftar Sekarang!</router-link></label>
                            </div>
            </form>
        </div>
    </div>
</body>
</template>

<script>
import { mapActions } from 'vuex'
export default {
    name:"login",
    data(){
        return {
            auth:{
                email:"",
                password:""
            },
            validationErrors:{},
            processing:false
        }
    },
    methods:{
        ...mapActions({
            signIn:'auth/login'
        }),
        async login(){
            this.processing = true
            await axios.get('/sanctum/csrf-cookie')
            await axios.post('/login',this.auth).then(({data})=>{
                this.signIn()
            }).catch(({response})=>{
                if(response.status===422){
                    this.validationErrors = response.data.errors
                }else{
                    this.validationErrors = {}
                    alert(response.data.message)
                }
            }).finally(()=>{
                this.processing = false
            })
        },
    }
}
</script>

<style src="../../css/login.css"></style>


