<template>

<div class="w-100 overflow-hidden position-relative">
        <div class="row px-5">
            <div class="col-6 search mt-2">
                <div class="search">
                    <input type="text" placeholder=" " @keyup="getTipsAddress" @keyup.enter="search" v-model="userSearch" required> 
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
                
                <div class="position-relative container-tips" >
                    <ul class="list-group position-absolute" id="results" v-if="userSearch != ''" >
                        <li class="border-primary " v-for="(result,i) in tipsFiltered" :key="i" @click="passAddress(result)">{{result}}</li>
                    </ul>
                </div>
            </div>
            <div class="col-6 mt-3">
            <router-link :to="{name: 'AdvancedSearch'}" class="text-decoration-none d-flex justify-content-end ">
                <button class="btn btn-primary btn-sm">Ricerca avanzata</button>
            </router-link>
            </div>
        </div>
        <div class="row px-5">
            <div class="col-12">
                <h1 class="mt-4 text-primary" v-if="sponsoredApartments != ''">In evidenza</h1>
            </div>
            <div class="border-bottom border-primary row mt-2">
                <SingleApartment v-for="(apartment,index) in sponsoredApartments" :key="'sponsored'+ index" :apartment="apartment" />
            </div>
            <SingleApartment v-for="(apartment,index) in apartmentsShow" :key="index" :apartment="apartment" />
            <div class="col-12 nothing">
                <h1 class="text-center text-primary" v-show="apartmentsShow == '' "> Niente da mostrare</h1>
            </div>
        </div>
        <div class="row" v-if="( apartmentsShow.length == 12 || pagination.current_page == last_page)">
            <div class="myPagination col-12 d-flex justify-content-between align-content-center my-3 px-sm-3 w-50 mx-auto" v-if="apartmentsSearch !== ''">
                <div v-if="pagination.current_page == 1"></div>
                <button class="btn btn-outline-primary shadow-none" @click="getApartments(pagination.current_page - 1)" v-if="pagination.current_page > 1">Precedente</button>
                <h5>Pagina: {{pagination.current_page}}</h5>
                <button class="btn btn-outline-primary shadow-none" @click="getApartments(pagination.current_page + 1)" v-if="pagination.current_page < pagination.last_page">Successivo</button>
                <div v-if="pagination.current_page == last_page"></div>
            </div>
        </div>
    <!-- <div class=" transparent"></div> -->
</div>
</template>

<script>
import SingleApartment from '../components/SingleApartment.vue';
import {APP_KEYMAPS} from "../key";


export default {
    name:"home",
    components:{
        SingleApartment,
    },
    data(){
        return{
        apartments:[],
        apartmentsShow:[],
		sponsoredApartments:[],
        pagination:{},
        last_page:0,
        userSearch:"",
        apartmentsSearch:[],
        tips:[],
        results:[],
        // isLoading: true,
        }
    },
    methods:{
        getApartments(page){
            // this.isLoading = true;
            axios.get(`http://localhost:8000/api/apartments?page=${page}`)
            .then(resp => {
                this.apartments = resp.data.data;
                const { current_page, last_page } = resp.data;
                this.pagination = {current_page : current_page, last_page : last_page};
                this.last_page = last_page;
                this.apartmentsShow=this.apartments;
                // this.isLoading = false;
            })
            .catch((error)=>{
            console.warn(error);
            })
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },
        search(){
            if(this.userSearch != ""){
                console.log(this.tips[0]);
                axios
                .get('http://localhost:8000/api/apartment?address='+ this.userSearch.replace(/ /g,"%20"))
                .then(resp =>{
                    this.apartmentsSearch = resp.data.apartmentFiltered;
                    console.log(this.apartmentsSearch);
                    this.apartmentsShow=this.apartmentsSearch;
                })
                .catch((error)=>{
                    console.warn(error);
                    this.apartmentsSearch=null;
                })
                this.userSearch="";
            }
            else{
                this.apartmentsShow = this.apartments;
            }
        },
		getSponsoredApartments(){
			axios.get('http://127.0.0.1:8000/api/sponsored/apartments')
				.then((result)=>{
					for(let i=result.data.length-1; i>=0 ; i--){
						result.data[i].apartments.forEach(element => {
							this.sponsoredApartments.push(element);
						});
					}
				}).catch((error)=>{
					console.warn(error);
				})
		},
        getTipsAddress(){
            if (this.userSearch != '') {
                axios
                    .get('https://api.tomtom.com/search/2/search/'+ this.userSearch.replace(/ /g,"%20") + '.json?countrySet=IT&lat=37.337&lon=-121.89&extendedPostalCodesFor=Str&minFuzzyLevel=1&maxFuzzyLevel=2&view=Unified&relatedPois=off&key=' + APP_KEYMAPS + '&countrySet=Italia')
                    .then(resp =>{
                        this.tips = resp.data.results;
                        for (let index = 0; index < 5; index++) {
                            if(this.tips[index]["address"]["freeformAddress"] != undefined && this.tips[index]["address"]["countryCode"] != undefined ){
                                this.results[index]=this.tips[index]["address"]["freeformAddress"] + " " + this.tips[index]["address"]["countryCode"];
                            }                
                        }
                    })
                    .catch((error)=>{
                        console.warn(error);
                    })
            }
        },
        passAddress(address){
            this.userSearch = address;
            this.search();
        }
    },
    created(){
        this.getApartments(1);
		this.getSponsoredApartments();
    },
    computed:{
        tipsFiltered(){
            if(this.userSearch != ''){
                return this.results;
            }
        }
    }
}
</script>

<style scoped lang="scss">
@import "../../sass/_variables.scss";

$color: $primary;
// .w-100{
    // z-index: 2;
// }
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
.container-tips{
    // height: 300px;
    
    ul{
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        background-color: white;
        z-index: 3;
        // padding: 1rem;
        li{
            border-bottom: 2px solid $primary;
            cursor: pointer;
            height: 35px;
            width: 500px;
            list-style: none;
            color: black;
            padding: .4rem;
            // border-radius: 15px;
        }
        :hover{
            background-color: $primary;
            color: white;
            // border-radius: 15px;
            
        }
        li:first-child {
            border-radius: 5px 5px 0 0;
        }
        li:last-child{
            border-radius: 0 0 5px 5px ;
        }
    }
}
    .transparent{
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        // background-color: rgba($color: white, $alpha: 0.7);
        // display: none;
        position: absolute;
    }
.container-tips:hover .transparent{
    background-color: rgba($color: white, $alpha: 0.7);
}
.myPagination{
    h5{
        line-height: 2.4rem;
        margin: 0;
    }
}
.nothing{
    height: 50vh;
}
</style>