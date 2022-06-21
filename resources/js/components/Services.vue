<template>
    <div class="d-flex flex-column flex-wrap myCont ">
        <div class="includedService" v-for="service,index in includedServices" :key="index">
            <h4>{{service.name}}</h4>
        </div>
        <div class="includedService" v-for="service,i in services" :key="'A'+i">
            <h4>{{service.name}}</h4>
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
            });
            
        },
        calcIncluded(){
            // this.includedServices.forEach((service) => {
                //     this.nIncludedServices.push(service.name);
            // });
            // const propertyValues = JSON.parse(this.includedServices);
            // for (let i = 0; i < propertyValues.length; i++){
            //     this.nIncludedServices.push(propertyValues[i].name);
            //     console.log(propertyValues[i].name);
            // }
            // console.log(this.propertyValues);
        }
    },
    created(){
        this.getServices();
        this.getIncludedServices();
        // this.calcIncluded();
    },
}
</script>

<style lang="scss" scoped>
    .myCont{
        height: 35vh;
    }
</style>