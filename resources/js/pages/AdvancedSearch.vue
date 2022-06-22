<template>
  <div class="container">
    <div class="row">
      <div class="col-3">
        <form>
          <fieldset>
            <legend>SEARCH BnB</legend>
          </fieldset>
          <div class="inner-form">
            <div class="input-field first-wrap">
              <div class="icon-wrap">
                
              </div>
              <input id="search" type="text" placeholder="In che città vuoi cercare?" class="w-100" />
            </div>

            <div class="input-field fouth-wrap w-100 d-flex">
              <div class="icon-wrap w-25">
                <img src="https://www.svgrepo.com/show/335242/people.svg" alt="">
              </div>
              <div class="w-75">
                <label for="bed" class="w-100">posti letto:</label>
                <select  name="bed" id="bed">
                  <option value="1">1 </option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                </select>
              </div>
            </div>
            <div class="input-field fouth-wrap w-100 d-flex">
              <div class="icon-wrap w-25">
                <img src="https://www.svgrepo.com/show/149612/hotel-room.svg" alt="">
              </div>
              <div class="w-75">
                <label for="room" class="w-100">Numero di stanze:</label>
                <select  name="room" id="room">
                  <option value="1">1 stanza</option>
                  <option value="2">2 stanze</option>
                  <option value="3">3 stanze</option>
                  <option value="4">4 stanze</option>
                </select>
              </div>
            </div>
            <div class="input-field fouth-wrap w-100 d-flex">
              <div class="icon-wrap w-25">
                <img src="https://www.svgrepo.com/show/137809/distance.svg" alt="">
              </div>
              <div class="w-75">
                <label for="radius">Distanza massima di km:</label>
                <input type="number" name="radius" id="radius" min="1" class="w-100">
              </div>
            </div>
            <div class="input-field fouth-wrap">
              <div class="icon-wrap">
       
              </div>
              <label for="categories">Servizi:</label>
                    <div class="service col-4">
                        <input class="form-check-input" type="checkbox" name="categories" value="">
                    </div>
            </div>
            <div class="input-field fifth-wrap text-center">
              <button class="btn btn-outline-primary" type="button">SEARCH</button>
            </div>
          </div>
        </form>
      </div>
      <div class="col-9">
        <Maps />
      </div>
    </div>
  </div>
</template>

<script>
import Maps from "../components/Maps";

export default {
  components:{
        Maps
    },
}
</script>

<style scoped lang="scss" >
  .col-3{
    .input-field{
      margin: 2rem 0;
      img{
        width: 50px;
      }
    }
  }
</style>