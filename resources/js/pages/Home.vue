<template>
<div class="container">
    <div class="row">
        <div class="col-12 search">
            <div class="search">
                <input type="text" placeholder=" " @keyup.enter="search" v-model="userSearch">
                <div>
                    <svg>
                        <use xlink:href="#path"></use>
                    </svg>
                </div>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol xmlns="http://www.w3.org/2000/svg" viewBox="0 0 160 28" id="path">
                    <path d="M32.9418651,-20.6880772 C37.9418651,-20.6880772 40.9418651,-16.6880772 40.9418651,-12.6880772 C40.9418651,-8.68807717 37.9418651,-4.68807717 32.9418651,-4.68807717 C27.9418651,-4.68807717 24.9418651,-8.68807717 24.9418651,-12.6880772 C24.9418651,-16.6880772 27.9418651,-20.6880772 32.9418651,-20.6880772 L32.9418651,-29.870624 C32.9418651,-30.3676803 33.3448089,-30.770624 33.8418651,-30.770624 C34.08056,-30.770624 34.3094785,-30.6758029 34.4782612,-30.5070201 L141.371843,76.386562" transform="translate(83.156854, 22.171573) rotate(-225.000000) translate(-83.156854, -22.171573)"></path>
                </symbol>
            </svg>
        </div>
    </div>
    <div class="row">
		<div class="col-12">
			<h1 class="mt-4">In evidenza</h1>
		</div>
        <!-- <SingleApartment v-for="(apartment,index) in sponsoredApartments" :key="'sponsored'+ index" :apartment="apartment" /> -->
		<div class="col-12">
			<h1 >Normali</h1>
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
					for(let i=result.data.length-1; i>=0 ; i--){
						result.data[i].forEach(element => {
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

$color: $primary;

.search {
    display: table;
    // img { height: 2em; }
    input {
        background: none;
        border: none;
        outline: none;
        width: 25px;
        min-width: 0;
        padding: 0;
        z-index: 1;
        position: relative;
        line-height: 18px;
        margin: 5px 0;
        font-size: 25px;
        -webkit-appearance: none;
        font-family: 'Mukta Malar';
        transition: all .6s ease;
        cursor: pointer;
        color: $color;
        & + div {
            position: relative;
            height: 28px;
            width: 100%;
            margin: -28px 0 0 0;
            svg {
                display: block;
                position: absolute;
                height: 28px;
                width: 160px;
                right: 0;
                top: 0;
                fill: none;
                stroke: $color;
                stroke-width: 1.5px;
                stroke-dashoffset: 212.908 + 59;
                stroke-dasharray: 59 212.908;
                transition: all .6s ease;
            }
        }
        &:not(:placeholder-shown),
        &:focus {
            width: 160px;
            padding: 0 4px;
            cursor: text;
            &+ div {
                svg {
                    stroke-dasharray: 150 212.908;
                    stroke-dashoffset: 300;
                }
            }
        }
    }
}

// ::selection {
//     background: rgba(#fff, .2);
// }
// ::-moz-selection {
//     background: rgba(#fff, .2);
// }

// html {
//     box-sizing: border-box;
//     -webkit-font-smoothing: antialiased;
// }

// * {
//     box-sizing: inherit;
//     &:before,
//     &:after {
//         box-sizing: inherit;
//     }
// }

// Center & dribbble
// body {
//     min-height: 100vh;
//     font-family: 'Mukta Malar', Arial;
//     background: #F3628D;
//     display: flex;
//     justify-content: center;
//     align-items: center;
//     .dribbble {
//         position: fixed;
//         display: block;
//         right: 24px;
//         bottom: 24px;
//         img {
//             display: block;
//             width: 76px;
//         }
//     }
// }
</style>