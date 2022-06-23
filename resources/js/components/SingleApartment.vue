<template>
<div class="col-3" v-if="apartment.visible==1">
    <div class="cardcontainer my-3">
        <router-link :to="{name: 'Show', params:{id: apartment.id}}" class="text-decoration-none">
            <div class="photo mx-auto position-relative">
                <img class="w-100" :src="(apartment.image.startsWith('https://')) ? apartment.image : '../../storage/'+ apartment.image" :alt="apartment.title">
                <div class="price position-absolute px-2 py-1 rounded-pill bg-light">
                    <span v-if="apartment.available">{{apartment.price}}	&euro;</span>
                    <span v-else class="text-danger">Non Disponibile</span>
                </div>
            </div>
            <h2 class="txt m-0 mt-3 title text-capitalize">{{apartment.title}}</h2>
            <div class="content address">
                <p>{{ apartment.address}}</p>
            </div>
        </router-link>
    </div>
</div>
</template>

<script>
export default {
name:"SingleApartment",
props: ['apartment']
}
</script>

<style scoped lang="scss">
@import "../../sass/_variables.scss";
.content{
    // max-height: 220px; 
    overflow: auto;
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
    font-size: 1.2rem;
}
</style>