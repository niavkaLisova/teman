<template>
    <div>
        <div class="form-group">
            <label for="user_id">User ID</label>
            <input
                class="form-control"
                type="text"
                id="user_id"
                v-model="user.id"
                readonly>
        </div>

        <div class="form-group">
            <label for="name">Name</label>
            <input
                class="form-control"
                type="text"
                id="name"
                v-model="user.name"
                >
        </div>

        <div class="form-group">
            <label class="mr-sm-2" for="gender">Gender</label>
            <select v-model="user.gender" class="custom-select mb-2 mr-sm-2 mb-sm-0" id="gender">
                <option value="none">it doesn't matter</option>
                <option value="female">Female</option>
                <option value="male">Male</option>
            </select>
        </div>

        <div class="form-group">
            <label for="bday">Birthday</label>
            <input type="date" id="bday" v-model="user.bday" class="form-control">
        </div>

        <div class="form-group">
            <label for="country">Country</label>
            <input
                class="form-control"
                type="text"
                id="country"
                placeholder="Country"
                v-model="user.country">
        </div>

        <div class="form-group">
            <label for="city">City</label>
            <input
                class="form-control"
                type="text"
                id="city"
                placeholder="City"
                v-model="user.city">
        </div>

        <button type="button" @click="update" class="btn btn-primary">Update</button>
    </div>
</template>

<script>
    export default {
        props: {
            user: {
                required:true,
                type: Object
            },
        },
        methods: {
            update() {
                axios.post('/update/info', {"update": this.user})
                    .then(response => {
                        this.$awn.success('User Updated');
                    }).catch(err => {
                        console.log(err);
                    });
            }
        }
    }
</script>
