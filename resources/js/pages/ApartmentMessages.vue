<template>
    <div class="apartment-messages-wrapper">
        <div v-for="(messages, index) in apartmentMessages" :key="'apartmentMessages' + index" class="apartment-single-message">
            <h4>From : {{messages.full_name}}</h4>
            <h4>Email : {{messages.email}}</h4>
            <p>Content : {{messages.text}}</p>
            <p>Sent at : {{messages.created_at}}</p>
        </div>
    </div>
</template>

<script>
export default {
    name:"ApartmentMessage",
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
    created(){
        this.getApartmentMessages(7);
    }
}
</script>

<style lang="scss" scoped>

</style>