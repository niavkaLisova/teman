<template>
    <div>
        <img class="mr-3 img-fluid" :src="`/storage/user/${avatar}`" />
        <upload :id="user.id" @change-avatar="changeAvatar"></upload>
    </div>
</template>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                avatar: ''
            }
        },
        mounted() {
            this.avatar = this.user.avatar;
        },
        methods: {
            changeAvatar(data) {
                this.avatar = data.avatar;
            }
        }
    }
</script>
