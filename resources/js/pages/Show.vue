<template>
    <div class="container-fluid">
        <div class="row w-100" v-if="apartment.visible">
            <div class="pics position-relative col-9 mx-auto d-flex gap-1">
                <img :src="apartment.image" class="w-50 rounded h-100" alt="">
                <div class="otherPics w-50 h-100 d-flex flex-column flex-wrap gap-1">
                    <img v-for="pic,index in pictures" :key="index" :src="pic.image" class="rounded">
                </div>
                <div class="price position-absolute px-2 py-1 bg-light rounded-pill">
                    <span>{{apartment.price}}	&euro;</span>
                </div>
            </div>
            <div class="col-7 mt-4">
                <h1>{{apartment.title}}</h1>
                <span id="apartment_address">{{apartment.address}}</span>
                <hr>
                <h3>Description</h3>
                <p>{{apartment.description}}</p>
            </div>
            <div class="col-7 mt-3">
                <h3>Detalis</h3>
                <Details :apartment="apartment"/>
                <h3 class="mt-5">Servizi</h3>
                <Services :id="id"/>
            </div>
            <div class="col-7 mt-4">
                <h3>Map</h3>
                <h3>Meet The Host</h3>
                <div class="hostCard mt-4 w-100 d-flex justify-content-between align-items-center p-3 rounded bg-white shadow">
                    <div class="d-flex justify-content-around align-items-center">
                        <img class="rounded-circle" :src="host.profile_picture" :alt="host.id">
                        <h4 class="m-0">{{host.first_name}} {{host.last_name}}</h4>
                    </div>
                    <button type="button" class="btn btn-outline-dark shadow-none">Contatta l'host</button>
                </div>
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
            host:[]
        }
    },
    methods:{
        getInfo(){
            Axios.get('/api/apartment/'+this.id)
            .then(response=>{
                this.apartment=response.data;
            this.getHost(this.apartment.user_id);
            })

        },
        getpics(){
            Axios.get('/api/apartment/pictures/'+this.id)
            .then(response=>{
                this.pictures=response.data;
            })
        },
        getHost(id){
            Axios.get('/api/apartment/host/'+id)
            .then(response=>{
                this.host=response.data[0][0];    
                // console.log(this.host);
            })
        }
    },
    created(){
        this.getInfo();
        this.getpics();
    },
}
</script>

<style lang="scss" scoped>

    @import 'resources/sass/_variables.scss';
    .container-fluid{
        background-color: $light-dark-background;
    }
        #apartment_address{
            color: $light-grey;
        }

    .pics{
        height: 50vh;
        width: 80vw;
        img, .otherPics img{
            object-fit: cover;
        }
        .otherPics{
            overflow-y: hidden;
            img{
                width: 49.5%;
                height: 49%;
            }
        }
        .otherPics::-webkit-scrollbar{
            height: 1.5vh;
        }
        .otherPics::-webkit-scrollbar-track {
            background: rgb(214, 214, 214);
            border-radius: 1rem;
        }
        .otherPics::-webkit-scrollbar-thumb {
            background-color: rgb(163, 163, 163) ;
            border-radius: 1rem;
            border: .15rem solid rgb(214, 214, 214);
        }
        .price{
            bottom: 0.3rem;
            left: 1rem;
        }
    }
    .row{
        padding: 3rem 10rem;
    }
    .hostCard{
        div{
            width: 17rem;
        }
        img{
            height: 5rem;
            width: 5rem;
            object-fit: cover;
        }
        h4{
            vertical-align: auto;
        }
    }

</style>