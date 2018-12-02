
<template>
    <div>
        <div class="card">
            <div class="card-header">
                <div>Chat List</div>
                <button class="btn btn-outline-secondary add" @click.prevent="newChat">
                    <span v-if="selectNew"><-</span>
                    <span v-else="!selectNew">+</span>
                </button>
            </div>
            <div class="card-body">
                <hr>
               <!--  <better-input-tag :on-change="changeSelected" :tags="tagsArray" v-if="selectNew" ></better-input-tag> -->
               <div v-if="selectNew">
                    <vue-tags-input
                      v-model="tag"
                      :tags="tags"
                      @tags-changChated="changeTags"
                      @input="update"
                    />
                </div>
                
                <div v-if="selectNew" v-for="user in findList" :key="user.id" class="user-find" @click.prevent="writeUser(user)">
                    <div :style="{backgroundImage: 'url(/storage/user/' + user.avatar + ')'}" class="avatar">        
                    </div>
                    <div>
                        {{user.name}}
                    </div>
                </div>

                <div v-if="!selectNew" class="users" v-for="chat in list" :key="chat.id">
                    <div :class="{ active: chat.id == chat_id}">
                       <!--  <ItemChatComponent :chat_id="chat.id" :list="chat.users.list" :active="chat.id == chat_id" /> -->
                        <div class="box-avatar">
                            <div v-for="user in chat.users.slice(0, 3)">

                               <div :style="{backgroundImage: 'url(/storage/user/' + user.avatar + ')'}" class="avatar">
                                
                                </div>                      
                            </div>
                        </div>
                        <a :href="`/chat/${chat.id}`" class="title">
                            <span v-if="chat.state == 1">
                                <span v-for="user in chat.users">
                                    <span v-if="me.id != user.id">{{user.name}}</span>
                                </span>
                            </span>
                            
                            <span v-else>{{chat.title}}</span> 
                        </a>
                        <router-link :to="{ name: 'page', params: { id: chat.id } }">Hello World</router-link>
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
        props: ['chat_id', 'activeUsers', 'me'],
        data() {
            return {
                list: null,
                selectUser: [],
                selectNew: false,
                tag: '',
                tags: [],
                findList: []
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
                this.selectNew = !this.selectNew;
            },
            changeTags(newTags) {
                let length = this.tags.length;
                let tagsArray = newTags.slice(0, length);
                if (newTags[length] && this.findList.length > 0 && newTags[length].text.length > 0){ 
                        let extra = this.findList[0]; 

                        if(!this.tags.find(user => user.user_id == extra.id))          
                            tagsArray.push({'text': extra.name, 'user_id': extra.id});
                }

                this.tags = tagsArray;
            },
            update() {
                if(this.tag.length != 0) {;
                    axios.post('/find/userlist/chat', {search: this.tag})
                        .then(response => {
                            this.findList = response.data;
                        })
                } else {
                    // this.findList = [];
                }
            },
            writeUser(user) {
                this.tag = '';
                let copy = this.tags.slice();
                if(!this.tags.find(item => item.user_id == user.id))
                    copy.push({text: user.name, user_id: user.id});
                this.tags = copy;

                if(this.tags.length == 1) {
                    axios.post('/find/chat/user', {'user_id': user.id})
                    .then(response => {
                        console.log('chat with', response.data);
                        if(response.data.length > 0) {
                            window.location.replace('/chat/' + response.data[0].chat_id);
                        }
                    })
                } else {
                    axios.post('/find/chat/poli/user', {'user_id': user.id})
                    .then(response => {
                        console.log('poli chat with', response.data);
                    })
                }
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
    }
    .avatar {
            width: 35px;
            height: 35px;
            background-size: contain;
            border-radius: 50%;
        }
    .user-find {
        display: flex;
        justify-content: space-between;
        cursor: pointer;
        margin: 10px 0;
        padding: 2%;
        &:hover {
            background-color: lightgray;
        }
    }
</style>