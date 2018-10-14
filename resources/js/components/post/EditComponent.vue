<template>
    <div>
        <a :href="`/post/${id}`" class="btn">Back</a>
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

                <div class="card">
                    <div class="card-header">Image Upload</div>
                    <div class="card-body">
                        <div v-if="success != ''" class="alert alert-success" role="alert">
                          {{success}}
                        </div>

                        <div v-if="name != '' && name.length > 3" >
                          <img :src="`/images/${name}`" alt="image" class="img-fluid">
                        </div>

                        <form @submit="formSubmit" enctype="multipart/form-data">
                            <input type="file" class="form-control" v-on:change="onImageChange">
                            <button class="btn btn-success">Upload</button>
                        </form>
                    </div>
                </div>

                <div class="form-group">
                    <button class="btn btn-primary" @click.prevent="updatePost">
                        Update
                    </button>
                    <button class="btn btn-primary" @click.prevent="updateImage">
                        Remove Img
                    </button>
                    <button class="btn btn-primary" @click.prevent="destroyPost">
                        Destroy
                    </button>
                </div>
            </div>     
        </div>
    </div>
</template>
<script>
import Event from '../../event.js';
import VueCkeditor from 'vue-ckeditor2';

export default {
    props: ['id', 'me'],
    data() {
        return {
            title: '',
            postData: {},
            type: 'draft',
            content: '',
            name: '',
            image: '',
            success: '',
            portfolio: 1,
            portfolioList: [],
            config: {
                height: 300
            }
        }
    },
    mounted() {
        axios.post('/post/get', {id: this.id}).then((resp => {
            this.title = resp.data.title;
            this.type = resp.data.type;
            this.content = resp.data.body;
            this.name = resp.data.image;
            this.portfolio = resp.data.portfolio_id;
        }));

        axios.post('/portfolio/info', {'user_id': this.me})
            .then(response => {
                this.portfolioList = response.data;
            });
    },
    methods: {
        updatePost() {
            axios.post('/post/update', {body: this.content, title: this.title, type: this.type, id: this.id, portfolio_id: this.portfolio}).then(res => {
                this.$awn.success('Post Updated');
            }).catch(e => {
                console.log(e);
            });
        },
        updateImage() {
            let currentObj = this;

            axios.post('/post/image/update', {id: currentObj.id, image: '-'})
                .then(function(resp) {
                    currentObj.$awn.success('Image Deleted');
                    currentObj.success = 'Image Deleted';
                    currentObj.name = '';
                });
        },
        destroyPost() {
            axios.post('/post/destroy', {id: this.id}).then((resp => {
                window.location.replace('/home');
                this.$awn.success('Post Deleted');
            }));
        },
        onBlur(editor) {
            // console.log(editor);
        },
        onFocus(editor) {
            // console.log(this.editor);
        },
        onImageChange(e){
            this.image = e.target.files[0];
        },
        formSubmit(e) {
            e.preventDefault();
            let currentObj = this;

            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }

            let formData = new FormData();
            formData.append('image', this.image);

            axios.post('/post/image/store', formData, config)
                .then(function (response) {
                    currentObj.success = response.data.success;
                    currentObj.name = response.data.name;
                    axios.post('/post/image/update', {id: currentObj.id, image: currentObj.name})
                        .then(function(resp) {
                            console.log('up img', resp.data);
                        });
                }).catch(function (error) {
                    currentObj.output = error;
                });
        }

    },   
    components: { VueCkeditor }
}
</script>
