<template>
    <div class="container ps-4">
        <router-view></router-view>
    </div>
</template>

<script>
export default {

}
</script>

<style scoped>
div{
    width: 100vw;
}
.container{
    background-color: rgba(255, 255, 255, .85);
    overflow: auto;
    height: 100%;
    border-radius: 15px;
    padding: 0;
    min-width: 375px;

}

</style>