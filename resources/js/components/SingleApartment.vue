<template>
<div class="col-4 mb-5 " v-if="apartment.visible==1">
    <div class="card-container my-3 px-5">
        <router-link :to="{name: 'Show', params:{id: apartment.id}}" class="text-decoration-none">
            <div class="photo mx-auto position-relative">
                <img class="w-100" :src="(apartment.image.startsWith('https://')) ? apartment.image : '../../storage/'+ apartment.image" :alt="apartment.title">
                <div class="price position-absolute px-2 py-2">{{apartment.price}} €</div>
            </div>
            <h2 class="txt m-0 title text-capitalize text-black">{{apartment.title}}</h2>
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
components:{

},
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
    }
    .price{
        background-color: $light-dark-background;
        border-radius: 50%;
        bottom: 1rem;
        left: 1rem;
    }
}
.address
{
    color: $medium-dark-background;
    font-size: 1.2rem;
}
</style>