<template>
    <div class="main">
        <h2 v-if="user.username">{{user.username}} <span>(@{{user.name}})</span></h2>
        <h2 v-if="!user.username">{{user.name}}</h2>
        <img class="mr-3 img-fluid" :src="`/storage/user/${user.avatar}`" />
        <a :href="`/portfolio/${user.id}`" class="btn btn-outline-secondary">Portfolio</a>
    </div>
</template>

<script>
    export default {
        props: ['user'],
    }
</script>

<style lang="scss" scoped>
    .main {
        span {
            font-size: 0.8em;
        }
    }
</style>
