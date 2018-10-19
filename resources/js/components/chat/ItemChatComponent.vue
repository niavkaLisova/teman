
<template>
    <div>
        <a :href="`/chat/${this.chat_id}`" :class="{ active: active}">
            <span v-for="user in users" :key="user.name">
                {{user.name}} 
            </span>
        </a>
    </div>
</template>

<script>
    export default {
        props: ['list', 'chat_id', 'active'],
        data() {
            return {
                users: null
            }
        },
        mounted() {
            axios.post('/find/companion/info', {list: this.list})
                .then(response => {
                    this.users = response.data;
                    if(this.users.length < 2) {
                        this.users.push({name: 'deleted user'})
                    }
                })
        }
    }
</script>

<style lang="scss" scoped>
    .active {
        color: red;
    }
</style>