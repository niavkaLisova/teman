<template>
    <div class="comments-app" v-if="body && visible">
        <div v-if="state === 'default'">
            <div class="comment-box">
                <img v-if="comment.user" class="mr-3 img-avatar" :src="`/storage/user/${comment.user.avatar}`" />
                <div class="comment">
                    <div class="head">
                        <h6><span v-if="comment.user" v-html="comment.user.ProfileLink"></span> <span v-if="!comment.user">user deleted</span> | {{ comment.createdDate }} <span v-if='comment.edit'> | edited</span><span @click="replyAnswer" v-if="user != 0"> | answer</span></h6>
                        <button v-if="editable" @click="state = 'editing'" class="btn btn-secondary">Edit</button>

                        <button v-if="user == author && !editable" class="btn btn-danger" @click.prevent="remove">Delete</button>
                        </div>
                    <div class="content">{{body}}</div>
                </div>
            </div>
        </div>

        <div v-if="state === 'editing'">
            <EditComponent 
                :comment="comment"
                @reset-edit="resetEdit"
                @save-edit="saveEdit"
                @delete-reply="deleteReply"
                 />
        </div> 
    </div>
</template>

<script>
    import EditComponent from './EditComponent.vue';

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
                visible: true
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

            deleteReply() {
                this.visible = false;
            },

            replyAnswer() {
                this.$emit('reply-answer', {"name": this.comment.user.name});
            },

            remove() {
                this.deleteReply();
                axios.post('/comment/delete', {'comment_id': this.comment.id})
                    .then(function(response) {
                        // console.log('deleted', response.data); 
                    });
            }
        },
        mounted() {
            const that = this;
            this.body = this.comment.comment;

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
        components: {EditComponent}
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
    .comment-box {
        display: flex;
        border: 1px solid lightgrey;
        border-radius: 5px;
        background: white;

        .img-avatar {
            width: 70px;
            height: 70px;
        }
    }
    .answer {
        display: flex;
    }
}

</style>