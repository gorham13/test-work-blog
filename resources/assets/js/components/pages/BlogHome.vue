<template>
    <div>
        <!-- Page Content -->
        <div class="container">

            <div class="row">

                <!-- Blog Entries Column -->
                <div class="col-md-8">

                    <h1 class="my-4">Page Heading
                        <small>Secondary Text</small>
                    </h1>

                    <!-- Blog Post -->
                    <div class="card mb-4" :key="post.id" v-for="post in posts">
                        <img v-if="post.main_image" class="card-img-top" :src="imgTransform(post.main_image)" alt="Card image cap">
                        <div class="card-body">
                            <h2 class="card-title">{{post.title}}</h2>
                            <p class="card-text"><span v-html="post.content.slice(0,80)"></span></p>
                            <div class="row">
                                <div class="col-8">
                                    <router-link :to="'/post/' + post.id" class="btn btn-primary">Read More</router-link>
                                </div>
                                <div class="col-4">
                                    <div class="btn-group float-right mt-2" role="group" v-if="$auth.check('admin')||($auth.user().id==post.user.id)">
                                        <router-link :to="'/post/update/' + post.id" class="btn btn-warning btn-md" @click="editComment = comment.id">Edit</router-link>
                                        <button class="btn btn-danger btn-md" @click="deletePost(post.id)">Delete</button>
                                        <!-- <a class="btn btn-md btn-secondary" href="#">
                                            <i class="fa fa-flag" aria-hidden="true"></i> Report</a> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            Posted on {{post.created_at}} by
                            {{post.user.name}}
                        </div>
                    </div>

                    <!-- Pagination -->
                    <ul class="pagination justify-content-center mb-4">
                        <li class="page-item">
                            <a class="page-link" href="#">&larr; Older</a>
                        </li>
                        <li class="page-item disabled">
                            <a class="page-link" href="#">Newer &rarr;</a>
                        </li>
                    </ul>

                </div>

                <!-- Sidebar Widgets Column -->
                <div class="col-md-4">

                    <!-- Search Widget -->
                    <div class="card my-4">
                        <h5 class="card-header">Search</h5>
                        <div class="card-body">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                    <button class="btn btn-secondary" type="button">Go!</button>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Categories Widget -->
                    <div class="card my-4">
                        <h5 class="card-header">Categories</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <ul class="list-unstyled mb-0">
                                        <li>
                                            <a href="#">Web Design</a>
                                        </li>
                                        <li>
                                            <a href="#">HTML</a>
                                        </li>
                                        <li>
                                            <a href="#">Freebies</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6">
                                    <ul class="list-unstyled mb-0">
                                        <li>
                                            <a href="#">JavaScript</a>
                                        </li>
                                        <li>
                                            <a href="#">CSS</a>
                                        </li>
                                        <li>
                                            <a href="#">Tutorials</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Side Widget -->
                    <div class="card my-4">
                        <h5 class="card-header">Side Widget</h5>
                        <div class="card-body">
                            You can put anything you want inside of these side widgets. They are easy to use, and feature the new Bootstrap 4 card containers!
                        </div>
                    </div>

                </div>

            </div>
            <!-- /.row -->

        </div>
        <!-- /.container -->
    </div>
</template>
<script>
    export default {
        data(){
            return {
                posts: []
            }
        },
        created(){
            let data = this;
            axios.get('blog').then(function(res){
                data.posts = res.data.data;
            }).catch(function(error){
                console.error(error);
            });
        },
        methods:{
            imgTransform(imgPath){
                return imgPath.replace('public', 'storage');
            },
            deletePost(id){
                let data = this;
                axios.delete('blog/' + id)
                    .then(function(){
                        let index = data.posts.findIndex((o)=>{return o.id == id});
                        data.posts.splice(index, 1);
                    }).catch(function(error){
                        console.error(error);
                    });
            },
        }
    }
</script>
<style>
    content-truncate{
        white-space: nowrap; 
        width: 50px; 
        overflow: hidden;
        text-overflow: ellipsis; 
    }
</style>


