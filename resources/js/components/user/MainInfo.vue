<template>
    <div class="main">
        <h2>{{user.name}}</h2>
        <img class="mr-3 img-fluid" :src="`/storage/user/${user.avatar}`" />
        <div class="tools">
            <div class="input-group">
                <a :href="`/portfolio/${user.id}`" class="btn btn-outline-secondary">Portfolio</a>
            </div>
            <div class="input-group">
                <a :href="`/following/${user.id}/list`" class="btn btn-outline-secondary">Following</a>
                <a :href="`/follower/${user.id}/list`" class="btn btn-outline-secondary">Follower</a>   
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['user', 'me'],
    }
</script>

<style lang="scss" scoped>
    .main {
        span {
            font-size: 0.8em;
        }

        .tools {
            margin: 1em 0;
        }

        .input-group {
            margin: .5em 0;
            display: flex;
            justify-content: space-between;
        }
    }
</style>
