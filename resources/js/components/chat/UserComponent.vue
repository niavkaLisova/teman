
<template>
    <div>
        <div class="card">
            <div class="card-header">
                <div>Chat List</div>
                <button class="btn btn-outline-secondary add" @click.prevent="newChat">+</button>
            </div>
            <div class="card-body">
                <div class="users" v-for="chat in list" :key="chat.id">
                    <div :class="{ active: chat.id == chat_id}">
                       <!--  <ItemChatComponent :chat_id="chat.id" :list="chat.users.list" :active="chat.id == chat_id" /> -->
                        <div class="box-avatar">
                            <div v-for="user in chat.users">

                               <div :style="{backgroundImage: 'url(/storage/user/' + user.avatar + ')'}" class="avatar">
                                
                                </div>                      
                            </div>
                        </div>
                        <a :href="`/chat/${chat.id}`" class="title">
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
    import Event from '../../event.js';

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
                    if(this.chat_id != 0) {
                        this.$emit('current-chat', response.data.find(chat => chat.id == this.chat_id))
                    }
                });

            Event.$on('new-title', data => {
                this.list = this.list.map(chat => {
                    if(data.chat_id == chat.id) {
                        chat.title = data.title;
                    }
                    return chat;
                })
            })
        },
        methods: {
            newChat() {
                console.log('add new chat');
            }
        },
        components: {ItemChatComponent}
    }
</script>

<style lang="scss" scoped>
    .users {
        background-color: #fff;
        border-radius: 3px;

        & > div {
            display: flex;
            justify-content: space-between;
        }

        .active {
            margin-left: 1em;
        }

        .title {
            flex: 3;
        }
    }
    .card-header {
        display: flex;
        justify-content: space-between;
    }
    .add {
        border: 50%;
    }
    .box-avatar {
        width: 100%;
        height: 35px;
        display: flex;
        flex: 1;
        .avatar {
            width: 35px;
            height: 35px;
            background-size: contain;
            border-radius: 50%;
        }
    }
</style>