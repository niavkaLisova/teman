<template>
    <div>
        <label for="passwordH" v-if="visible">Password</label>
        <label for="password" v-if="!visible">Password</label>
        <div class="input-group mb-3" v-if="visible">
            <input type="password" class="form-control" placeholder="Password" aria-label="Pasword" id="passwordH" aria-describedby="basic-addon1" v-model="password">
            <div class="input-group-append">
                <span @click="visible = !visible" class="input-group-text" id="basic-addon1"><i class="far fa-eye-slash"></i></span>
            </div>
        </div>
        <div class="input-group mb-3"  v-if="!visible">
            <input type="text" class="form-control" placeholder="Password" aria-label="Pasword" id="password" aria-describedby="basic-addon2" v-model="password">
            <div class="input-group-append">
                <span @click="visible = !visible" class="input-group-text" id="basic-addon2"><i class="far fa-eye"></i></span>
            </div>
        </div>
        <button class="btn btn-primary" @click.prevent="changePassword">Change Password</button>
    </div>
</template>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                password: '',
                visible: true
            }
        },
        methods: {
            changePassword() {
                axios.post('/changePassword', { password: this.password})
                    .then(response => {
                        this.$awn.success('Password Updated');
                        this.password = '';
                    }).catch(err => {
                        this.$awn.alert('Failed');
                        this.password = '';
                    });
            }
        }
    }
</script>
