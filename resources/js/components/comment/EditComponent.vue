<template>
    <div>
        <textarea v-model="body"
                  placeholder="Update comment"
                  class="border form-control">
        </textarea>
        <div>
            <button class="btn btn-primary" @click="saveEdit">Update</button>
            <button class="btn btn-secondary" @click="resetEdit">Cancel</button>
            <button class="btn btn-danger" @click="deleteComment">Delete</button>
        </div>
    </div>
</template>

<script>
    import Event from '../../event.js';

    export default {
        props: {
            comment: {
                required: true,
                type: Object,
            },
        },
        data() {
            return {
                body: this.comment,
            }
        },
        methods: {
            resetEdit() {
                this.body = this.comment.comment;
                this.$emit('reset-edit');
            },
            saveEdit() {
                this.$emit('save-edit', {
                    'comment': this.body,
                    'id': this.comment.id
                });
            },
            deleteComment() {
                // console.log(this.comment.reply_id)
                if(this.comment.reply_id != 0) {
                    this.$emit('delete-reply');
                }

                Event.$emit('delete-edit', {
                    'id': this.comment.id
                });
            }
        },
        mounted() {
            this.body = this.comment.comment;
        }
    }
</script>

<style lang="scss" scoped>
    textarea {
        resize: none;
    }
</style>