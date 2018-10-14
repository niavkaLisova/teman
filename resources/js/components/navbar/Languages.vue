<template>
    <div class="languages-menu">
        <ul>
            <li v-for="lang in languages" :key="lang" @click="changeLang(lang)">{{lang}}
            </li>
        </ul>
    </div>
</template>
<script>

export default {
    data() {
        return {
            languages: ['en', 'ja']
        }
    },
    mounted() {
        console.log('Component mounted.')
    },
    methods: {
        changeLang(lang) {
            this.$i18n.locale = lang
        }
    }
}
    
</script>

<style lang="scss" scoped>
.languages-menu {
    ul {
        list-style: none;
        display: flex;
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        align-items: center;
        li {
            display: flex;
            margin: 0;
            width: 25px;
            height: 25px;
            cursor: pointer;
            margin: 0 5px;
            border-radius: 50%;
            border: 1px solid red;
            justify-content: center;
        }
    }
}
</style>