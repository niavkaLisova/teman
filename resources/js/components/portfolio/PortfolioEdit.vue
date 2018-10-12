<template>
    <div class="edit-container">
        <h2>Edit Portfolio</h2>
        <div class="row">
            <form class="col-md-8">
                <div class="form-group">
                    <input type="text" class="form-control" v-model="title" placeholder="Title">
                </div>

                <div class="form-group">
                    <textarea rows="5" class="form-control" v-model="describe" placeholder="describe"></textarea>
                </div>
            </form>   
            <div class="col-md-4">
                <div class="form-group">
                    <button class="btn btn-primary" @click.prevent="update">
                        Update
                    </button>
                </div>
            </div>     
        </div>
    </div>
</template>
<script>

export default {
    props: ['id'],
    data() {
        return {
            title: '',
            describe: ''
        }
    },
    methods: {
        update() {
            console.log('update')

            axios.put('/portfolio/' + this.id + '/update', {title: this.title, describe: this.describe})
                .then(res => {
                    console.log('portfolio', res.data);
                    this.$awn.success("Portfolio Updated");
                }).catch(e => {
                    this.$awn.alert("Something went wrong");
                });
        }  
    },
    mounted() {
        axios.post('/portfolio/showInfo', {'id': this.id})
            .then(response => {
                this.title = response.data.title;
                this.describe = response.data.describe;
            })
    }
}
</script>

<style lang="scss" scoped>
.edit-container {
    textarea {
        resize: none;
    }
}
</style>