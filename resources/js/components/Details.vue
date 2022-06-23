<template>
    <div class=" MyContainerr d-flex justify-content-around pt-3">
        <div class="card">
            <span>Superficie</span>
            <span>{{apartment.square_meters}} m2</span>
        </div>
        <div class="card">
            <span>Ospiti</span>
            <span>{{apartment.guests}}</span>
        </div>
        <div class="card">
            <span>Locali</span>
            <span>{{apartment.n_rooms}}</span>
        </div>
        <div class="card">
            <span>camere da letto</span>
            <span>{{apartment.n_bedrooms}}</span>
        </div>
        <div class="card">
            <span>letti</span>
            <span>{{apartment.n_beds}}</span>
        </div>
        <div class="card">
            <span>bagni</span>
            <span>{{apartment.n_bathrooms}}</span>
        </div>
    </div>
</template>

<script>
export default {
    name:"Details",
    props:['apartment'],
}
</script>

<style lang="scss" scoped>
    .card{
        padding: .5rem;
        box-shadow:0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        span{
            text-align: center;
        }
    }
    .MyContainerr{
        min-width: 419px;
    }
</style>