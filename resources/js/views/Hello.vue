<template>
	<div>
		<h1>TEST {{$route.params.id}}</h1>
  		<div class="card" v-if="chat_id">
            <div class="card-header">
                <div v-if="state == 0">
                	<div v-if="isEdit">
                		<input type="text" v-model="title" class="form-control" @keydown.enter="saveTitle">
                	</div>
                    <div v-else>{{title}}</div>
                </div>
                <div v-else>
                    <div v-for="user in users">
                        <div v-if="user.id != me.id">{{user.name}}</div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <chat-messages-component :chat_id="chat_id" :me="me" @list-active="listActive" ></chat-messages-component>
                <chat-form-component :me="me" :chat_id="chat_id" :activeUsers="activeUsers" @typing="typing"></chat-form-component>
            </div>
        </div>
	</div>
</template>

<script>
	import Event from '../event.js';

	export default {
		props: ['me'],
        data() {
            return {
            	chat_id: 1,
                state: 1,
                users: [],
                isEdit: false,
                title: '',
                activeUsers: []
            }
        },
        updated() {
        	let id = this.$route.params.id;
        	console.log('update', id, this.chat_id);
            if(id != this.chat_id && id != 0)
                axios.post('/chat/state/' , {chat_id: id} )
                    .then(response => {
                    	console.log('test', this.chat_id, response.data.chat)
                    	this.title = response.data.chat.title;
                        this.state = response.data.chat.state;
                        this.users = response.data.users;
                        this.chat_id = id;
                    })
        },
        mounted() {
        	let id = this.$route.params.id;
            if(id != 0)
                axios.post('/chat/state/' , {chat_id: id} )
                    .then(response => {
                    	this.title = response.data.chat.title;
                        this.state = response.data.chat.state;
                        this.users = response.data.users;
                        this.chat_id = id;
                    })
        },
        methods: {
        	saveTitle() {
        		console.log('save title')
        	},
        	listActive(data) {
                this.activeUsers = data;
            },
            typing() {
                Event.$emit('type_event');
            }
        }
	}
</script>