<template>
    <div class="row">
        <form class="col-md-8">
            <div class="form-group">
                <input type="text" class="form-control" v-model="title">
                <vue-ckeditor 
                  v-model="content" 
                  :config="config" 
                  @blur="onBlur($event)" 
                  @focus="onFocus($event)"
                  />
            </div>
        </form>   
        <div class="col-md-4">
            <div class="form-group">
                <select class="custom-select" v-model="type">
                  <option value="draft">draft</option>
                  <option value="public">public</option>
                </select>
            </div>

            <div class="form-group">
                <select class="custom-select" v-model="portfolio">
                  <option v-for="item in portfolioList" :value="item.id">{{item.title}}</option>
                </select>
            </div>

            <div class="form-group">
                <button class="btn btn-primary" @click.prevent="saveTweet">
                    Create
                </button>
            </div>
        </div>     
    </div>
</template>
<script>
import Event from '../event.js';
import VueCkeditor from 'vue-ckeditor2';

export default {
    props: ['me'],
    data() {
        return {
            title: '',
            postData: {},
            type: 'draft',
            portfolio: '',
            portfolioList: [],
            content: '',
            config: {
                height: 300
            }
        }
    },
    methods: {
        saveTweet() {
            axios.post('/post/save', {body: this.content, title: this.title, type: this.type, portfolio_id: this.portfolio}).then(res => {
                console.log('res', res.data)
            }).catch(e => {
                console.log(e);
            });
            this.content = '';
            this.title = '',
            this.type = 'draft';
            this.portfolio = '';

            this.$awn.success("Post Created");
        },
        onBlur(editor) {
            // console.log(editor);
        },
        onFocus(editor) {
            // console.log(this.editor);
        }
    },
    mounted() {
        axios.post('/portfolio/info', {'user_id': this.me})
            .then(response => {
                this.portfolioList = response.data;
            });
    },
    components: { VueCkeditor }
}
</script>