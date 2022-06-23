<template>
    <div>
        <div v-for="(apartment, index) in apartments" :key="index" class="apartment">
            {{ apartment.title }}
        </div>


    </div>
</template>


<script>
export default {
    name: "ApartmentStatistics",
    data: function () {
        return {
            apartments: [],

        }
    },
    methods: {
        getApartmentMessages(id) {
            axios.get('http://127.0.0.1:8000/api/apartments/' + id)
                .then((result) => {
                    console.log(result);
                    this.apartments = result.data;
                }).catch((error) => {
                    console.warn(error);
                })
        },

    },
    computed: {
    },
    created() {
        this.getApartmentMessages(this.$userId);
    },

}
</script>

<style lang="scss" scoped>
</style>
