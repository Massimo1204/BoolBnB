<template>
  <div class="map" id="map" ref="mapRef"></div>
</template>

<script>
import tt from '@tomtom-international/web-sdk-maps'

export default {
  data() {
    return {
      // map: null,
      Italy : {lng: 12.5674, lat: 41.8719}

    }
  },
  mounted() {
    this.initializeMap()
  },
  methods: {
    initializeMap() {
      // const tt = window.tt;
      this.map = tt.map({
        key: 'PAeaq8AFofiaFnTYcbMQMTBAW7ENmXLB',

        container: this.$refs.mapRef,
        center: this.Italy,
        zoom: 5.2,
        minZoom:5.2,

      })
      this.map.addControl(new tt.FullscreenControl(), 'top-left');
      this.map.addControl(new tt.NavigationControl(), 'top-left');

      new tt.Marker().setLngLat([12.494335 , 41.905719]).addTo(this.map)

      this.map = Object.freeze(this.map)
    },
  },
}
</script>

<style scoped>
.map {
  height: 80vh;
  width: 100%;
}
</style>
