<template>
    <div class="container-fluid">
        <div class="row" v-if="apartment.visible">
            <div class="pics col-9 mx-auto">
                <img :src="apartment.image" class="w-50" alt="">
                <img v-for="pic,index in pictures" :key="index" :src="pic.image" class="w-75 d-none" alt="">
                <div>
                    <span>{{apartment.price}}	&euro;</span>
                </div>
            </div>
            <div class="col-7 mt-5">
                <h1>{{apartment.title}}</h1>
                <span>{{apartment.address}}</span>
                <hr>
                <h3>Description</h3>
                <p>{{apartment.description}}</p>
                <h3>Detalis</h3>
                <Details :apartment="apartment"/>
                <h3>Servizi</h3>
                <Services :id="id"/>
                <h3>Map</h3>
                <h3>Meet The Host</h3>
            </div>
        </div>
        <h1 class="text-center mt-5" v-if="apartment.visible==0">Nothing To See Here</h1>
    </div>
</template>

<script>
import Axios from 'axios'
import Details from '../components/Details.vue';
import Services from '../components/Services.vue';
export default {
    name:'Show',
    components:{
        Details,
        Services
    },
    data(){
        return {
            id: this.$route.params.id,
            apartment:[],
            pictures:[],
        }
    },
    methods:{
        getInfo(){
            Axios.get('/api/apartment/'+this.id)
            .then(response=>{
                this.apartment=response.data;
            })
        },
        getpics(){
            Axios.get('/api/apartment/pictures/'+this.id)
            .then(response=>{
                this.pictures=response.data;
            })
        }

    },
    created(){
        this.getInfo();
        this.getpics();
    }
}
</script>

<style lang="scss" scoped>
    .pics{
        height: 50vh;
        width: 80vw;
    }
    .row{
        padding: 3rem 10rem;
    }

</style>