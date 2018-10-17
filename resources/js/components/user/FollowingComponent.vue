<template>
    <div class="following">
        <div v-for="user in following.splice(0, 3)" class="followUser">
            <a :href="`/users/${user.id}`">
                <span>{{user.name}}</span>
                <img class="mr-3 img-fluid" :src="`/storage/user/${user.avatar}`" />
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['following']
    }
</script>

<style lang="scss" scoped>
.following {
    display: flex;
    border: 1px solid lightgray;
    margin: 1em 0;

    .followUser {
        flex-basis: 100px;

        &:hover {
            cursor: poniter;
        }
    }
}
</style>