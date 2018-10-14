<template>
    <div class="portfolio" v-if="portfolio">
        <div class="box">
            <div  class="describe" v-if="portfolio.describe">{{portfolio.describe}}</div>
            <div>
                <div class="title">{{portfolio.title}}</div> 
                <div>
                    <a :href="`/users/${portfolio.users.name}`">{{portfolio.users.name}}</a> | {{portfolio.posts.length}} work<span v-if="portfolio.posts.length > 1">s</span>
                </div>
                <a :href="`/portfolio/${portfolio.user_id}`" class="btn btn-outline-secondary"> Porfolio</a>
                <a v-if="portfolio.users.id == me" href="/post/create" class="btn btn-outline-info">Create Post</a>

            </div>
        </div>

        <div v-for="work in portfolio.posts">
            <h4 class="title"><a :href="`/post/${work.id}`">{{work.title}}</a></h4>
            {{work.type}} | {{ work.createdDate }} | {{ work.view_count }} view 
            <div class="cut" v-html="work.body"></div>
        </div>
    </div>
</template>
<script>

export default {
    props: {
        id: {
            required: true,
            type: Number
        },
        me: {
            required: false,
            default: 0
        }
    },
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
    .box {
        display: flex;
    }
    .title {
        font-weight: bold;
        font-size: 1.2em;
    }
    .describe {
        flex: 2;
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
