<template>
    <div class="comments-app" v-if="body">
        <div v-if="state === 'default'">
            <div class="comment-box">
                <img v-if="comment.user" class="mr-3 img-avatar" :src="`/storage/user/${comment.user.avatar}`" />
                <div class="comment">        
                    <div class="head">
                        <h6><span v-if="comment.user" v-html="comment.user.ProfileLink"></span><span v-if="!comment.user">user deleted</span> | {{ comment.createdDate }} <span v-if='comment.edit'> | edited</span><span @click="answerShow" v-if="user != 0"> | answer</span></h6>
                        <button v-if="editable" @click="state = 'editing'" class="btn btn-secondary hover">Edit</button>

                        <button v-if="user == author && !editable" class="btn btn-danger hover_d" @click.prevent="remove">Delete</button>
                    </div>
                    <div class="content">{{body}}</div>
                </div>
            </div>
            <div v-if="show" class="answer">
                <textarea placeholder="reply"
                    @keydown="typing"
                    v-model="newReply"
                    :id="`reply_${comment.id}`"
                    class="form-control">
                </textarea>
                <button class="btn btn-primary" @click.prevent="saveReply">
                    Reply
                </button>
            </div>
        </div>
        
        <div v-if="state === 'editing'">
            <EditComponent 
                :comment="comment"
                @reset-edit="resetEdit"
                @save-edit="saveEdit"
                 />
        </div> 
        <div v-if="comment.replies.length > 0">
            <button v-if="length > 0" class="btn btn-primary" @click="findLen">More</button>
            <button v-if="length <= 0 && comment.replies.length > 5" class="btn btn-primary" @click="length = comment.replies.length - 5">Less</button>
            <div v-for="reply in comment.replies.slice(length, comment.replies.length)" :key="reply.id" class="reply">
                <ReplyComponent :comment="reply" :user="user" @reply-answer="replyAnswer" :author="author" />
            </div>
        </div>
    </div>
</template>

<script>
    import EditComponent from './EditComponent.vue';
    import ReplyComponent from './ReplyComponent.vue';
    import Event from '../../event.js';
    
    export default {
        props: {
            comment: {
                required: true,
                type: Object,
            },
            user: {
                required: true,
                type: Number,
            },
            author: {
                required: true,
                type: Number
            }
        },
        data() {
            return {
                state: 'default',
                body: null,
                show: false,
                newReply: '',
                length: 0
            }
        },
        methods: {
            
            resetEdit() {
                this.state = 'default';
            },

            saveEdit(data) {
                this.state = 'default';

                if(data.id == this.comment.id) {
                    this.body = data.comment;
                    this.comment.edit = true;

                    axios.post('/comment/edit', {'comment': data.comment, 'comment_id': this.comment.id})
                        .then(function(response) {
                            // console.log('edit', response.data);
                        });
                }
            },
            typing(e) {
                if(e.keyCode === 13 && !e.shiftKey) {
                    e.preventDefault();
                    this.saveReply();
                }        
            },
            saveReply() {
                if(this.newReply.length > 0) {
                    const that = this;
                    axios.post('/reply', {'comment': this.newReply, 'user_id': this.user, 'post_id': this.comment.post_id, 'reply_id': this.comment.id})
                        .then(function(response) {
                            that.comment.replies.push(response.data);
                        });
                    
                    this.newReply = '';
                }
            },
            answerShow() {
                this.show = !this.show;
                this.newReply = '@' + this.comment.user.name + ', ';
                this.$nextTick(() => { 
                    let id = "#reply_" + this.comment.id;      
                    window.$(id).focus();     
                });
            },
            replyAnswer(data) {
                this.show = !this.show;
                this.newReply = '@' + data.name + ', ';
                this.$nextTick(() => {  
                    let id = "#reply_" + this.comment.id;      
                    window.$(id).focus();     
                });
            },
            findLen() {
                this.length = this.length - 5;
                if(this.length < 0) this.length = 0;
            },
            remove() {
                Event.$emit('delete-edit', {
                    'id': this.comment.id
                });
            }
        },
        mounted() {
            this.body = this.comment.comment;
            this.length = this.comment.replies.length - 5;
            if(this.length < 0) this.length = 0;
        },
        computed: {
            editable() {
                if(this.comment.user) {
                    return this.user === this.comment.user.id;
                } else {
                    return false;
                }
            }
        },
        components: {EditComponent, ReplyComponent}
    }
</script>

<style lang="scss" scoped>
.comments-app {
    margin: 5px 0;
    textarea {
        resize: none;
    }
    .head {
        display: flex;
        justify-content: space-between;
        border-bottom: 1px dashed lightgreen;
        padding: 10px 20px 0px;
        line-height: 1em;
    }
    .content {
        padding: 10px 20px;
    }
    .reply {
        margin-left: 40px;
        border: 1px solid lightgrey;
        border-radius: 5px;
        background: white;
    }
    .comment {
        flex: 3;
    }
    .answer {
        display: flex;
    }
    .comment-box {
        display: flex;
        border: 1px solid lightgrey;
        border-radius: 5px;
        background: white;

        .hover, .hover_d {
            opacity: 0;
        }

        &:hover .hover, &:hover .hover_d {
            opacity: 1;
        }

        .img-avatar {
            width: 70px;
            height: 70px;
        }
    }
}

</style>