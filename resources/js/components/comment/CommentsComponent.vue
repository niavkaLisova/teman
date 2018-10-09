<template>
    <div class="comments-app container">
    	<div class="composer">
	        <textarea placeholder="Add a comment"
	        	@keydown="typing"
	        	v-model="newComment"
	        	v-if="user != 0"
	            class="form-control">
	  		</textarea>
	  		<button v-if="user != 0" class="btn btn-primary" @click.prevent="saveComment">Comment</button>
	  	</div>
		<div v-for="comment in comments.data" :key="comment.id">
			<CommentComponent :comment="comment" :user="user" :author="author"/>
		</div>
		<pagination :data="comments" @pagination-change-page="getResults"></pagination>
 
    </div>
</template>

<script>
	import CommentComponent from './CommentComponent';
	import Event from '../../event.js';

    export default {
    	props: {
    		user: {
		    	required: true,
		        type: Number,
		    },
		    id: {
		    	required: true,
		    	type: Number
		    },
		    author: {
		    	required: true,
		    	type: Number
		    }
    	},
        data() {
            return {
            	newComment: '',
            	comments: {}
          }
        },
        methods: {
        	typing(e) {
                if(e.keyCode === 13 && !e.shiftKey) {
                    e.preventDefault();
                    this.saveComment();
                }        
            },

            saveComment() {
            	if(this.newComment.length > 0) {

				    axios.post('/comments', {'comment': this.newComment, 'user_id': this.user, 'post_id': this.postId})
		            	.then((response) => {
		            		if(this.comments.current_page == this.comments.last_page)
		            			this.comments.data.push(response.data);
		            	});
				    
				    this.newComment = '';
				}
			},
			getResults(page = 0) {
				const that = this;

				axios.get('/comments/' + this.postId +'/' + page)
					.then(response => {
						that.comments = response.data;
					});
			}
        },
        mounted() {
        	this.postId = this.id;
        	const that = this;
        	this.getResults();

        	Event.$on('delete-edit', function(data) {
                let index = that.comments.data.findIndex((element) => {
                    return element.id === data.id;
                });

                if(index != -1)
                	that.comments.data.splice(index, 1);

                axios.post('/comment/delete', {'comment_id': data.id})
	            	.then(function(response) {
	            		// console.log('deleted', response.data); 
	            	});
            })
        },
        components: {CommentComponent}
    }
</script>

<style lang="scss" scoped>
.comments-app {
	display: flex;
	flex-direction: column;
	.composer {
		display: flex;
		textarea {
			resize: none;
		}
	}
}
</style>