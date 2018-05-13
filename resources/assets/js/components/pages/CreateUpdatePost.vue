<template>
    <div class="container">
        <h2>New Post</h2>
        <form @submit.prevent="submit">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" placeholder="Enter title" name="title" v-model="post.title">
            </div>
            <div class="form-group">
                <label for="main_image">Main Image:</label>
                <input type="file" class="form-control" id="main_image" placeholder="Choose file" name="main_image" @change="onFileChange">
            </div>
            <div class="form-group">
                <label>Content:</label>
                <vue-editor v-model="post.content"></vue-editor>            
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</template>
<script>
    import { VueEditor } from 'vue2-editor'

    export default {
        components: {
            VueEditor
        },
        watch: {
            '$route' () {
                this.editData();
            }
        },
        data(){
            return {
                post: {},
                formData: null
            }
        },
        created(){
            this.editData();
        },
        methods: {
            submit(){
                let data = this;
                if(!data.formData){
                    data.formData = new FormData();
                }
                for(var index in data.post) {
                    data.formData.append(index, data.post[index]);
                }
                data.formData.append('user_id', data.$auth.user().id);
                if(data.post.id){
                    axios.post('blog/' + data.post.id, data.formData)
                        .then(function(res){
                            data.$router.push('/post/' + data.post.id);
                        }).catch(function(error){
                            console.error(error);
                        });
                } else {
                    axios.post('blog', data.formData)
                        .then(function(res){
                            data.$router.push('/post/' + res.data.id);
                        }).catch(function(error){
                            console.error(error);
                        });
                }
            },
            onFileChange(e){
                let data = this;
                if(!this.formData){
                    this.formData = new FormData();
                }
                var img = e.target.files[0];
                this.formData.append('main_image', img);
            },
            editData(){
                let data = this;
                if(data.$route.params.id){
                    axios.get('blog/' + data.$route.params.id)
                        .then(function(res){
                            data.post = res.data;
                        }).catch(function(error){
                            console.error(error);
                        })
                } else {
                    data.post = {content: ''};
                }
            }
        }
    }
</script>

