<template>
    <div>
        <h1 class="text-center border-bottom border-secondary pt-4 pb-5 m-0">I tuoi messaggi</h1>
        <div class="apartment-messages-container d-flex">
            <div class="apartment-messages-wrapper">
                <div class="d-flex apartment-messages" v-for="(apartment, index) in apartments" :key="'apartment' + index" @click="chooseApartment(index)">
                    <div class="apartment-image-wrapper">
                        <img class="apartment-message-image img-fluid" :src="(apartment.image.startsWith('https://')) ? apartment.image : '../../storage/'+ apartment.image" :alt="apartment.title">
                    </div>
                    <div class="apartment-message-content">
                        <h5>Nome : {{apartment.title}}</h5>
                        <h6>Indirizzo : {{apartment.address}}</h6>
                        <h5>Messaggi : {{apartment.messages.length}}</h5>
                    </div>
                </div>
            </div>
            <div class="apartment-chat">
                <div v-if="apartmentIndex != null">
                    <div class="apartment-single-message" v-for="(message, index) in apartments[apartmentIndex].messages" :key="'apartmentMessages' + index" >
                        <div class="message-chat-content">
                            <div class="message-sender border-bottom border-secondary">
                                <h5>Inviato da: {{message.full_name}}</h5>
                                <h5>Email: {{message.email}}</h5>
                            </div>
                            <div class="message-text mt-3">
                                <h5 class="mb-3">Messaggio: </h5>
                                <p>
                                    {{message.text}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
        getUser(){
            axios.get('http://127.0.0.1:8000/api/user')
                .then((result)=>{
                    console.log(result);
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
        this.getApartmentMessages(1);
        this.getUser();

    },
    mounted() {
    }
}
</script>

<style lang="scss" scoped>
div.apartment-messages-container{
    div.apartment-messages-wrapper{
        width: 33%;
        div.apartment-messages{
            padding: 10px;
            border-bottom: solid black 1px;
            div.apartment-image-wrapper{
                img.apartment-message-image{
                    width: 120px;
                    height: 120px;
                    object-fit: fill;
                }
            }
            div.apartment-message-content{
                width: calc(100% - 140px);
                padding-left: 10px;
            }
        }
    }
    div.apartment-chat{
        border-left: 1px solid black;
        width: 67%;
        div.apartment-single-message{
            margin: 20px auto 0 auto;
            height: 200px;
            width: 90%;
            padding: 10px;
            border: 1px solid black ;
            border-radius: 15px;
        }
    }
}
</style>