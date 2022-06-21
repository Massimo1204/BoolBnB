<template>
    <div>
        <h1 class="text-center border-bottom border-secondary pt-4 pb-5">I tuoi messaggi</h1>
        <div class="apartment-messages-container d-flex">
            <div class="apartment-messages-wrapper">
                <div class="d-flex apartment-messages" v-for="(apartment, index) in apartments" :key="'apartment' + index" @click="chooseApartment(index)">
                    <div class="apartment-image-wrapper">
                        <img class="apartment-message-image img-fluid" :src="apartment.image" :alt="apartment.title">
                    </div>
                    <div class="ps-3">
                        <h4>Nome : {{apartment.title}}</h4>
                        <h5>Indirizzo : {{apartment.address}}</h5>
                        <p>Messaggi : {{apartment.messages.length}}</p>
                    </div>
                </div>
            </div>
            <div class="apartment-chat">
                <div v-if="apartmentIndex != null">
                    <div class="apartment-single-message" v-for="(message, index) in apartments[apartmentIndex].messages" :key="'apartmentMessages' + index" >
                        <p>{{message.text}}</p>
                    </div>
                </div>
            </div>
            <!-- <div v-for="(messages, index) in apartments" :key="'apartmentMessages' + index" class="apartment-single-message border-bottom border-secondary">
                <div class="apartment-message-content p-4">
                    <h4>From : {{messages.full_name}}</h4>
                    <h4>Email : {{messages.email}}</h4>
                    <p>Content : {{messages.text}}</p>
                    <p>Sent at : {{messages.created_at}}</p>
                </div>
            </div> -->
        </div>
    </div>
</template>

<script>
export default {
    name:"ApartmentMessage",
    props:['apartment'],
    data: function() {
        return{
            apartments: [],
            apartmentIndex: null,
        }
    },
    methods: {
        getApartmentMessages(id){
            axios.get('http://127.0.0.1:8000/api/apartment/messages/'+ id)
                .then((result)=>{
                    this.apartments = result.data;
                    console.log(this.apartments)
                }).catch((error)=>{
                    console.warn(error);
                })
        },
        chooseApartment(index){
            this.apartmentIndex = index;
            console.log(index, this.apartments[index].messages);
        }
    },
    computed:{
        // getDate: function(date){
        //     newDate = date.slice(0, 10);
        //     return newDate;
        // },
    },
    created(){
        this.getApartmentMessages(this.$userId);
    },
    mounted() {
    }
}
</script>

<style lang="scss" scoped>
div.apartment-messages-container{
    div.apartment-messages-wrapper{
        div.apartment-messages{
            padding: 10px;
            border-bottom: solid black 1px;
            div.apartment-image-wrapper{
                img.apartment-message-image{
                    width: 150px;
                    height: 150px;
                    object-fit: fill;
                }
            }
        }
    }
}
</style>