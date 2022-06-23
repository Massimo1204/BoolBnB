<template>
    <div>
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
</style>