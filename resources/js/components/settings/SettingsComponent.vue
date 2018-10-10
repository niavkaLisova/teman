<template>
    <div class="row">
        <div class="col-md-4">
            <ul>
                <li @click="changeActive(1)">User info</li>
                <li @click="changeActive(2)">Chage Password</li>
                <li @click="changeActive(3)">Change Email</li>
                <li @click="changeActive(4)">Change Avatr</li>
                <li @click="changeActive(5)">Dele6e Acount</li>
            </ul>
        </div>
        <div class="col-md-8">
            <h2>Settings</h2>
            <div v-if="itemActive == 1"><UserInfo :user="user" /></div>
            <div v-if="itemActive == 2"><ChangePassword :user="user" /></div>
            <div v-if="itemActive == 3"><ChangeEmail :user="user" /></div>
            <div v-if="itemActive == 4">Change Avatar</div>
            <div v-if="itemActive == 5">Delete Acount</div>
        </div>
    </div>
</template>

<script>
    import UserInfo from './UserInfo.vue';
    import ChangePassword from './ChangePassword.vue';
    import ChangeEmail from './ChangeEmail.vue';
 
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
        components: {UserInfo, ChangePassword, ChangeEmail}
    }
</script>
