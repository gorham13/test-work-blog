import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
    // linkActiveClass: "active",
    linkExactActiveClass: "active",
    routes: [
        {
            path: '/login',
            name: 'login',
            component: require('./components/pages/SignIn.vue'),
            meta: {auth: false}
        },
        {
            path: '/signup',
            name: 'signup',
            component: require('./components/pages/SignUp.vue'),
            meta: {auth: false}
        },
        {
            path: '/',
            component: require('./components/pages/BlogHome.vue'),
            meta: {auth: true},
        },
        {
            path: '/post/create',
            component: require('./components/pages/CreateUpdatePost.vue'),
            meta: {auth: true},
        },
        {
            path: '/post/update/:id',
            component: require('./components/pages/CreateUpdatePost.vue'),
            meta: {auth: true},
        },
        {
            path: '/post/:id',
            component: require('./components/pages/BlogPost.vue'),
            meta: {auth: true},
        },
        {
            path: '/users',
            component: require('./components/pages/UserList.vue'),
            meta: {auth: {roles: 'admin', redirect: {name: 'login'}}},
        }
    ]
  })