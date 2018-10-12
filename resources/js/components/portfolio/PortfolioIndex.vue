<template>
    <div>
        <h2>Portfolios</h2>
        <div v-for="(portfolio, index) in portfolios" :key="portfolio.id">
            <a :href="`/users/${portfolio.users.name}`">{{portfolio.users.name}}</a> | <a :href="`/portfolio/${portfolio.id}/list`">{{portfolio.title}}</a> | {{ portfolio.posts.length }} work<span v-if="portfolio.posts.length > 1">s</span>
            <div  v-if="portfolio.describe">{{portfolio.describe}}</div>
            <div class="input-group" v-if="me != 0 && me == user_id">
                <a class="btn btn-secondary" :href="`/portfolio/${portfolio.id}/edit`">Edit</a>
                <button class="btn btn-danger" @click="remove(portfolio.id, index)">Delete</button>
            </div>
        </div>
    </div>
</template>
<script>

export default {
    props: ['user_id', 'me'],
    data() {
        return {
            portfolios: []
        }
    },
    mounted() {
        if(this.user_id != 0) {
            axios.post('/portfolio/info', {'user_id': this.user_id})
                .then(response => {
                    this.portfolios = response.data;
                })
        }
    },
    methods: {
        remove(id, index) {
            axios.delete('/portfolio/' + id)
                .then(response => {
                    console.log('deleted', index);
                    this.portfolios.splice(index, 1);
                })
        }
    }
}
</script>