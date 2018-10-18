<template>
    <div class="container">
        <h2 class="head">Following list</h2>
        <div v-for="item in list" class="following-list">
            <div class="item">
                <span v-html="item.user.ProfileLink"></span> 
                <div :style="{backgroundImage: 'url(/storage/user/' + item.user.avatar + ')'}" class="avatar">
                </div>
            </div>  
        </div>
          <infinite-loading @infinite="infiniteHandler">
                <span slot="no-more">
                    There is no more:(
                </span>
          </infinite-loading>
    </div>
</template>

<script>
    import InfiniteLoading from 'vue-infinite-loading';

    export default {
        props: ['user_id'],
        data() {
            return {
                list: [],
                current_page: 1
            };
        },
        methods: {
            infiniteHandler($state) {
                axios.get('/following/' + this.user_id + '/list/' + this.current_page)
                    .then(({ data }) => {
                        if (data.data.length) {
                            this.list = this.list.concat(data.data);
                            this.current_page = data.current_page + 1;
                            $state.loaded();
                        } else {
                            $state.complete();
                        }
                    });
            },
        },
        components: {
            InfiniteLoading,
        },
    }
</script>

<style lang="scss" scoped>
.head {
    text-align: center;
}

.following-list {
    display: flex;
    flex-direction: column;
    align-items: center;

    .item {
        background: white;
        padding: 1em 2em;
        margin: .5em 0;
        border-radius: 4px;
        border: 1px solid lightgray;
        span {
            display: flex;
            justify-content: center;
        }
    }

    .avatar {
        width: 100px;
        height: 100px;
        background-size: cover;
        border-radius: 3px;
    }
}

</style>