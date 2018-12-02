<template>
    <div>
        <div class="row"> 
            <app-router :activeUsers="activeUsers" :chat_id="chat_id" :me="me"/>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card" v-if="chat_id">
                    <div class="card-header">
                        <div v-if="state == 0">
                            <div v-if="isEdit"><input type="text" v-model="title" class="form-control" @keydown.enter="saveTitle"></div>
                            <div v-else="isEdit">{{title}}</div>
                        </div>
                        <div v-else>
                            <div v-for="user in users">
                                <h2 v-if="user.id != me.id">{{user.name}}</h2>
                            </div>
                        </div>
                        <div class="dropdown dropleft">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" @click.prevent="changeTitle" v-if="state == 0">Change Chat Title</a>
                                <a class="dropdown-item" @click.prevent="leave">Leave the Chat</a>
                                <a class="dropdown-item" @click.prevent="invite" v-if="state == 0">Invite</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <chat-messages-component :chat_id="chat_id" :me="me" @list-active="listActive" ></chat-messages-component>
                        <chat-form-component :me="me" :chat_id="chat_id" :activeUsers="activeUsers" @typing="typing"></chat-form-component>
                    </div>
                </div>
                <div v-if="!chat_id">
                    Select Chat
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Event from '../../event.js';

    export default {
        props: ['chat_id', 'me'],
        data() {
            return {
                activeUsers: [],
                title: '',
                isEdit: false,
                state: 1,
                users: []
            }
        },
        methods: {
            listActive(data) {
                this.activeUsers = data;
            },
            typing() {
                Event.$emit('type_event');
            },
            currentChat(data) {
                this.title = data.title;
            },
            changeTitle() {
                if(this.state == 0)
                    this.isEdit = true;
            },
            saveTitle(e) {
                this.isEdit = false;
                let obj = {
                    title: this.title,
                    chat_id: this.chat_id
                };

                axios.post('/update/chat/title', obj)
                .then(response => {
                    Event.$emit('new-title', obj)
                })
            },
            leave() {
                axios.post('/leave/chatroom', {chat_id: this.chat_id})
                .then(response => {
                    location.replace('/chat');
                })
            },
            invite() {
                console.log('Invite', this.chat_id);
            }
        },
        mounted() {
            if(this.chat_id != 0)
                axios.post('/chat/state/' , {chat_id: this.chat_id} )
                    .then(response => {
                        this.state = response.data.chat.state;
                        this.users = response.data.users;
                    })
        }
    }
</script>

<style lang="scss" scoped>
    .card-header {
        display: flex;
        justify-content: space-between;
    }
    .dropdown-toggle::before {
        content: none;
    }
</style>