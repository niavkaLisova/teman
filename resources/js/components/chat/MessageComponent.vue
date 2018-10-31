<template>
    <div class="message self">
        <strong class="user">{{ message.user.name }}</strong>
        <div class="body" v-html="message.body"></div>
        <span>{{message.created_at | moment("from", "now", true)}}</span>
        <hr>
        <!-- <div v-html="text"></div> -->
        <div v-html="display"></div>
    </div>
</template>

<script>
    import { EmojiIcon, filter } from 'vb-emoji'

    export default {
        props: ['message'],
        filters: {
            render: function (value) {
                let index = value.length;
                let end = 0;

                do {
                    index = value.indexOf(':idx:');
                    if (index == -1) return value;
                    end = value.indexOf(':', index + 5);

                    let emClass = value.substring(index + 5, end);
   
                    value = value.replace(':idx:' + emClass + ':', '<i class="em em-' + emClass + '"></i>')
                } while(index < value.length);
                return value;
            }
        },
        computed: {
            text() {
                // let outHtml = this.$options.filters.render(this.message.body);
                let outHtml = 'zadowbalo'
                return outHtml;
            },
            display() {
                let render = this.$options.filters.render(this.message.body);
                return render;
            }
        }
}
    
</script>

<style>
    .user {
        font-weight: 800;
    }
    .body {
        margin-bottom: 0;
        white-space: pre-wrap;
    }
    .message {
        border-bottom: 1px solid #000000
    }
    .self {
        background-color: #f0f0f0;
        padding: 10px;
    }
    .emojione {
        width: 24px;
        height: 24px;
    }
</style>