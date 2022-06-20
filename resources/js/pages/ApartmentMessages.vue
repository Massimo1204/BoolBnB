<template>
    <div class="apartment-messages-wrapper">
        <h1 class="text-center border-bottom border-secondary pt-4 pb-5">I tuoi messaggi per questo appartamento</h1>
        <div v-for="(messages, index) in apartmentMessages" :key="'apartmentMessages' + index" class="apartment-single-message border-bottom border-secondary">
            <div class="apartment-message-content p-4">
                <h4>From : {{messages.full_name}}</h4>
                <h4>Email : {{messages.email}}</h4>
                <p>Content : {{messages.text}}</p>
                <p>Sent at : {{messages.created_at}}</p>
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
            apartmentMessages: [],
        }
    },
    methods: {
        getApartmentMessages(apartment){
            axios.get('http://127.0.0.1:8000/api/apartment/messages/'+ apartment)
                .then((result)=>{
                    this.apartmentMessages = result.data;
                }).catch((error)=>{
                    console.warn(error);
                })
        }
    },
    computed:{
        // getDate: function(date){
        //     newDate = date.slice(0, 10);
        //     return newDate;
        // },
    },
    created(){
        this.getApartmentMessages(7);
    }
}
</script>

<style lang="scss" scoped>
div.apartment-messages-wrapper{
    div.apartment-single-message{
        padding: 0 3rem;
    }
}
</style>