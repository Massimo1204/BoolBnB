<template>
    <div class="container">
        <router-view></router-view>
    </div>
</template>

<script>
export default {

}
</script>

<style scoped>
.container{
    background-color: rgba(255, 255, 255, .85);
    overflow: auto;
    height: 100%;
    border-radius: 15px;
    padding: 0;
    min-width: 375px;
    height: 85.5vh;
}


.container::-webkit-scrollbar{
    width: .5vw;
}
.container::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0);
}
.container::-webkit-scrollbar-thumb {
    background-color: rgba(103, 103, 103, 0.692) ;
    border-radius: 1.5rem;
    border: .3rem solid rgba(255, 255, 255, 0);
}

</style>