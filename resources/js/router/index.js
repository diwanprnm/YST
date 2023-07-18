import { createWebHistory, createRouter } from 'vue-router'
import store from '../store/index.js'

/* Guest Component */
const Login = () => import('../components/Login.vue')
const Register = () => import('../components/Register.vue')
/* Guest Component */

/* Layouts */
const DahboardLayout = () => import('../components/layouts/Default.vue')
const Sidebar = () => import('../components/layouts/Sidebar.vue')
/* Layouts */

/* Authenticated Component */
const Dashboard = () => import('../components/Dashboard.vue')
const PostIndex = () => import('../../views/post/Index.vue')
const PostCreate = () => import('../../views/post/Create.vue')
const PostEdit = () => import('../../views/post/Edit.vue')
/* Authenticated Component */


const routes = [
    {
        name: "login",
        path: "/login",
        component: Login,
        meta: {
            middleware: "guest",
            title: `Login`
        }
    },
    {
        name: "register",
        path: "/register",
        component: Register,
        meta: {
            middleware: "guest",
            title: `Register`
        }
    },
    {
        path: "/",
        component: DahboardLayout, Sidebar,
        meta: {
            middleware: "auth"
        },
        children: [
            {
                name: "dashboard",
                path: '/',
                component: Dashboard,
                meta: {
                    title: `Dashboard`
                }
            },
            {
                name: "post.index",
                path: '/postindex',
                component: PostIndex,
                meta: {
                    title: `Index`
                }
            },
            {
                name: "post.create",
                path: '/postcreate',
                component: PostCreate,
                meta: {
                    title: `Create`
                }
            },
            {
                name: "post.edit",
                path: '/postedit',
                component: PostEdit,
                meta: {
                    title: `Edit`
                }
            }
        ]
    }
    
]

const router = createRouter({
    history: createWebHistory(),
    routes, // short for `routes: routes`
})

router.beforeEach((to, from, next) => {
    document.title = to.meta.title
    if (to.meta.middleware == "guest") {
        if (store.state.auth.authenticated) {
            next({ name: "dashboard" })
        }
        next()
    } else {
        if (store.state.auth.authenticated) {
            next()
        } else {
            next({ name: "login" })
        }
    }
})

export default router