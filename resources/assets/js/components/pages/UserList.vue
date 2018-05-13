<template>
    <div class="container">
        <h2>Users</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                <tr :key="user.id" v-for="user in users">
                    <td>{{user.name}}</td>
                    <td>{{user.email}}</td>
                    <th>
                        <select class="form-control" v-model="user.role" @change="changeRole(user)">
                            <option :key="role" v-for="role in roles">{{role}}</option>
                        </select>
                    </th>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    export default {
        data(){
            return {
                users: [],
                roles: ['admin', 'editor', 'user']
            }
        },
        created(){
            let data = this;
            axios.get('/users').then(function(res){
                data.users = res.data;
            }).catch(function(error) {
                console.error(error);
            });
        },
        methods:{
            changeRole(user){
                axios.patch('/change-role/' + user.id, {role: user.role})
                    .then(function(res){
                        //data.users = res.data;
                    }).catch(function(error) {
                        console.error(error);
                    });
            }
        }
    }
</script>

