<template>
    <div class="d-flex flex-column flex-wrap myCont">
        <div class="includedService me-3" v-for="service,index in includedServices" :key="index">
            <h5>{{service.name}}</h5>
        </div>
        <div class="notIncludedService me-3" v-for="service,i in services" :key="'A'+i">
            <h5 v-if="!(nIncludedServices.includes(service.name))"><del>{{service.name}}</del></h5>
        </div>
    </div>
</template>

<script>
import Axios from 'axios'
export default {
    name:"Services",
    props:['id'],
    data(){
        return {
            services:[],
            includedServices:[],
            nIncludedServices:[]
        }
    },
    methods:{
        getServices(){
            Axios.get('/api/services')
            .then(response=>{
                this.services=response.data;
                // console.log(this.services)
            })
        },
        getIncludedServices(){
            Axios.get('/api/apartment/service/'+ this.id)
            .then(response=>{
                this.includedServices=response.data;
                // console.log(this.includedServices)
                this.calcIncluded();
            });
            
        },
        calcIncluded(){
            this.includedServices.forEach((service) => {
                this.nIncludedServices.push(service.name);
            });
            // console.log(this.nIncludedServices);
        }
    },
    created(){
        this.getServices();
        this.getIncludedServices();
    },
}
</script>

<style lang="scss" scoped>
    .myCont{
        height: 50vh;
        // min-width: 490px;
    }
    @media(max-width: 767.98px) {
        .myCont {
            height: 60vh;
        }}
</style>