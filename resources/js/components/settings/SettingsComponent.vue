<template>
    <div class="row">
        <div class="col-md-4">
            <ul>
                <li @click="changeActive(1)">User info</li>
                <li @click="changeActive(2)">Chage Password</li>
                <li @click="changeActive(3)">Change Email</li>
                <li @click="changeActive(4)">Change Avatar</li>
                <li @click="changeActive(5)">Dele6e Account</li>
            </ul>
        </div>
        <div class="col-md-8">
            <h2>Settings</h2>
            <div v-if="itemActive == 1"><UserInfo :user="user" /></div>
            <div v-if="itemActive == 2"><ChangePassword :user="user" /></div>
            <div v-if="itemActive == 3"><ChangeEmail :user="user" /></div>
            <div v-if="itemActive == 4"><ChangeAvatar :user="user"/></div>
            <div v-if="itemActive == 5"><DeleteComponent :user="user" /></div>
        </div>
    </div>
</template>

<script>
    import UserInfo from './UserInfo.vue';
    import ChangePassword from './ChangePassword.vue';
    import ChangeEmail from './ChangeEmail.vue';
    import ChangeAvatar from './ChangeAvatar.vue';
    import DeleteComponent from './DeleteComponent';
 
    export default {
        props: {
            user: {
                required:true,
                type: Object
            },
        },
        data() {
            return {
                itemActive: 1
            }
        },
        methods: {
            changeActive(item) {
                this.itemActive = item;
            }
        },
        components: {UserInfo, ChangePassword, ChangeEmail, ChangeAvatar, DeleteComponent}
    }
</script>
