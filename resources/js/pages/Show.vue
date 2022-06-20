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
        }
    },
    methods:{
        getInfo(){
            Axios.get('/api/apartment/'+this.id)
            .then(response=>{
                this.apartment=response.data;
            })
        }
    },
    created(){
        this.getInfo();
    }
}
</script>

<style>

</style>