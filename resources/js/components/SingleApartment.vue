<template>
<div class=" col-sm-12 col-md-6 col-lg-4 col-xl-3" v-if="apartment.visible==1">
    <div class="cardcontainer my-3">
        <router-link :to="{name: 'Show', params:{id: apartment.id}}" class="text-decoration-none">
            <div v-if="isLoading == false" class="photo mx-auto position-relative">
                <img class="w-100" :src="(apartment.image.startsWith('https://')) ? apartment.image : '../../storage/'+ apartment.image" :alt="apartment.title">
                <div class="price position-absolute px-2 py-1 rounded-pill bg-light">
                    <span v-if="apartment.available">{{apartment.price}}	&euro;</span>
                    <span v-else class="text-danger">Non Disponibile</span>
                </div>
            </div>
            <div v-else class="photo d-flex justify-content-center align-items-center">
                <Loader/>
            </div>
            <h3 class="txt m-0 mt-3 title text-capitalize">{{apartment.title}}</h3>
            <div class="content address">
                <p class="fs-5">{{ apartment.address}}</p>
            </div>
        </router-link>
    </div>
</div>
</template>

<script>
import Loader from "../components/Loader.vue";

export default {
    name:"SingleApartment",
    components:{
        Loader,
    },
    data(){
        return{
            loading: null,
        }
    },
    props: [
        'apartment',
        'isLoading'
    ],
    // watch:{
    //     isLoading: function(newLoad){
    //         if(newLoad == true){
    //             this.loading = true;
    //             console.log('sono tre');
    //         }else{
    //             this.loading = false;
    //         }
    //     }
    // }
}
</script>

<style scoped lang="scss">
@import "../../sass/_variables.scss";
.cardcontainer{
    max-height: 450px;
}
.content{
    // max-height: 220px; 
    overflow: auto;
}
h3{
    color: $primary;
}
p{
    color: black;
}
.photo{
    height: 250px;
    border-radius: 15px;
    img{
        height: 100%;
        border-radius: 15px;
        object-fit: cover;
    }
    .price{
        color: $text-color;
        bottom: 0.5rem;
        left: .6rem;
    }
}
    .title:hover{
        color:$primary
    }
.address
{
    color: $light-grey;
}
</style>