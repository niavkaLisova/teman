<template>
    <form class="form">
        <textarea
            id="body"
            cols="28"
            rows="5"
            class="form-input"
            @keydown="typing"
            @input="input"
            v-model="dis"
            debounce="500">
        </textarea>
        <picker set="twitter" @select="addEmoji" />
        <span class="notice">
            Hit Return to send a message
        </span>
    </form>
</template>

<script>
    import { Picker } from 'emoji-mart-vue'
    import Event from '../../event.js';

    export default {
        props: ['chat_id', 'me', 'activeUsers'],
        data() {
            return {
                body: '',
                dis: ''
            }
        },
        methods: {
            typing(e) {
                this.$emit('typing');

                if(e.keyCode === 13 && !e.shiftKey) {
                    e.preventDefault();
                    this.sendMessage();
                }        
            },
            input(e) {
                // console.log('input', e)
                if(e.inputType == "insertText") {
                    this.body += e.data;
                }
                if(e.inputType == "deleteContentBackward") {
                    this.body = this.body.substr(0, this.body.length - 1)
                }
                // console.log('data', e.data, e.data == undefined)
                if(e.data == undefined) {
                    this.body = e.srcElement.value;
                }

            },
            sendMessage() {
                console.log('send messages', this.body);
                if(!this.body || this.body.trim() === '') {
                    return
                }
                let read = 0;
                // let messageObj = this.buildMessage();
                // if(this.activeUsers.length > 1) {
                //     read = 1;
                //     console.log('Your companion is online')
                // }
                axios.post('/message', {
	                body: this.body.trim(),
                    chat_id: this.chat_id,
                    read: read
	            }).then(response => {
                    let messages = response.data;
                    messages.user = {name: this.me.name};
	                // Event.$emit('added_message', messages);
	            }).catch(err => {
                    console.log('failed', err);
                })
                this.body = '';
                this.dis = '';
            },
            addEmoji(e) {
                // console.log(e);
                this.body += ':idx:' + e.id + ':';
                this.dis += e.native;
                document.getElementById("body").focus();
            }
        },
        components: {
            Picker
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