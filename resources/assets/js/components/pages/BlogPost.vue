<template>
    <div>
        
        <!-- Page Content -->
        <div class="container">

            <div class="row">

                <!-- Post Content Column -->
                <div class="col-lg-8">

                    <!-- Title -->
                    <h1 class="mt-4">{{post.title}}</h1>

                    <!-- Author -->
                    <p class="lead">
                        by
                        {{post.user.name}}
                    </p>

                    <hr>

                    <!-- Date/Time -->
                    <p>Posted on {{post.created_at}}</p>

                    <hr>

                    <!-- Preview Image -->
                    <img v-if="post.main_image" class="img-fluid rounded" :src="imgTransform(post.main_image)" alt="">

                    <hr>

                    <!-- Post Content -->
                    <span v-html="post.content"></span>
                    <hr>

                    <!-- Comments Form -->
                    <div class="card my-4">
                        <h5 class="card-header">Leave a Comment:</h5>
                        <div class="card-body">
                            <form @submit.prevent="addComment">
                                <div class="form-group">
                                    <textarea class="form-control" rows="3" v-model="comment"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>

                    <!-- Single Comment -->
                    <div class="media mb-4" :key="comment.id" v-for="comment in post.comments">
                        <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                        <div class="media-body">
                            <div class="row">
                                <div class="col-8" v-if="editComment != comment.id">
                                    <h5 class="mt-0">{{comment.user.name}}</h5>
                                    {{comment.content}}
                                </div>
                                <div class="col-8" v-else>
                                    <form @submit.prevent="updateComment(comment)">
                                        <div class="form-group">
                                            <textarea class="form-control" rows="3" v-model="comment.content"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                        <button type="button" class="btn" @click="editComment = 0">Cancel</button>
                                    </form>
                                </div>
                                <div class="col-4">
                                    <div class="btn-group float-right mt-2" role="group" v-if="$auth.check('admin')||($auth.user().id==comment.user.id)">
                                        <button class="btn btn-warning btn-md" @click="editComment = comment.id">Edit</button>
                                        <button class="btn btn-danger btn-md" @click="deleteComment(comment.id)">Delete</button>
                                        <!-- <a class="btn btn-md btn-secondary" href="#">
                                            <i class="fa fa-flag" aria-hidden="true"></i> Report</a> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Comment with nested comments -->
                    <!-- <div class="media mb-4">
                        <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                        <div class="media-body">
                            <h5 class="mt-0">Commenter Name</h5>
                            Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.

                            <div class="media mt-4">
                                <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                                <div class="media-body">
                                <h5 class="mt-0">Commenter Name</h5>
                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                                </div>
                            </div>

                            <div class="media mt-4">
                                <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
                                <div class="media-body">
                                <h5 class="mt-0">Commenter Name</h5>
                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                                </div>
                            </div>

                        </div>
                    </div> -->

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
                post: {
                        user: '',
                        comments:[]
                    },
                comment: '',
                editComment: 0
            }
        },
        created(){
            let data = this;
            axios.get('blog/' + data.$route.params.id)
                .then(function(res){
                    data.post = res.data;
                }).catch(function(error){
                    console.error(error);
                });
        },
        methods:{
            imgTransform(imgPath){
                return imgPath.replace('public', 'storage');
            },
            addComment(){
                let data = this;
                axios.post('comment', {content: data.comment, 
                                       blog_id: data.post.id,
                                       user_id: data.$auth.user().id  
                                      })
                    .then(function(res){
                        data.comment = '';
                        data.post.comments.push(res.data);
                    }).catch(function(error){
                        console.error(error);
                    });
            },
            deleteComment(id){
                let data = this;
                axios.delete('comment/' + id)
                    .then(function(){
                        let index = data.post.comments.findIndex((o)=>{return o.id == id});
                        data.post.comments.splice(index, 1);
                    }).catch(function(error){
                        console.error(error);
                    });
            },
            updateComment(comment){
                let data = this;
                axios.patch('comment/' + comment.id, comment)
                    .then(function(){
                        data.editComment = 0;
                    }).catch(function(error){
                        console.error(error);
                    });
            }
        }
    }
</script>
