<template>
    <div class="my-container">
        <router-view></router-view>
    </div>
</template>

<script>
export default {

}
</script>

<style scoped>
.my-container{
    /* background-color: rgba(255, 255, 255, .85); */
    /* border-bottom-left-radius: 15px;
    border-bottom-right-radius: 15px;
    overflow-y : scroll;
    height: calc(100vh - 76px - 2rem); */
    min-width: 375px;
}

.my-container::-webkit-scrollbar{
    width: .5vw;
}
.my-container::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0);
}
.my-container::-webkit-scrollbar-thumb {
    background-color: rgba(103, 103, 103, 0.692) ;
    border-radius: 1.5rem;
    border: .3rem solid rgba(255, 255, 255, 0);
}

</style>