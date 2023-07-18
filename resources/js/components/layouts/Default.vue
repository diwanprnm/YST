<template>

    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white bg-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>
                    <!-- Right Navbar Links -->
                        <ul class="navbar-nav ml-auto user-wrapper">
                            <img src="../../../../img/user-default.jpg" width="3opx" height="30px" alt=""/>
                            <li class="nav-item dropdown user-dropdown">
                                <a class="nav-link dropdown-toggle pr-4" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ user.name }}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="javascript:void(0)" @click="logout">Logout</a>
                                </div>
                            </li>
                        </ul>
        </nav>
        <main class="mt-3">
            <router-view></router-view>
        </main>
    </div>
<footer class="main-footer me-auto">
    <center><strong> &copy; YST 2023.</strong> Yayasan Sekar Telkom </center>
</footer>     
</template>

<script>
import Sidebar from './Sidebar.vue'
import {mapActions} from 'vuex'
export default {
    name:"dashboard-layout",
    data(){
        return {
            user:this.$store.state.auth.user
        }
    },
    methods:{
        ...mapActions({
            signOut:"auth/logout"
        }),
        async logout(){
            await axios.post('/logout').then(({data})=>{
                this.signOut()
                this.$router.push({name:"login"})
            })
        }
    }
}
</script>

<style src="../../../css/dashboard-yst.css">

</style>


