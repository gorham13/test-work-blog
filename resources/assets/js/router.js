import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
    routes: [
        {
            path: '/login',
            name: 'login',
            component: require('./components/pages/SignIn.vue'),
            meta: {auth: false}
        },
        {
            path: '/',
            component: require('./components/pages/BlogHome.vue'),
            meta: {auth: true},
        },
    ]
  })