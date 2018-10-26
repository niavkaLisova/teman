<template>
    <form class="form">
        <textarea
            id="body"
            cols="28"
            rows="5"
            class="form-input"
            @keydown="typing"
            v-model="body">
        </textarea>
        <span class="notice">
            Hit Return to send a message
        </span>
    </form>
</template>

<script>

    import Event from '../../event.js';

    export default {
        props: ['chat_id', 'me'],
        data() {
            return {
                body: null,
            }
        },
        methods: {
            typing(e) {
                if(e.keyCode === 13 && !e.shiftKey) {
                    e.preventDefault();
                    this.sendMessage();
                }        
            },
            sendMessage() {
                if(!this.body || this.body.trim() === '') {
                    return
                }
                // let messageObj = this.buildMessage();
                axios.post('/message', {
	                body: this.body.trim(),
                    chat_id: this.chat_id
	            }).then(response => {
                    let messages = response.data;
                    messages.user = {name: this.me.name};
	                // Event.$emit('added_message', messages);
	            }).catch(err => {
                    console.log('failed', err);
                })
                this.body = null;
            },
            
        }
    }
</script>

<style>
    .form {
        padding: 8px;
    }
    .form-input {
        width: 100%;
        border: 1px solid #d3e0e9;
        padding: 5px 10px;
        outline: none;
    }
    .notice {
        color: #aaa
    }
    
</style>