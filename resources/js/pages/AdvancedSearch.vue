<template>
  <div class="w-100 overflow-hidden">
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
              />
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
            <div class="input-field fouth-wrap w-100 d-flex overflow-hidden">
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
            <div class="input-field fouth-wrap w-100 d-flex overflow-hidden">
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
            <div class="input-field fifth-wrap text-center overflow-hidden">
              <button
                class="btn btn-outline-primary"
                type="button"
                @click="getFilteredApartments()"
              >
                SEARCH
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
  },
  created() {
    this.getServices();
  },
};
</script>

<style scoped lang="scss" >
.col-md-3, .col-md-12 {
  .input-field {
    margin: 2rem 0;
    img {
      width: 50px;
    }
  }
}
.w-100{
  overflow-x: hidden;
  overflow-y: scroll;
}
</style>

