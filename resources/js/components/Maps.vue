<template>
<div class="p-0">
  <div class="map" id="map" ref="mapRef"></div>
  <div class="row mt-4 border-top border-2 border-primary pe-4" v-if="filteredApartments != ''">
      <div class="col-lg-6 col-md-6" v-for="(apartment, index) in filterApartmentsDistance" :key="index" >
        <div class="cardcontainer my-3 view-details" >
            <router-link :to="{name: 'Show', params:{id: apartment['id']}}" class="text-decoration-none">
                <div class="photo mx-auto position-relative">
                    <img class="w-100" :src="(apartment['image'].startsWith('https://')) ? apartment['image'] : '../../storage/'+ apartment['image']" :alt="apartment['title']">
                    <div class="price position-absolute px-2 py-2">{{apartment['price']}} €</div>
                </div>
                <h2 class="txt m-0 title text-capitalize text-primary">{{apartment['title']}}</h2>
                <div class="content address">
                    <p class="text-black ">{{ apartment['address']}}</p>
                </div>
            </router-link>
        </div>
      </div>
  </div>
</div>
</template>

<script>
import tt from '@tomtom-international/web-sdk-maps'
import {APP_KEYMAPS} from "../key";


export default {
  name:"Maps",
  props: ["filteredApartments"], 
  data() {
    return {
      // map: null,
      Italy : {lng: 12.5674, lat: 41.8719},
      markers:[],
      zoom:4.8,
      minZoom:4.8,
      popupOffsets: {
        top: [0, 0],
        bottom: [0, -40],
        'bottom-right': [0, -70],
        'bottom-left': [0, -70],
        left: [25, -35],
        right: [-25, -35]
      },
      apartments:[]
      
    }
  },
  mounted() {
    this.initializeMap()
  },
  methods: {
    initializeMap() {
      // const tt = window.tt;
      if (this.filteredApartments != "") {
        this.zoom=10;
        this.Italy= {lng:this.filteredApartments[0]["long"],lat:this.filteredApartments[0]["lat"]};
      }
      this.map = tt.map({
        key:APP_KEYMAPS ,

        container: this.$refs.mapRef,
        center: this.Italy,
        zoom: this.zoom,
        minZoom: this.minZoom,

      })
      this.map.addControl(new tt.FullscreenControl(), 'top-left');
      this.map.addControl(new tt.NavigationControl(), 'top-left');
      this.map = Object.freeze(this.map)
        if (this.filteredApartments != "") {
          this.filterApartmentsVisible.forEach(apartment => {
            let marker = new tt.Marker().setLngLat([apartment["long"], apartment["lat"]]).addTo(this.map);
            let popup = new tt.Popup({offset: this.popupOffsets}).setHTML(`<b>${apartment["title"]}</b><br/>${apartment["address"]}. <br/> Dista ${apartment['distance'].toFixed(2)} km dalla tua ricerca`);
            marker.setPopup(popup).togglePopup();
          });
        }
    },
  },
  watch:{
    filteredApartments(){
      this.initializeMap();
    },
  },
  computed:{
    filterApartmentsVisible(){
      let apartmentVisible=[];
      this.filteredApartments.forEach(apartment => {
        
        if(apartment.visible == 1){
          apartmentVisible.push(apartment)
        }

      });
      return apartmentVisible;
    },
    filterApartmentsDistance(){
      let apartmentDistance=[];
      let distance=[];
      this.filterApartmentsVisible.forEach(apartment => {
        distance.push(apartment["distance"])
      });
        const sorted = distance.slice().sort((a,b)=>a-b) // Make a copy with .slice()
        sorted.forEach(element => {
          for (let i = 0; i < this.filterApartmentsVisible.length; i++) {
            if (element == this.filterApartmentsVisible[i]["distance"]) {
              apartmentDistance.push(this.filterApartmentsVisible[i]);
            }
          }
        });
        // console.log(apartmentDistance);
      return apartmentDistance;
    }
  }
}
</script>

<style scoped lang="scss">
@import "../../sass/_variables.scss";

.map {
  height: 80vh;
  width: 100%;
  // padding: 0;
}
.col-lg-6, .col-md-12{
  .content{
      // max-height: 220px; 
      overflow: auto;
  }
  .photo{
      height: 250px;
      border-radius: 15px;
      img{
          height: 100%;
          border-radius: 15px;
          object-fit: cover;
      }
      .price{
          background-color: $light-dark-background;
          border-radius: 50%;
          bottom: 1rem;
          left: 1rem;
      }
  }
  .address
  {
      color: $light-grey;;
      font-size: 1.2rem;
  }
}
</style>
