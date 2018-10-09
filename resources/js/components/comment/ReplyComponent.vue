<template>
    <div class="comments-app" v-if="body && visible">
        <div v-if="state === 'default'">
            <div class="comment">
                <div class="head">
                    <h6><a :href="`/users/${comment.user.name}`">{{comment.user.name}}</a> | {{ comment.createdDate }} <span v-if='comment.edit'> | edited</span><span @click="replyAnswer" v-if="user != 0"> | answer</span></h6>
                    <button v-if="editable" @click="state = 'editing'" class="btn btn-secondary">Edit</button>
                </div>
                <div class="content">{{body}}</div>
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
            }
        },
        mounted() {
            const that = this;
            this.body = this.comment.comment;

        },
        computed: {
            editable() {
                return this.user === this.comment.user.id;
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
    .comment {
        border: 1px solid lightgrey;
        border-radius: 5px;
        background: white;
    }
    .answer {
        display: flex;
    }
}

</style>