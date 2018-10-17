<template>
    <div>
        <button class="btn btn-outline-danger" @click="removeAccount">Delete Account</button>
        <button class="btn btn-outline-danger" @click="removeAllP">Delete All Portfolios and Posts</button>
    </div>
</template>

<script>
    export default {
        props: ['user'],
        methods: {
        	removeAllP() {
        		axios.delete('/delete/'+ this.user.id +'/works')
        			.then(response => {
        				this.$awn.success('OK');
        			})
        			.catch(err => {
        				this.$awn.alert('Failed');
        			});
        	},
        	removeAccount() {
        		axios.delete('/delete/'+ this.user.id +'/user')
        			.then(response => {
        				this.$awn.success('OK');
        				window.location.replace("/login");
        			})
        			.catch(err => {
        				this.$awn.alert('Failed');
        			});
        	}
        }
    }
</script>
