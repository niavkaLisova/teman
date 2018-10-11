<template>
    <div class="follow">
        <div v-if="check && user.id != auth">
            <div v-if="show"><button class="btn btn-danger" @click="noFollow">No Follow</button></div>
            <div v-else><button class="btn btn-success" @click="follow"> Follow</button></div>
        </div>
        
    </div>
</template>

<script>
    export default {
        props: ['check', 'auth', 'user', 'following'],
        data() {
            return {
                show: false
            }
        },
        mounted() {
            if(this.user.id != this.auth) {
                let show =this.following.find(user => {
                    return user.id == this.user.id;
                });
                if(show) {
                    this.show= true;
                }
            }
        },
        methods: {
            noFollow() {
                console.log('no follow');
                axios.post('/users/unfollow', {user: this.user})
                    .then(response => {
                        this.show = !this.show;
                        this.$awn.success('No follow');
                    }).catch(err => {
                        this.$awn.alert('Error');
                    })
            },
            follow() {
                console.log('follow');
                axios.post('/users/follow', {user: this.user.id})
                    .then(response => {
                        this.show = !this.show;
                        this.$awn.success('Follow');
                    }).catch(err => {
                        this.$awn.alert('Error');
                    })
            }
        }
    }
</script>
