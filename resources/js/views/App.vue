<template>
    <div class="main">
        <Main/>
    </div>
</template>

<script>
    import Main from '../components/Main';

    export default {
        name:"App",
        components:{
            Main,
        }
}
</script>

<style lang="scss">
        @import 'resources/sass/_variables.scss';

    h1,h2,h3,h4{
        color: $text-color;
    }
    .main{
        background-image: url("https://wallpapercave.com/wp/wp4432767.jpg");
        background-repeat: no-repeat;
        background-size: 100%;
        height: 92vh;
        padding-top:1rem;
        padding-bottom: 1rem;
    }
</style>