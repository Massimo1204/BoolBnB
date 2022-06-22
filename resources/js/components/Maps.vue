<template>
  <div class="map" id="map" ref="mapRef"></div>
</template>

<script>
import tt from '@tomtom-international/web-sdk-maps'
import {APP_KEYMAPS} from "../key";


export default {
  name:"Maps",
  props: ["filteredApartements"], 
  data() {
    return {
      // map: null,
      Italy : {lng: 12.5674, lat: 41.8719},
      markers:[],
      zoom:4.8
    }
  },
  mounted() {
    this.initializeMap()
      // console.log(apartments);
      // console.log(this.Italy)

  },
  methods: {
    initializeMap() {
      // const tt = window.tt;
      this.map = tt.map({
        key:APP_KEYMAPS ,

        container: this.$refs.mapRef,
        center: this.Italy,
        zoom: this.zoom,
        minZoom: this.zoom,

      })
      this.map.addControl(new tt.FullscreenControl(), 'top-left');
      this.map.addControl(new tt.NavigationControl(), 'top-left');
      if (this.markers) {
        for (let index = 0; index < this.markers.length-1; index++) {
          new tt.Marker().setLngLat([this.markers[index],this.markers[index+1]]).addTo(this.map);
        }
          // console.log(this.markers.length);
      }
      
      // new tt.Marker().setLngLat([12.494335 , 41.905719]).addTo(this.map)

      this.map = Object.freeze(this.map)
    },
    getApartmentsMarker(){
      if (this.filteredApartements!="") {
        // console.log(this.filteredApartements[0]);
        this.filteredApartements.forEach(apartment => {
          this.markers.push(apartment["long"],apartment["lat"]);
          // new tt.Marker().setLngLat([apartment["long"],apartment["lat"]]).addTo(this.map);
          this.Italy= {lng:apartment["long"],lat:apartment["lat"]};
          this.zoom=10;
        });
          this.initializeMap()

      }

    }
  },
  watch:{
    filteredApartements(){
      this.getApartmentsMarker();
    },
  }
}
</script>

<style scoped>
.map {
  height: 80vh;
  width: 100%;
}
</style>
