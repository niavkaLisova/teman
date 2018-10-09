<template>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Chats</div>
            <div class="card-body">
                <chat-messages-component></chat-messages-component>
                <chat-form-component></chat-form-component>
            </div>
        </div>
    </div>
</template>

<script>
    import Event from '../../event.js';

    export default {
        data() {
            return {
                messages: []
            }
        },
        mounted() {
            axios.get('/message').then((response) => {
                console.log(response.data);
                this.messages = response.data;
            });
            Event.$on('added_message', (message) => {
                this.messages.unshift(message);
                if(message.selfMessage) {
                    // this.$refs.message.scrollTop = 0;
                }
            });
        }
    }
</script>