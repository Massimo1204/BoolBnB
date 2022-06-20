<template>
    <div>
        <div class="pics mx-auto">
            <img :src="apartment.image" class="w-50" alt="">
            <img v-for="pic,index in pictures" :key="index" :src="pic.image" class="w-75" alt="">
        </div>
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
</style>