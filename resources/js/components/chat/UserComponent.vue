
<template>
    <div>
        <div class="card">
            <div class="card-header">List</div>
            <div class="card-body">
                <div class="users" v-for="chat in list" :key="chat.id">
                    <div :class="{ active: chat.id == chat_id}">
                       <!--  <ItemChatComponent :chat_id="chat.id" :list="chat.users.list" :active="chat.id == chat_id" /> -->
                        <a :href="`/chat/${chat.id}`">
                            {{chat.title}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">Online</div>
            <div class="card-body">
                <ul>
                    <li v-for="user in activeUsers">
                        {{user}}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    import ItemChatComponent from './ItemChatComponent.vue';

    export default {
        props: ['chat_id', 'activeUsers'],
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