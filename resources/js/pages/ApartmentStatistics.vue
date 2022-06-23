<template>
    <div>
        statistic

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
            axios.get('http://127.0.0.1:8000/api/apartment/messages/' + id)
                .then((result) => {
                    this.apartments = result.data;
                    this.orderApartments();
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
