<template>
    <div id='vue-content'>
        <infinite-loading v-if="canLoad" @infinite="infiniteHandler" direction="top">
            <span slot="no-more">
                There is no more:(
            </span>
        </infinite-loading>
        <div class="message-area" ref='messageDisplay' id="scroll">
            <message-component 
                v-for="(message, index) in messages" 
                :key="index" 
                :message="message">
            </message-component>    
        </div>
        <span v-if="isActive.length > 0">
        <span v-for="active in isActive">{{active.name}} </span> is typing...</span>
        <hr>
    </div>
</template>

<script>
    import InfiniteLoading from 'vue-infinite-loading';
    import Event from '../../event.js';

    export default {
        props: ['chat_id', 'me'],
        data() {
            return {
                messages: [],
                activeUsers: [],
                current_page: 0,
                canLoad: false,
                isActive: [],
            }
        },
        computed: {
            channel() {
                return window.Echo.join('room.' + this.chat_id);
            }
        },
        watch: {
            messages(val) {
                // console.log('canLoad', (this.current_page -1) * 20, val.length)
                // console.log('current_page', this.$refs.messageDisplay.scrollHeight, this.$refs.messageDisplay.scrollTop )
                // console.log('no',val.length ,(this.current_page -1) * 20 )
                // if(val.length - (this.current_page -1) * 20 == 0 && this.current_page < 3) {
                    setTimeout(() => {
                        let messageDisplay = this.$refs.messageDisplay;

                        messageDisplay.scrollTop = messageDisplay.scrollHeight;

                    }, 50);
                // }         
            },
            activeUsers() {
                this.listActive();
            }
        },
        methods: {
            infiniteHandler($state) {
                axios.get('/message/' + this.chat_id + '/' + this.current_page)
                    .then(({ data }) => {
                        if (data.data.length) {
                            this.current_page = data.current_page + 1;
                            let temp = this.messages.reverse();
                            this.messages = (temp.concat(data.data)).reverse();
                            $state.loaded();
                        } else {
                            $state.complete();
                        }
                    });
            },

            handleScroll(event) {
                if(this.$refs.messageDisplay.scrollTop == 0) {
                    this.canLoad = true;
                    setTimeout(()=>{
                        this.canLoad = false;
                    }, 50)
                }
            },

            listActive() {
                this.$emit('list-active', this.activeUsers);
            },

            typing() {
                this.channel
                    .whisper('typing', {
                        name: this.me.name,
                        id: this.me.id
                    });
            }
        },
        mounted() {
            this.infiniteHandler();

            if(this.chat_id > 0){
                axios.post('/read/message', {chat_id: this.chat_id})
                    .then(response => {
                        this.messages = response.data.data.reverse();;
                    })
            }

            Event.$on('added_message', (message) => {
                this.messages.push(message);    
            });

            Event.$on('type_event', (message) => {
                this.typing();
            });

            this.channel
                .here(users => {
                    this.activeUsers = users;
                })
                .joining(user => {
                    this.activeUsers.push(user);
                })
                .leaving(user => {
                    this.activeUsers.splice(this.activeUsers.indexOf(user), 1);
                })
                .listen('Message', (data) => {
                    let info = data.data;
                    info.user = data.user;
                    this.messages.push(info);
                    axios.post('/read/message/one', {message_id: data.data.id})
                        .then(response => {
                            // console.log('response', response.data)
                        });

                    this.isActive = this.isActive.filter(user => {
                        return user.id != data.user.id;
                    })

                    this.channel
                        .whisper('read', {
                            id: data.user.id
                        });
                })
                .listenForWhisper('typing', e => {
                    let find = this.isActive.find(user => {
                        return user.id == e.id;
                    });

                    if(!find) {
                        this.isActive.push(e);
                    }
                    
                    if(this.typingTime) clearTimeout(this.typingTime);

                    this.typingTime = setTimeout(() => {
                        this.isActive = this.isActive.filter(user => {
                            return user.id != e.id;
                        })
                    }, 2000)
                })
                .listenForWhisper('read', e => {
                    let newM = this.messages.map(msg => {
                        if(msg.user_id, e.id) {
                            msg.read = 1;
                            return msg;
                        }
                    })
                    this.messages = newM;
                });
        },
        created: function () {
            setTimeout(() => {
                this.$refs.messageDisplay.addEventListener('scroll', this.handleScroll);
            }, 50)
        },
        destroyed: function () {
            this.$refs.messageDisplay.removeEventListener('scroll', this.handleScroll);
        },
        components: {
            InfiniteLoading,
        },
    }
</script>
<style>
    .message-area {
        height: 300px;
        max-height: 300px;
        overflow-y: scroll;
        padding: 15px;
        border-bottom: 1px solid #eee;
    }
</style>