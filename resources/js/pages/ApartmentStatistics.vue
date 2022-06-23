<template>
    <div class="container-fluid w-100">
        <div class="my-chart p-5">
            <LineChart datasetIdKey="Views" :data="viewsArray" color="blue"/>
        </div>
        <div class="my-chart p-5">
            <LineChart datasetIdKey="Messaggi" :data="messagesArray" color="black"/>
        </div>
    </div>
</template>


<script>
import LineChart from '../components/LineChart.vue'
export default {
    name: "ApartmentStatistics",
    components: {
        LineChart
    },
    data: function () {
        return {
            apartment: [],
            views: [],
            viewsArray: [],
            messages: [],
            messagesArray: [],

        }
    },
    methods: {
        getApartmentStatistics(id) {
            axios.get('http://127.0.0.1:8000/api/apartments/' + id)
                .then((result) => {
                    this.apartment = result.data;
                    this.views = result.data[0].views;
                    this.getViewsArray(this.views);
                    this.messages = result.data[0].messages;
                    this.getMessagesArray(this.messages);
                }).catch((error) => {
                    console.warn(error);
                })
        },
        getViewsArray(views) {
            let lun = 0;
            let mar = 0;
            let mer = 0;
            let gio = 0;
            let ven = 0;
            let sab = 0;
            let dom = 0;
            views.forEach(view => {
                const day = new Date(view.date_time);
                switch (day.getDay()) {
                    case 0:
                        dom++;
                        break;
                    case 1:
                        lun++;
                        break;
                    case 2:
                        mar++;
                        break;
                    case 3:
                        mer++;
                        break;
                    case 4:
                        gio++;
                        break;
                    case 5:
                        ven++;
                        break;
                    case 6:
                        sab++;
                }
            });
            this.viewsArray.push(lun,mar,mer,gio,ven,sab,dom);
        },
         getMessagesArray(messages) {
            let lun = 0;
            let mar = 0;
            let mer = 0;
            let gio = 0;
            let ven = 0;
            let sab = 0;
            let dom = 0;
            messages.forEach(message => {
                const day = new Date(message.created_at);
                switch (day.getDay()) {
                    case 0:
                        dom++;
                        break;
                    case 1:
                        lun++;
                        break;
                    case 2:
                        mar++;
                        break;
                    case 3:
                        mer++;
                        break;
                    case 4:
                        gio++;
                        break;
                    case 5:
                        ven++;
                        break;
                    case 6:
                        sab++;
                }
            });
            this.messagesArray.push(lun,mar,mer,gio,ven,sab,dom);
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
