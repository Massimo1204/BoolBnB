<template>
  <div class="container">
    <div class="row text-primary">
      <div class="col-lg-3 col-md-12 ps-5 pe-4 pt-2">
        <form>
          <fieldset>
            <legend class="text-center mt-2 fw-bolder text-primary ">Ricerca BnB</legend>
          </fieldset>
          <div class="inner-form">
            <div class="input-field first-wrap">
              <div class="icon-wrap"></div>
              <input
                id="search"
                type="text"
                placeholder="In che città vuoi cercare?"
                class="w-100"
                v-model="addressToSearch" required
                @keyup="getTipsAddress"
                @click="active(false)"
              />
              <div class="position-relative container-tips" >
                  <ul class="list-group position-absolute" :class="{'d-none': isActive}" id="results" v-if="addressToSearch != ''" >
                    <li class="border-primary " v-for="(result,i) in tipsFiltered" :key="i" @click="passAddress(result), active(true)">{{result}}</li>
                  </ul>
              </div>
            </div>

            <div class="input-field fouth-wrap w-100 d-flex overflow-hidden">
              <div class="icon-wrap w-25">
                <img
                  src="https://www.svgrepo.com/show/335242/people.svg"
                  alt=""
                />
              </div>
              <div class="w-75">
                <label for="bed">Posti letto:</label><br>
                <select name="bed" id="bed" v-model="bedsToSearch" class="w-75">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                </select>
              </div>
            </div>
            <div class="input-field fouth-wrap w-100 d-flex ">
              <div class="icon-wrap w-25">
                <img
                  src="https://www.svgrepo.com/show/149612/hotel-room.svg"
                  alt=""
                />
              </div>
              <div class="w-75">
                <label for="room">Numero di stanze:</label><br>
                <select name="room" id="room" v-model="roomsToSearch" class="w-75 ">
                  <option value="1">1 stanza</option>
                  <option value="2">2 stanze</option>
                  <option value="3">3 stanze</option>
                  <option value="4">4 stanze</option>
                </select>
              </div>
            </div>
            <div class="input-field fouth-wrap w-100 d-flex">
              <div class="icon-wrap w-25">
                <img
                  src="https://www.svgrepo.com/show/137809/distance.svg"
                  alt=""
                />
              </div>
              <div class="w-75">
                <label for="radius">Distanza massima di km:</label>
                <input
                  type="number"
                  name="radius"
                  id="radius"
                  min="1"
                  class="w-75"
                  v-model="rangeToSearch"
                />
              </div>
            </div>
            <div class="input-field fouth-wrap">
              <div class="icon-wrap"></div>
                <label for="services">Servizi:</label>
              <div
                v-for="(service, index) in services"
                :key="index"
                class="service col-lg-12 col-md-6"
              >
                <input
                  class="form-check-input"
                  type="checkbox"
                  name="services"
                  :value="service.id"
                  v-model="serviceToSearch"
                />
                <label for="services">{{ service.name }}</label>
              </div>
            </div>
            <div class="input-field fifth-wrap text-center">
              <button
                class="btn btn-outline-primary"
                type="button"
                @click="getFilteredApartments()"
              >
                Ricerca
              </button>
            </div>
          </div>
        </form>
      </div>
      <div class="col-lg-9 col-md-12">
        <Maps  :filteredApartments="filteredApartments" />
      </div>
    </div>
  </div>
</template>

<script>
import Maps from "../components/Maps";
import axios from "axios";
import {APP_KEYMAPS} from "../key";

export default {
  components: {
    Maps,
  },
  data() {
    return {
      services: [],
      serviceToSearch: [],
      rangeToSearch: "",
      roomsToSearch: "",
      bedsToSearch: "",
      addressToSearch: "",
      filteredApartments: [],
      tips:[],
      results:[],
      isActive: false
    };
  },
  methods: {
    getServices() {
      axios
        .get("http://127.0.0.1:8000/api/services")
        .then((response) => {
          this.services = response.data;
        })
        .catch((error) => {
          console.warn(error);
        });
    },
    getFilteredApartments() {
      axios
        .get(
          "http://127.0.0.1:8000/api/apartments/filteredsearch?address=" +
            this.addressToSearch +
            "&rooms=" +
            this.roomsToSearch +
            "&beds=" +
            this.bedsToSearch +
            "&distance=" +
            this.rangeToSearch +
            "&services=" +
            this.serviceToSearch
        )
        .then((response) => {
          this.filteredApartments=response.data.response.data;
          console.log(this.filteredApartments);
        })
        .catch((error) => {
          console.warn(error);
        });
    },
    getTipsAddress(){
      if (this.addressToSearch != '') {
        axios
          .get('https://api.tomtom.com/search/2/search/'+ this.addressToSearch.replace(/ /g,"%20") + '.json?countrySet=IT&lat=37.337&lon=-121.89&extendedPostalCodesFor=Str&minFuzzyLevel=1&maxFuzzyLevel=2&view=Unified&relatedPois=off&key=' + APP_KEYMAPS + '&countrySet=Italia')
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
      this.addressToSearch = address;
      // this.search();
    },
    active(trueFalse){
      this.isActive = trueFalse;
    }
  },
  created() {
    this.getServices();
  },
  computed:{
    tipsFiltered(){
      if(this.addressToSearch != ''){
          return this.results;
      }
    }
  }
};
</script>

<style scoped lang="scss" >
@import "../../sass/_variables.scss";

.col-md-3, .col-md-12 {
  .input-field {
    margin: 2rem 0;
    img {
      width: 50px;
    }
  }
}
.container{
  overflow-x: hidden;
  overflow-y: scroll;
}
.container-tips{
    // height: 300px;
    ul{
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
</style>

