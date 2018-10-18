<template>
    <div class="row">
        <div class="col-md-8">
            
        </div>
        <div class="col-md-4 posts">
           <p v-if="!posts.length">No posts</p>
           <div class="media" v-for="post in posts" :key="post.id">
                <img class="mr-3" />
                <div class="media-body">
                    <div class="mt-3">
                        <span v-html="post.user.ProfileLink"></span> | {{ post.createdDate }} | <a :href="`/post/${post.id}`">{{post.title}}</a>
                    </div>
                    <hr />
                    <div class="cut" v-html="post.body"></div>
                </div>
            </div>
            <infinite-loading @infinite="infiniteHandler">
                <span slot="no-more">
                    There is no more:(
                </span>
            </infinite-loading>
        </div>
    </div>
</template>

<script>
import InfiniteLoading from 'vue-infinite-loading';

export default {
    data() {
        return {
            posts: [],
            post: {},
            current_page: 1
        }
    },
    methods: {
        infiniteHandler($state) {
            axios.get('/posts/' + this.current_page + '/all')
                .then(({ data }) => {
                    if (data.data.length) {
                        this.current_page = data.current_page + 1;
                        this.posts = this.posts.concat(data.data);
                        $state.loaded();
                    } else {
                        $state.complete();
                    }
                });
        },
    },
    components: {
        InfiniteLoading,
    },
}
</script>

<style lang="scss" scoped>
.posts {
    & > div {
        margin: 20px 0;
        padding: 2%;
        box-sizing: border-box;
        border: 1px solid lightgrey;
        border-radius: 5px;
        background: white;
    }

    .cut {
        display: block;
        display: -webkit-box;
        max-width: 100%;
        height: 70px;
        margin: 0 auto;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
}
</style>