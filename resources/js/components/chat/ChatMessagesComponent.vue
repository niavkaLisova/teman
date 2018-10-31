<template>
    <div id='vue-content'>
        <infinite-loading v-if="canLoad" @infinite="infiniteHandler" direction="top">
            <span slot="no-more">
                There is no more:(
            </span>
        </infinite-loading>
        <div class="message-area" ref='messageDisplay' id="scroll">
            <message-component 
                v-for="message in messages" 
                :key="message.id" 
                :message="message">
            </message-component>      
        </div>
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
                canLoad: false
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
            }
        },
        mounted() {
            this.infiniteHandler();

            Event.$on('added_message', (message) => {
                this.messages.push(message);    
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