
<template>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">List</div>
            <div class="card-body">
                <div class="users" v-for="chat in list" :key="chat.id">
                    <div :class="{ active: chat.id == chat_id}">
                        <ItemChatComponent :chat_id="chat.id" :list="chat.users.list" :active="chat.id == chat_id" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import ItemChatComponent from './ItemChatComponent.vue';

    export default {
        props: ['chat_id'],
        data() {
            return {
                list: null
            }
        },
        mounted() {
            axios.get('/my/chats')
                .then(response => {
                    this.list = response.data;
                })
        },
        components: {ItemChatComponent}
    }
</script>

<style lang="scss" scoped>
    .users {
        background-color: #fff;
        border-radius: 3px;

        .active {
            margin-left: 1em;
        }
    }
</style>