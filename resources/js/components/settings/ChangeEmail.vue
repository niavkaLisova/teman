<template>
    <div>
        <div class="form-group">
            <label for="email">Email</label>
            <input class="form-control" id="email" type="email" v-model="email">
        </div>
        <button class="btn btn-primary" @click.prevent="changeEmail">Change Email</button>
    </div>
</template>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                email: ''
            }
        },
        methods: {
            changeEmail() {
                console.log('new email', this.email);
                axios.post('/changeEmail', {email: this.email})
                    .then(response => {
                        this.$awn.success('Email Updated');
                    }).catch(err => {
                        this.$awn.alert('Failed');
                        this.email = this.user.email;
                    });
            }
        },
        mounted() {
            this.email = this.user.email;
        }
    }
</script>
