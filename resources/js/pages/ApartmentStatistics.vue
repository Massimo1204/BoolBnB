<template>
    <div class="container-fluid w-100">
        {{apartment[0].title}}

    <LineChart datasetIdKey="Views" :data="viewsArray"/>
    </div>
</template>


<script>
import LineChart from '../components/LineChart.vue'
export default {
    name: "ApartmentStatistics",
    components:{
        LineChart
    },
    data: function () {
        return {
            apartment: [],
            viewsArray: [30,40,50,60,30,50,80]

        }
    },
    methods: {
        getApartmentStatistics(id) {
            axios.get('http://127.0.0.1:8000/api/apartments/' + id)
                .then((result) => {
                    this.apartment = result.data;
                    console.log(this.apartment);
                }).catch((error) => {
                    console.warn(error);
                })
        },

    },
    computed: {
    },
    created() {
        this.getApartmentStatistics(this.$route.params.id);
    },

}
</script>

<style lang="scss" scoped>
</style>
