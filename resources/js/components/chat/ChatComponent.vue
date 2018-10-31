<template>
    <div class="row">
        <div class="col-md-8">
            <div class="card" v-if="chat_id">
                <div class="card-header">Chats</div>
                <div class="card-body">
                    <chat-messages-component :chat_id="chat_id" :me="me" @list-active="listActive"></chat-messages-component>
                    <chat-form-component :me="me" :chat_id="chat_id"></chat-form-component>
                </div>
            </div>
            <div v-if="!chat_id">
                Select Chat
            </div>
        </div>
        <div class="col-md-4">
            <user-component :activeUsers="activeUsers" :chat_id="chat_id"></user-component>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['chat_id', 'me'],
        data() {
            return {
                activeUsers: []
            }
        },
        methods: {
            listActive(data) {
                this.activeUsers = data;
            }
        }
    }
</script>