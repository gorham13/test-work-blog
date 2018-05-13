<template>
    <div class="text-center">
        <form class="form-signin" v-on:submit.prevent="signup">
            <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
            
            <label for="inputName" class="sr-only">Name</label>
            <input type="text" id="inputName" class="form-control" v-model="name" placeholder="Name" required autofocus>
            
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" id="inputEmail" class="form-control" v-model="email" placeholder="Email address" required autofocus>
            
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" class="form-control" v-model="password" placeholder="Password" required>

            <label for="inputConfirmPassword" class="sr-only">Confirm Password</label>
            <input type="password" id="inputConfirmPassword" class="form-control" v-model="confirmPassword" placeholder="Confirm Password" required>
            
            <li class="text-danger" v-for="error in errors">{{error}}</li>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
        </form>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                name: '',
                email: '',
                password: '',
                confirmPassword: '',
                errors: []
            }
        },
        mounted(){
        },
        methods: {
            signup(){
                let data = this;
                if(data.password != data.confirmPassword){
                    data.errors.push('Password confirmation does not match.');
                } else {
                    data.errors = [];
                    axios.post('signup', {
                            email: data.email, 
                            password: data.password, 
                            password_confirmation: data.confirmPassword, 
                            name: data.name
                        })
                        .then(function(res){
                            data.$auth.login({
                                data: {email: data.email, password: data.password},
                            }).catch(function(error) {
                                console.error(error);
                            });
                        }).catch(function(error){
                            if(error.response){
                                for(var index in error.response.data){
                                    for(var item of error.response.data[index]){
                                        data.errors.push(item);
                                    }
                                }
                            }
                        });
                }
            }
        }
    }
</script>


<style scoped>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: -webkit-box;
        display: flex;
        -ms-flex-align: center;
        -ms-flex-pack: center;
        -webkit-box-align: center;
        align-items: center;
        -webkit-box-pack: center;
        justify-content: center;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
    }

    .form-signin {
        width: 100%;
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
    }
    .form-signin .checkbox {
        font-weight: 400;
    }
    .form-signin .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
    }
    .form-signin .form-control:focus {
        z-index: 2;
    }
    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }
    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
</style>

