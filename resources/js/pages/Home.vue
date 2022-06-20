<template>
    <div class="row">
        <SingleApartment v-for="(apartment,index) in apartments" :key="index" :apartment="apartment"/>
        <div class="col-12 d-flex justify-content-between mt-3">
            <div v-if="pagination.current_page == 1"></div>
            <button class="btn btn-outline-primary" @click="getApartments(pagination.current_page - 1)" v-if="pagination.current_page > 1">prev</button>
            <h5>Pagina: {{pagination.current_page}}</h5>
            <button class="btn btn-outline-primary" @click="getApartments(pagination.current_page + 1)" v-if="pagination.current_page < pagination.last_page">next</button>
        </div>
    </div>
</template>

<script>
import SingleApartment from '../components/SingleApartment.vue'
export default {
    name:"home",
    components:{
        SingleApartment
    },
    data(){
        return{
        apartments:[],
        pagination:{},
        }
    },
    methods:{
        getApartments(page){
        axios.get(`http://localhost:8000/api/apartments?page=${page}`)
        .then(resp => {
            this.apartments = resp.data.data;
            const { current_page, last_page } = resp.data;
            this.pagination = {current_page : current_page, last_page : last_page};
        })
        .catch((error)=>{
        console.warn(error);
        })
        }
    },
    created(){
        this.getApartments(1);
    }
    }
</script>

<style>

</style>