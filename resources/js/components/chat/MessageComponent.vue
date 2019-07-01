<template>
    <div :class="{unread: message.read == 0, message: true, self: true}" >
        <strong class="user">{{ message.user.name }}</strong>
        <div v-html="display"></div>
        <!-- <span>{{message.created_at | moment("from", "now", true)}}</span> -->
        <span>{{message.created_at }}</span>
        <hr>     
    </div>
</template>

<script>
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
    .unread {
        background-color: pink;
    }
</style>