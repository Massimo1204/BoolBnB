<template>
<div>
  <div class="map" id="map" ref="mapRef"></div>
  <div class="row mt-4 border-top border-3 border-primary" v-if="filteredApartments != ''">
      <div class="col-6" v-for="(apartment, index) in filterApartmentsVisible" :key="index" >
        <div class="cardcontainer my-3 view-details" >
            <router-link :to="{name: 'Show', params:{id: apartment['id']}}" class="text-decoration-none">
                <div class="photo mx-auto position-relative">
                    <img class="w-100" :src="(apartment['image'].startsWith('https://')) ? apartment['image'] : '../../storage/'+ apartment['image']" :alt="apartment['title']">
                    <div class="price position-absolute px-2 py-2">{{apartment['price']}} €</div>
                </div>
                <h2 class="txt m-0 title text-capitalize text-black">{{apartment['title']}}</h2>
                <div class="content address">
                    <p>{{ apartment['address']}}</p>
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
          this.filteredApartments.forEach(apartment => {
            let marker = new tt.Marker().setLngLat([apartment["long"], apartment["lat"]]).addTo(this.map);
            let popup = new tt.Popup({offset: this.popupOffsets}).setHTML(`<b>${apartment["title"]}</b><br/>${apartment["address"]}`);
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
  }
}
</script>

<style scoped lang="scss">
@import "../../sass/_variables.scss";

.map {
  height: 80vh;
  width: 100%;
}
.col-6{
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
      color: $medium-dark-background;
      font-size: 1.2rem;
  }
}
</style>
