<template>
    <div class="col-md-12">
       <div class="media" v-if="post.user">
            <div>
                <img v-if="post.image.length > 3" class="mr-3 img-fluid" :src="`/images/${post.image}`" />
            </div>
            <div class="media-body container">
                <div class="row">
                    <div class="col-md-10">
                        <div class="mt-3">
                            <h2 class="title">{{post.title}}</h2>
                            <a :href="`/users/${post.user.name}`">{{post.user.name}}</a> | {{ post.createdDate }} | {{ post.view_count }} view | {{ favorite }}    <like-component
                                    :post="this.id"
                                    :favorited="favorited"
                                    v-if="user != 0"
                                    @like="like"
                                    @dislike="dislike"
                                ></like-component>
                        </div>
                    </div> 

                    <div class="col-md-2" v-if="post.user_id == user">
                        <a class="btn btn-default" :href="`/post/edit/${post.id}`">Edit</a>
                    </div>
                </div>
                
                <hr>
                <div v-html="post.body"></div>
            </div>
        </div>
    </div>
</template>
<script>

export default {
    props: {
        user: {
            required: true,
            type: Number,
        },
        id: {
            required: true,
            type: Number
        },
        favorited: {
            required: false
        }
    },
    data() {
        return {
            post: {},
            favorite: 0
        }
    },
    mounted() {
        axios.post('/post/get', {id: this.id}).then((resp => {
            this.post = resp.data;

            this.favorite = this.post.favorite.length;

            if(this.user != 0 && this.user != this.post.user_id) {
                console.log('need to increment view count');
                axios.post('/visit', {'post_id': this.post.id}).then(response => {
                    this.post.view_count = this.post.view_count + 1;
                });
            }
        }));
    },
    methods: {
        like() {
            this.favorite = this.favorite + 1;
        },
        dislike() {
            this.favorite = this.favorite - 1;
        }
    }
}
</script>

<style lang="scss" scoped>
.title {
    text-align: center;
}
.media {
    display: flex;
    flex-direction: column;
}
</style>