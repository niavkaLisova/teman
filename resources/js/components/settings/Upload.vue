<template>
    <div class="card">
        <div class="card-header">Avatar Upload</div>
        <div class="card-body">
            <div v-if="success != ''" class="alert alert-success" role="alert">
              {{success}}
            </div>

            <form @submit="formSubmit" enctype="multipart/form-data">
                <input type="file" class="form-control" v-on:change="onImageChange">
                <button class="btn btn-success">Upload</button>
            </form>
        </div>
    </div>
</template>
<script>
import Event from '../../event.js';

export default {
    props: ['id'],
    data() {
        return {
            success: '',
            name: '',
            image: ''
        }
    },
    methods: {
        onImageChange(e){
            this.image = e.target.files[0];
        },
        formSubmit(e) {
            e.preventDefault();

            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }

            let formData = new FormData();
            formData.append('image', this.image);

            axios.post('/user/image/store', formData, config)
                .then(response => {
                    this.name = response.data.name;
                    axios.post('/user/image/update', {id: this.id, image: this.name})
                        .then(resp => {
                            this.success = response.data.success;
                            this.$awn.success('Avatar Updated');
                            this.$emit('change-avatar', {avatar: this.name});
                        }).catch(error => {
                            this.$awn.alert('Error');
                        });
                });
            }

    }
}
</script>