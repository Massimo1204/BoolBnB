<template>
<div class="col-4 mb-5 text-center">
    <div class="cardcontainer my-4">
    <p class="txt m-0">{{apartment.title}}</p>
    <div class="photo w-75 mx-auto">
        <img class="w-100" :src="apartment.image">
    </div>
    <div class="content border-bottom border-2">
        <p>{{ apartment.description}}</p>
    </div>
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
.cardcontainer{
    /* height: 400px; */
}
.content{
    height: 220px; 
    overflow: auto;
}
.photo{
    height: 250px;
    border-radius: 15px;
    img{
        height: 100%;
        border-radius: 15px;
    }
}
</style>