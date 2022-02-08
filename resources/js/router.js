import Vue from "vue";
import Router from 'vue-router';
Vue.use(Router);
import myFirstVuePage from "./components/pages/myFirstVuePage";
import newRoute from "./components/pages/myRoutePage";
import hooks from "./components/pages/basic/hooks";
import methods from "./components/pages/basic/methods";
import usecom from "./vuex/usecom"

//admin project pages
import home from "./components/pages/home";
import tags from "./admin/pages/tags";
import category from "./admin/pages/category";
import adminusers from "./admin/pages/adminusers";
import login from "./admin/pages/login";
import role from "./admin/pages/role";
import assignRole from "./admin/pages/assignRole";
import createBlog from "./admin/pages/createBlog";
import blogs from "./admin/pages/blogs";
import editblog from "./admin/pages/editblog";
import notfound from "./admin/pages/notfound";

const routes = [
    //--projects routes
    {
        path: '/testvuex',
        component: usecom
    },
    {
        path: '/',
        component: home,
        name:'home'
    },
    {
        path: '/tags',
        component: tags,
        name:'tags'
    },
    {
        path: '/category',
        component: category,
        name:'category'
    },
    {
        path: '/adminusers',
        component: adminusers,
        name:'adminusers'
    },
    {
        path: '/createBlog',
        component: createBlog,
        name:'createBlog'
    },
    {
        path: '/blogs',
        component: blogs,
        name:'blogs'
    },
    {
        path: '/editblog/:id',
        component: editblog,
        name:'editblog'
    },
    {
        path: '/login',
        component: login,
        name:'login'
    },
    {
        path: '/role',
        component: role,
        name:'role'
    },
    {
        path: '/assignRole',
        component: assignRole,
        name:'assignRole'
    },
    {
        path: '*',
        component: notfound,
        name:'notfound'
    },
    {
        path: '/my-new-vue-route',
        component: myFirstVuePage
    },
    {
        path: '/my-route',
        component: newRoute
    },
    //Vue Hooks
    {
        path: '/hooks',
        component: hooks
    },
    // more basic
    {
        path: '/methods',
        component: methods
    },

]

export default new Router({
        mode: 'history',
        routes
})
