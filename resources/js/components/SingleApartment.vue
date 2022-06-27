<template>
<div class=" col-sm-12 col-md-6 col-lg-4 col-xl-3" v-if="apartment.visible==1">
    <div class="cardcontainer position-relative my-3">
        <router-link :to="{name: 'Show', params:{id: apartment.id}}" class="text-decoration-none">
            <div class="photo mx-auto position-relative">
                <div v-show="isLoaded == true" v-for="( picture , index ) in apartmentImages" :key="'apartment-images' + index" class="img-wrapper">
                    <img 
                        v-if="counter == index" 
                        @mouseover="setOnSwipeButtons" 
                        @mouseleave="setOffSwipeButtons" 
                        :src="(picture.startsWith('https://')) ? picture : '../../storage/'+ picture" 
                        :alt="apartment.title"
                    >
                </div>
                <div v-if="isLoaded == false" class="photo d-flex justify-content-center align-items-center">
                    <Loader/>
                </div>
                <div class="price position-absolute px-2 py-1 rounded-pill bg-light">
                    <span v-if="apartment.available">{{apartment.price}}	&euro;</span>
                    <span v-else class="text-danger">Non Disponibile</span>
                </div>
            </div>
            <h3 class="txt m-0 mt-3 title text-capitalize">{{apartment.title}}</h3>
            <div class="content address-wrapper">
                <p class="apartment-address fs-5">{{ apartment.address}}</p>
            </div>
        </router-link>
        <div v-show="showSwipeButtons == true" class="my-previous position-absolute" @click="swipePrevious">
            <span class="my-prev-hook">
                <i class="fas fa-chevron-left"></i>
            </span>
        </div>
        <div v-show="showSwipeButtons == true" class="my-next position-absolute" @click="swipeNext">
            <span class="my-next-hook">
                <i class="fas fa-chevron-right"></i>
            </span>
        </div>
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
    props: [
        'apartment',
        'isLoaded'
    ],
    data: function(){
        return {
            apartmentImages: [],
            counter: 0,
            showSwipeButtons: false,
        }
    },
    methods: {
        swipePrevious (){
            if(this.counter>0 && this.counter<this.apartmentImages.length){
                this.counter--;
            }else if(this.counter <= 0){
                this.counter = this.apartmentImages.length-1;
            }
        },
        swipeNext(){
            if(this.counter>=0 && this.counter<this.apartmentImages.length-1){
                this.counter++;
            }else if(this.counter >= this.apartmentImages.length-1){
                this.counter = 0;
            }
        },
        getApartmentImages(){
            this.apartmentImages[0] = this.apartment.image;
            this.apartment.pictures.forEach(picture => {
                this.apartmentImages.push(picture.image);
                console.log(this.apartmentImages)
            });
        },
        setOnSwipeButtons(){
            this.showSwipeButtons = true;
        },
        setOffSwipeButtons(){
            this.showSwipeButtons = false;
        }
    },
    mounted(){
        this.getApartmentImages();
    }
}
</script>

<style scoped lang="scss">
@import "../../sass/_variables.scss";
.cardcontainer{
    max-height: 450px;
    div.my-previous,
    div.my-next{
        cursor: pointer;
        height: 30px;
        width: 30px;
        border-radius: 50%;
        padding: 3px 0 3px 10px;
        background-color: rgba(255, 255, 255, .9);
        z-index: 2;
        top: 115px;
    }
    div.my-previous{
        left: .5rem;
    }
    div.my-next{
        right: .5rem;
    }
}
.content{
    // max-height: 220px; 
    overflow: auto;
}
h3{
    color: $primary;
}
.photo{
    border-radius: 15px;
    div.img-wrapper{
        img{
            height: 250px;
            width: 100%;
            border-radius: 15px;
            object-fit: cover;
        }
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
.address-wrapper
{
    p.apartment-address{
        color: rgb(30, 30, 30);
    }
}
</style>