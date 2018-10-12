<template>
    <div class="portfolio" v-if="portfolio">
        <span class="title">{{portfolio.title}}</span> | <a :href="`/users/${portfolio.users.name}`">{{portfolio.users.name}}</a> | {{portfolio.posts.length}} work<span v-if="portfolio.posts.length > 1">s</span>
        <div  class="describe" v-if="portfolio.describe">{{portfolio.describe}}</div>

        <div v-for="work in portfolio.posts">
            <h4 class="title"><a :href="`/post/${work.id}`">{{work.title}}</a></h4>
            {{work.type}} | {{ work.createdDate }} | {{ work.view_count }} view 
            <div class="cut" v-html="work.body"></div>
        </div>
    </div>
</template>
<script>

export default {
    props: ['id'],
    data() {
        return {
            portfolio: null
        }
    },
    mounted() {
        axios.post('/portfolio/showInfo', {'id': this.id})
            .then(response => {
                this.portfolio = response.data;
            })
    }
}
</script>

<style lang="scss" scoped>
.portfolio {
    .title {
        font-weight: bold;
        font-size: 1.2em;
    }
    .describe {

    }

    .cut {
        display: block;
        display: -webkit-box;
        max-width: 100%;
        height: 70px;
        margin: 0 auto;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
}    
</style>
