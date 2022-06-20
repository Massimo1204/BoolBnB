<template>
    <div>
        
    </div>
</template>

<script>
import Axios from 'axios'

export default {
    name:'Show',
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
                console.log(this.apartment);
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

<style>

</style>