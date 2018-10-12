<template>
    <div class="form-component">
        <h2>New Portfolio</h2>
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
                    <button class="btn btn-primary" @click.prevent="save">
                        Create
                    </button>
                </div>
            </div>     
        </div>
    </div>
</template>
<script>

export default {
    data() {
        return {
            title: '',
            describe: ''
        }
    },
    methods: {
        save() {
            console.log('save', this.title, this.describe);

            axios.post('/portfolio/save', {title: this.title, describe: this.describe})
                .then(res => {
                    console.log('portfolio', res.data);
                    this.$awn.success("Portfolio Created");
                }).catch(e => {
                    this.$awn.alert("Name is not unique");
                });

            this.title = '';
            this.describe = '';
        }  
    }
}
</script>

<style lang="scss" scoped>
.form-component {
    textarea {
        resize: none;
    }
}
</style>