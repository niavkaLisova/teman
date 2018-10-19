<template>
    <div class="container">
        <h2>My Favorites</h2>
        <div class="media"  v-for="post in list" :key="post.id">
            <div class="media-body">
                <div class="mt-3">
                    <a :href="`/post/${post.id}`">{{post.title}}</a>
                </div>
                <div class="cut" v-html="post.body"></div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
       props: ['list']
    }
</script>

<style lang="scss" scoped>
    .media {
        margin: 1em 0;
        border-bottom: 1px solid lightgray;

        .cut {
            display: block;
            display: -webkit-box;
            max-width: 100%;
            max-height: 70px;
            margin: 0 auto;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    }
</style>