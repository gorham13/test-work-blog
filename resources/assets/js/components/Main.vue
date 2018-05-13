<template>
    <div>
        <!-- Navigation -->
        <nav v-if="$auth.check()" class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container">
                <router-link to="/" class="navbar-brand">Start Bootstrap</router-link>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <router-link tag="li" to="/" v-if="($auth.check('editor')||$auth.check('admin'))" class="nav-item">
                            <a class="nav-link">Home</a>
                        </router-link>
                        <router-link tag="li" to="/post/create" v-if="($auth.check('editor')||$auth.check('admin'))" class="nav-item">
                            <a class="nav-link">New Post</a>
                        </router-link>
                        <router-link tag="li" to="/users" v-if="($auth.check('admin'))" class="nav-item">
                            <a class="nav-link">Users</a>
                        </router-link>
                        <li class="nav-item">
                            <a href="javascript:void(0)" class="nav-link" @click="$auth.logout()">LogOut</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <router-view></router-view>
        <!-- Footer -->
        <footer v-if="$auth.check()" class="py-5 bg-dark">
            <div class="container">
                <p class="m-0 text-center text-white">Copyright &copy; Your Website 2018</p>
            </div>
            <!-- /.container -->
        </footer>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
