<template>
    <div class="info">
        <div v-if="user.gender == 'male'"><i class="fas fa-2x fa-mars"></i></div>
        <div v-if="user.gender == 'female'"><i class="fas fa-2x fa-venus"></i></div>
        <div v-if="user.gender == 'none'"><i class="fas fa-2x fa-genderless"></i></div>
        <div v-if="user.country || user.city">
            <span v-if="user.country">{{user.country}}
            </span>
            <span v-if="user.country && user.city">, </span>
            <span v-if="user.city">{{user.city}}
            </span>
        </div>

        <div v-if="year">{{year}}</div>
    </div>
</template>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                year: null
            }
        },
        mounted() {
            if(this.user.bday) {
                let bday = new Date(this.user.bday);
                let now = new Date(Date.now());
                let year = now.getFullYear() - bday.getFullYear();
                let month = now.getMonth() - bday.getMonth();
                if(month < 0) year--;
                if(month == 0 && (now.getDate() - bday.getDate()) < 0) {
                    year--;
                }
                this.year = year;
            }
        }
    }
</script>

<style lang="scss" scoped>
.info {

}
</style>
