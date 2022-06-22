<template>
<div>
    <div class="row">
        <div class="col-4 search">
            <label class="input-container closed">
                <div class="shadow"></div>
                <div class="center">
                    <input type="text" class="input" placeholder="Search" @keyup.enter="search" v-model="userSearch">
                </div>
                <div class="sticks" ></div>
            </label>
        </div>
    </div>
    <div class="row">
		<div class="col-12">
			<h1 class="ms-5 mt-4">In evidenza</h1>
		</div>
        <SingleApartment v-for="(apartment,index) in sponsoredApartments" :key="'sponsored'+ index" :apartment="apartment" />
		<div class="col-12">
			<h1 class="ms-5">Normali</h1>
		</div>
        <SingleApartment v-for="(apartment,index) in filterApartments" :key="index" :apartment="apartment" />
        <div class="col-12 d-flex justify-content-between my-3" v-if="apartmentsSearch == ''">
            <div v-if="pagination.current_page == 1"></div>
            <button class="btn btn-outline-primary" @click="getApartments(pagination.current_page - 1)" v-if="pagination.current_page > 1">prev</button>
            <h5>Pagina: {{pagination.current_page}}</h5>
            <button class="btn btn-outline-primary" @click="getApartments(pagination.current_page + 1)" v-if="pagination.current_page < pagination.last_page">next</button>
            <div v-if="pagination.current_page == last_page"></div>
        </div>
    </div>
</div>
</template>

<script>
import SingleApartment from '../components/SingleApartment.vue'

export default {
    name:"home",
    components:{
        SingleApartment
    },
    data(){
        return{
        apartments:[],
		sponsoredApartments:[],
        pagination:{},
        last_page:0,
        userSearch:"",
        apartmentsSearch:[],
        }
    },
    methods:{
        getApartments(page){
            axios.get(`http://localhost:8000/api/apartments?page=${page}`)
            .then(resp => {
                this.apartments = resp.data.data;
                const { current_page, last_page } = resp.data;
                this.pagination = {current_page : current_page, last_page : last_page};
                this.last_page = last_page;
            })
            .catch((error)=>{
            console.warn(error);
            })
        },
        search(){
            if(this.userSearch != "" ){
                axios
                .get('http://localhost:8000/api/apartment?address='+ this.userSearch.replace(/ /g,"%"))
                .then(resp =>{
                    this.apartmentsSearch = resp.data.apartmentFiltered;
                    console.log(this.apartmentsSearch);
                })
                .catch((error)=>{
                console.warn(error);
                })
                this.userSearch="";
            }
            else{
                this.apartmentsSearch = this.apartments;
            }
        },
		getSponsoredApartments(){
			axios.get('http://127.0.0.1:8000/api/apartments/sponsored')
				.then((result)=>{
					for(let i=2; i>=0 ; i--){
						result.data[i].apartments.forEach(element => {
							this.sponsoredApartments.push(element);
						});
					}
					console.log(this.sponsoredApartments);
				}).catch((error)=>{
					console.warn(error);
				})
		}
    },
    created(){
        this.getApartments(1);
		this.getSponsoredApartments();
    },
    computed: {
        filterApartments(){
            if(this.apartmentsSearch != ""){
                return this.apartmentsSearch;
            }
            // else if(this.userSearch==""){
            //     return this.apartments;
            // }
            return this.apartments;
        },
}
}
</script>

<style scoped lang="scss">
@import "../../sass/_variables.scss";

.search
{
	--height: 50;
	--width: 300;
	--border: 5;
	--speed: 0.4;
	--ease: cubic-bezier(.85,.01,.4,.97);
	// --color-bk: white; //#547AA5;
	
	background: var(--color-bk);
	display: flex;
	align-items: center;
	justify-content: center;
	
	transition-property: background;
	transition-duration: calc(var(--speed) * 1s);
	transition-timing-function: var(--ease);
	
	&:focus-within {
		--speed: 0.7;
		// background-color: white; //#456488;
	 }
}

::placeholder { color: rgba($primary, 0.5); }
:-ms-input-placeholder { color: rgba($primary, 0.5);}
::-ms-input-placeholder { color: rgba($primary, 0.5);}

.input-container
{
	width: calc(var(--width) * 1px);
	height: calc(var(--height) * 1px);
	position: relative;
	cursor: pointer;
	transform: rotate(12deg) scale(0.7);
	
	transition-property: opacity, transform;
	transition-duration: calc(var(--speed) * 1s);
	transition-timing-function: var(--ease);
	
	.center
	{
		border: calc(var(--border) * 1px) solid $primary;
		border-left: none;
		border-right: none;
		width: 100%;
		height: calc(100% - var(--border) * 2px);
		transform: scalex(0);
		transition: inherit;
		background-color: var(--color-bk);
	}
	
	input
	{
		transition: inherit;
		width: calc(100% - var(--height));
		height: 100%;
		border: 0;
		outline: 0;
		color: $primary;
		background: transparent;
		font-size: 1.3rem;
		opacity: 0;
		padding: 0;
		margin: 0;
	}
	
	// .shadow
	// {
	// 	position: absolute;
	// 	width: 100%;
	// 	height: 100%;
	// 	border-radius: 2em;
	// 	top: 0;
	// 	left: 0;
	// 	// box-shadow: 0px 10px 50px 0px rgba(0,0,0,0.1);
	// 	transition: inherit;
	// 	transform: scalex(0) translateY(-10px);
	// 	opacity: 0;
	// }
	
	&:after, &:before
	{
		z-index:1;
		content: '';
		transition: inherit;
		width: calc((var(--height) * 0.5px) - (var(--border) * 1px));
		height: calc((var(--height) * 1px) - (var(--border) * 2px));
		display: block;
		top: 0;
		border-color: $primary;
		position: absolute;
		background-color: var(--color-bk);
		border: calc(var(--border) * 1px) solid $primary;
	}
	
	&:before
	{
		right: 100%;
		border-radius: 2em 0 0 2em;
		border-right: none;
		transform: translateX(calc(var(--width) * 0.5px));
	}
	
	&:after
	{
		left: 100%;
		border-radius: 0 2em 2em 0;
		border-left: none;
		transform: translateX(calc(var(--width) * -0.5px));
	}
	
	.sticks
	{
		position: absolute;
		height: calc(var(--height) * 0.5px);
		width: 1px;
		bottom: 0;
		right: 0;
		transition: inherit;
		transition-duration: calc(var(--speed) * 1.25s);
		transform: translateX(calc((var(--width) - var(--height)) * -0.53px)) rotate(-45deg);
		z-index: 2;
		
		&:before, &:after
		{
			transition: transform calc(var(--speed) * 1s) var(--ease);
			height: calc(var(--height) * 0.5px);
			width: calc(var(--border) * 1px);
			position: absolute;
			content: '';
			background-color: $primary;
			left: calc(var(--border) * -0.5px);
			bottom: calc(var(--height) * -0.25px);
		}
	}
		
	&:focus-within
	{
		transform: rotate(0deg) translatey(-10px);
		.center{ transform: scalex(1); }
		.shadow{ transform: scalex(1) translateY(0px); opacity: 1; }
		input{ opacity: 1; }
		&:before { transform: translateX(0); }
		&:after { transform: translateX(0); }
		
		.sticks
		{
			transition-duration: calc(var(--speed) * 1s);
			transform: translateX(calc(var(--height) * -0.1px)) translateY(0) rotate(180deg);
			&:before { transform: rotate(-45deg); }
			&:after { transform: rotate(45deg); }
		}
	}
	
	
}
</style>