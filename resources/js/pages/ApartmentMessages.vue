<template>
    <div class="row" id="messages">
        <div class="col-12">
            <h1 class="my-title text-uppercase">I tuoi messaggi</h1>
        </div>
        <div class="row apartment-messages-container d-flex">
            <div class="col-xl-5 col-lg-6 col-md-12 apartment-messages-wrapper">
                <div class="d-flex flex-column apartment-messages" v-for="(apartment, index) in apartments" :key="'apartment' + index" @click="chooseApartment(index)">
                    <div class="d-flex">
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
                    <div v-if="apartmentIndex != null && isSmall == true && isShowing[index] == true">
                        <div class="apartment-single-message" v-for="(message, index) in apartment.messages" :key="'apartmentMessages' + index" >
                            <div class="message-chat-content">
                                <div class="sender-details">
                                    <p>Inviato da:  
                                        <span class="message-sender">{{message.full_name}}</span>
                                        <span class="message-date float-end">{{getDate(message.created_at)}}</span>
                                    </p>
                                    <p>Email:  <span class="message-email">{{message.email}}</span></p>
                                </div>
                                <div class="message-text mt-3">
                                    <p class="message-content">
                                        {{message.text}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div v-if="apartment.messages.length == 0" class="info-message-wrapper">
                            <h1 class="info-message">Non ci sono messaggi per questo appartamento</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-7 col-lg-6 apartment-chat">
                <div v-if="apartmentIndex != null && isSmall == false">
                    <div class="apartment-single-message" v-for="(message, index) in apartments[apartmentIndex].messages" :key="'apartmentMessages' + index" >
                        <div class="message-chat-content">
                            <div class="sender-details">
                                <p>Inviato da:  
                                    <span class="message-sender">{{message.full_name}}</span>
                                    <span class="message-date float-end">{{getDate(message.created_at)}}</span>
                                </p>
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
            windowWidth: window.innerWidth,
            isSmall: false,
            isShowing: [],
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
            if(this.isShowing[index] == false){
                this.isShowing.splice(index, 1, true);
            }else{
                this.isShowing.splice(index, 1, false);
            }

            this.apartmentIndex = index;
            this.windowWidth = window.innerWidth;

            if(this.windowWidth < 1000) {
                this.isSmall = true;
            }else{
                this.isSmall = false;
            }

            this.orderMessages(this.apartments[index].messages);
        },
        orderApartments(){
            this.apartments.sort(function(a, b){return b.messages.length - a.messages.length});
            this.createIsShowingArray();
        },
        orderMessages(messages){
            messages.sort(function(a, b){
            console.log(a.created_at);

                return b.created_at - a.created_at});
            console.log(messages);
            return messages;
        },
        createIsShowingArray() {
            for (let index = 0; index < this.apartments.length; index++) {
                this.isShowing[index] = false;
            }
        },
        getDate(date){
            let newDate =  date.slice(8, 10)+'/'+date.slice(5, 7)+'/'+date.slice(0, 4)+', '+date.slice(11,16);
            return newDate;
        },
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
        padding: 30px 0 10px 30px;
    }
    background-color: rgb(245, 248, 255);
    div.apartment-messages-container{
        border-top: 2px solid white;
        padding-top: 20px;
        div.apartment-messages-wrapper{
            height: calc(100vh - 187px);
            overflow-y: scroll;
            div.apartment-messages{
                cursor: pointer;
                padding: 15px;
                background-color: white;
                margin: 0 20px 20px 20px;
                border-radius: 30px;
                box-shadow: 3px 5px rgb(248, 240, 240);
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
            height: calc(100vh - 187px);
            overflow-y: scroll;
            padding-right: 10px;
            }
        }
    }
    div.info-message-wrapper{
        height: 25vh;
        display: flex;
        justify-content: center;
        h1.info-message{
            align-self: center;
            color: rgb(182, 179, 179);
            text-align: center;
        }
    }
    div.apartment-single-message{
        margin: 20px auto 10px auto;
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
                .message-date{
                    color: rgb(168, 164, 164);
                    font-size: 0.8rem;
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
    ::-webkit-scrollbar {
    width: 6px;
    }
    ::-webkit-scrollbar-track {
    box-shadow: inset 0 0 5px grey; 
    border-radius: 9px;
    }
    ::-webkit-scrollbar-thumb {
    background: lightgrey; 
    border-radius: 9px;
    }
    ::-webkit-scrollbar-thumb:hover {
    background: grey; 
    }
}
</style>