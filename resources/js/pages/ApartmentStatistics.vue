<template>
    <div class="container-fluid w-100">
        <h2 class="p-2 bold">{{apartment[0].title}}</h2>
        <div class="my-chart p-5">
            <h5 class="text-center mb-4">Views negli ultimi 12 mesi</h5>
            <LineChart datasetIdKey="Views" :data="viewsArray" color="blue" :labelMonth="labelMonth" />
        </div>
        <div class="my-chart p-5">
            <h5 class="text-center mb-4">Messaggi ricevuti negli ultimi 12 mesi</h5>
            <LineChart datasetIdKey="Messaggi" :data="messagesArray" color="black" :labelMonth="labelMonth" />
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
            labelMonth: [],

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

            const month1 = this.labelMonth[0];
            const month2 = this.labelMonth[1];
            const month3 = this.labelMonth[2];
            const month4 = this.labelMonth[3];
            const month5 = this.labelMonth[4];
            const month6 = this.labelMonth[5];
            const month7 = this.labelMonth[6];
            const month8 = this.labelMonth[7];
            const month9 = this.labelMonth[8];
            const month10 = this.labelMonth[9];
            const month11 = this.labelMonth[10];
            const month12 = this.labelMonth[11];
            let month1Count = 0;
            let month2Count = 0;
            let month3Count = 0;
            let month4Count = 0;
            let month5Count = 0;
            let month6Count = 0;
            let month7Count = 0;
            let month8Count = 0;
            let month9Count = 0;
            let month10Count = 0;
            let month11Count = 0;
            let month12Count = 0;


            views.forEach(view => {
                const date = new Date(view.date_time);
                let shortMonth = date.toLocaleString('it-it', { month: 'short' });
                if (month1.includes(shortMonth)) {
                    month1Count++
                }
                else if (month2.includes(shortMonth)) {
                    month2Count++
                }
                else if (month3.includes(shortMonth)) {
                    month3Count++
                }
                else if (month4.includes(shortMonth)) {
                    month4Count++
                }
                else if (month5.includes(shortMonth)) {
                    month5Count++
                }
                else if (month6.includes(shortMonth)) {
                    month6Count++
                }
                else if (month7.includes(shortMonth)) {
                    month7Count++
                }
                else if (month8.includes(shortMonth)) {
                    month8Count++
                }
                else if (month9.includes(shortMonth)) {
                    month9Count++
                }
                else if (month10.includes(shortMonth)) {
                    month10Count++
                }
                else if (month11.includes(shortMonth)) {
                    month2Count++
                }
                else if (month12.includes(shortMonth)) {
                    month12Count++
                }
            });
            this.viewsArray.push(month1Count, month2Count, month3Count, month4Count, month5Count, month6Count, month7Count, month8Count, month9Count, month10Count, month11Count, month12Count);
        },
        getMessagesArray(messages) {
            const month1 = this.labelMonth[0];
            const month2 = this.labelMonth[1];
            const month3 = this.labelMonth[2];
            const month4 = this.labelMonth[3];
            const month5 = this.labelMonth[4];
            const month6 = this.labelMonth[5];
            const month7 = this.labelMonth[6];
            const month8 = this.labelMonth[7];
            const month9 = this.labelMonth[8];
            const month10 = this.labelMonth[9];
            const month11 = this.labelMonth[10];
            const month12 = this.labelMonth[11];
            let month1Count = 0;
            let month2Count = 0;
            let month3Count = 0;
            let month4Count = 0;
            let month5Count = 0;
            let month6Count = 0;
            let month7Count = 0;
            let month8Count = 0;
            let month9Count = 0;
            let month10Count = 0;
            let month11Count = 0;
            let month12Count = 0;


            messages.forEach(message => {
                const date = new Date(message.created_at);
                let shortMonth = date.toLocaleString('it-it', { month: 'short' });
                if (month1.includes(shortMonth)) {
                    month1Count++
                }
                else if (month2.includes(shortMonth)) {
                    month2Count++
                }
                else if (month3.includes(shortMonth)) {
                    month3Count++
                }
                else if (month4.includes(shortMonth)) {
                    month4Count++
                }
                else if (month5.includes(shortMonth)) {
                    month5Count++
                }
                else if (month6.includes(shortMonth)) {
                    month6Count++
                }
                else if (month7.includes(shortMonth)) {
                    month7Count++
                }
                else if (month8.includes(shortMonth)) {
                    month8Count++
                }
                else if (month9.includes(shortMonth)) {
                    month9Count++
                }
                else if (month10.includes(shortMonth)) {
                    month10Count++
                }
                else if (month11.includes(shortMonth)) {
                    month2Count++
                }
                else if (month12.includes(shortMonth)) {
                    month12Count++
                }
            });
            this.messagesArray.push(month1Count, month2Count, month3Count, month4Count, month5Count, month6Count, month7Count, month8Count, month9Count, month10Count, month11Count, month12Count);
        },
        formatDate(date) {

            date = new Date(date);
            let year = date.getFullYear();
            let shortMonth = date.toLocaleString('it-it', { month: 'short' });

            return shortMonth + ' ' + year;
        }
        ,
        labelDate() {

            let now = new Date();

            for (let i = 12; i > 0; i--) {
                let newdate = now.setMonth(now.getMonth() - 1);
                this.labelMonth.unshift(this.formatDate(newdate));
            }
        }
    },
    computed: {
    },
    created() {
        this.getApartmentStatistics(this.$route.params.id);
        this.labelDate();
    },

}
</script>

<style lang="scss" scoped>
</style>
