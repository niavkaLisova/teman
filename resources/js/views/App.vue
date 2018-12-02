<template>
    <div class="container-fluid">
        <div class="row">

            <div class="col-md-4">
                <user-component :activeUsers="activeUsers" :chat_id="chat_id" :me="me"></user-component>
            </div>

            <div class="col-md-8">
                <router-view :me="me" ></router-view>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['activeUsers', 'chat_id', 'me']
    }
</script>