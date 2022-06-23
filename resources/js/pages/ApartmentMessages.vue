<template>
    <div id="messages">
        <h1 class="my-title text-uppercase">I tuoi messaggi</h1>
        <div class="apartment-messages-container d-flex">
            <div class="apartment-messages-wrapper">
                <div class="d-flex apartment-messages" v-for="(apartment, index) in apartments" :key="'apartment' + index" @click="chooseApartment(index)">
                    <div class="apartment-image-wrapper">
                        <img class="apartment-message-image img-fluid" :src="(apartment.image.startsWith('https://')) ? apartment.image : '../../storage/'+ apartment.image" :alt="apartment.title">
                    </div>
                    <div class="apartment-message-content">
                        <h5 class="message-title text-capitalize">{{apartment.title}}</h5>
                        <h6 class="message-description">{{apartment.address}}</h6>
                        <div v-if="(apartment.messages.length > 0 )">
                            <p class="fw-bold">Messaggi : <span class="number-messages-enlighter">{{apartment.messages.length}}</span></p>
                        </div>
                        <div v-else>
                            <p class="fw-bold">Nessun Messaggio</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="apartment-chat">
                <div v-if="apartmentIndex != null">
                    <div class="apartment-single-message" v-for="(message, index) in apartments[apartmentIndex].messages" :key="'apartmentMessages' + index" >
                        <div class="message-chat-content">
                            <div class="sender-details">
                                <p>Inviato da:  <span class="message-sender">{{message.full_name}}</span></p>
                                <p>Email:  <span class="message-email">{{message.email}}</span></p>
                            </div>
                            <div class="message-text mt-3">
                                <p class="message-content">
                                    {{message.text}}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div v-if="apartments[apartmentIndex].messages.length == 0" class="info-message-wrapper">
                        <h1 class="info-message">Non ci sono messaggi per questo appartamento</h1>
                    </div>
                </div>
                <div v-else class="info-message-wrapper">
                    <h1 class="info-message">Seleziona un appartamento per vedere i suoi messaggi</h1>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    name:"ApartmentMessage",
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
                    this.orderApartments();
                }).catch((error)=>{
                    console.warn(error);
                })
        },
        chooseApartment(index){
            this.apartmentIndex = index;
        },
        orderApartments(){
            this.apartments.sort(function(a, b){return b.messages.length - a.messages.length});
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

}
</script>

<style lang="scss" scoped>
div#messages{
    .my-title{
        color: rgb(1, 11, 95);
        font-weight: 600;
        padding: 30px 0 10px 0;
        margin-left: 15vw;
    }
    background-color: rgb(245, 248, 255);
    div.apartment-messages-container{
        border-top: 2px solid white;
        padding-top: 20px;
        width: 75vw;
        margin: 0 auto;
        div.apartment-messages-wrapper{
            width: 33%;
            height: calc(100vh - 187px);
            overflow-y: scroll;
            div.apartment-messages{
                cursor: pointer;
                padding: 15px;
                background-color: white;
                margin: 0 20px 20px 20px;
                border-radius: 30px;
                div.apartment-image-wrapper{
                    img.apartment-message-image{
                        width: 120px;
                        height: 120px;
                        border-radius: 20px;
                        object-fit: fill;
                    }
                }
                div.apartment-message-content{
                    width: calc(100% - 150px);
                    padding-left: 20px;
                    .message-title{
                        color: rgb(1, 11, 95);
                        font-weight: 600;
                    }
                    .message-description{
                        color: rgb(137, 137, 141);
                    }
                    .number-messages-enlighter{
                        background-color: red;
                        color: white;
                        display: inline-block;
                        text-align: center;
                        padding-top: 2px;
                        width: 26px;
                        height: 26px;
                        border-radius: 50%;
                    }
                }
            }
        }
        div.apartment-chat{
            width: 67%;
            height: calc(100vh - 187px);
            overflow-y: scroll;
            div.info-message-wrapper{
                height: 50vh;
                display: flex;
                justify-content: center;
                h1.info-message{
                    align-self: center;
                    color: rgb(182, 179, 179)
                }
            }
            div.apartment-single-message{
                margin: 0 auto 20px auto;
                width: 97.5%;
                padding: 20px 35px 10px 35px;
                border-radius: 15px;
                background-color: rgb(219, 226, 245);
                div.message-chat-content{
                    div.sender-details{
                    p{
                        margin-bottom: 0.4rem;
                        padding-left: 10px;
                    }
                        .message-email,
                        .message-sender{
                            font-weight: 600;
                            font-size: 1rem;
                            margin-left: 1rem;
                        }
                    }
                    .message-text{
                        .message-content{
                            background-color: white;
                            border-radius: 10px;
                            padding: 10px;
                        }
                    }
                }
            }
        }
    }
    /* width */
    ::-webkit-scrollbar {
    width: 6px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
    box-shadow: inset 0 0 5px grey; 
    border-radius: 9px;
    }
    
    /* Handle */
    ::-webkit-scrollbar-thumb {
    background: lightgrey; 
    border-radius: 9px;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
    background: grey; 
    }
}
</style>