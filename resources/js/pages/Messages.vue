
<template>
	<div class="container-fluid pt-5">
    <section id="contacts" class="col-9 mx-auto">
      <div class="container py-5 my-4">

        <!-- <Loader v-if="isLoading" /> -->
        <div
          class="alert d-flex justify-content-between align-items-center"
          :class="`alert-${type}`"
          role="alert"
          v-if="alert && !isLoading"
        >
          <span v-if="alertMessage">{{ alertMessage }} </span>
          <ul v-if="hasErrors" class="mb-0 pl-4">
            <li v-for="(error, key) in errors" :key="key">{{ error }}</li>
          </ul>
          <span @click="alert = !alert" class="h2 mb-0" role="button"
            >&times;</span
          >
        </div>


        <h2 class="h1-responsive font-weight-bold text-center my-4">
          Contattaci
        </h2>
        <p class="text-center w-responsive mx-auto mb-5">
          Hai qualche domanda? Non esitare a contattarci direttamente. Il nostro
          team ti risponderà in poche ore per aiutarti.
        </p>
        <div class="row">
          <div class="col-md-12 mb-md-0 mb-5">
            <div class="row">
              <div class="col-md-6">
                <div class="md-form mb-0">
                  <input type="text" id="full_name" v-model="form.full_name" class="form-control border-info"
                    :class="{ 'is-invalid': errors.full_name }"
                  />
                  <div v-if="errors.full_name" class="invalid-feedback">
                    {{ errors.full_name }}
                  </div>
                  <label v-else for="full_name" class="">Il tuo nome</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="md-form mb-0">
                  <input type="text" id="email" v-model="form.email" class="form-control border-info"
                    :class="{ 'is-invalid': errors.email }"
                  />
                  <div v-if="errors.email" class="invalid-feedback">
                    {{ errors.email }}
                  </div>
                  <label v-else for="email">La tua email</label>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="md-form">
                  <textarea type="text" id="text" v-model="form.text" rows="4" class="form-control border-info md-textarea"
                    :class="{ 'is-invalid': errors.text }"
                  ></textarea>
                  <div v-if="errors.text" class="invalid-feedback">
                    {{ errors.text }}
                  </div>
                  <label v-else for="text">Il tuo messaggio</label>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-center text-md-left m-3">
              <button class="btn btn-primary" @click="sendForm">Invia</button>
            </div>
            <div class="status"></div>
          </div>
        </div>

      </div>
    </section>
	</div>
</template>

<script>
// import Loader from "../components/Loader.vue";
import { isEmpty } from "lodash";
export default {
	name: "Messages",
	data() {
		return {
			form: {
				full_name: "",
				email: "",
				text: "",
                apartment_id: this.$route.params.id,
			},
			errors: {},
			type: "",
			alert: false,
			isLoading: false,
			alertMessage: "",
		};
	},
//   components: { Loader },
	computed: {
		hasErrors() {
			// ! Ha errori se non è vuoto, se è vuoto non ha errori
			return !isEmpty(this.errors); //Object.keys(this.errors).lenth;
		},
	},
	methods: {
		validateForm() {
			// Validazione
			const errors = {}; // ! oggetto vuoto inizialmente
			if (!this.form.full_name.trim()) errors.full_name = "Il nome non è valido.";
			if (!this.form.email.trim()) errors.email = "La mail è obbligatoria.";
			if (!this.form.text.trim()) errors.text = "Il testo del messaggio è obbligatorio.";
			// Controllo che sia una mail e che sia valida usando le espressioni regolari
			if (
				this.form.email.trim() &&
				!this.form.email.match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)
			)
				errors.email = "La mail non è valida";
			this.errors = errors;
      if (this.hasErrors) {
        this.alertMessage = "Sono presenti degli errori.";
        this.type = "danger";
        this.alert = true;
      }
		},
		sendForm() {
			// * Richiamo validateForm
			this.validateForm();
      // Controllo se ci sono errori
      if (!this.hasErrors) {
        this.isLoading = true;
        // * Creo una variabile per recuperare i params
        // Posso usare anche lo spread
        const params = {
          ...this.form,
        };
				// * Chiamo axios in POST per mandare i dati e gli passo params
				// potrei passare direttamente this.form perchè i campi COINCIDONO
				axios
					.post("http://127.0.0.1:8000/api/message", params)
					.then((res) => {
                        console.log(res);
						// Controllo se comunque mi arrivano errori DAL BACKEND
						if (res.data.errors) {
							// Prendo gli errori DA LARAVEL e li metto comunque dentro errors
							const { full_name, email, text } = res.data.errors;
							const errors = {};
							if (full_name) errors.full_name = full_name[0];
							if (email) errors.email = email[0];
							if (text) errors.text = text[0];
							this.errors = errors;
							this.type = "danger";
							this.alert = true;
						} else {
							this.form.full_name = "";
							this.form.email = "";
							this.form.text = "";
							this.alertMessage = "Messaggio inviato con successo.";
							this.alert = true;
              this.type = "success";

						}
					})
					.catch((err) => {
						// console.error(err.response.status);
            this.alertMessage = "'Messaggio non inviato. Si è verificato un errore. Riprovare più tardi";
            this.alert = true;
            this.type = "danger";
					})
					.then(() => {
						this.isLoading = false;
					});
      }
    },
  },
};
</script>

<style lang="scss" scoped>
#contacts {
	background-color: #fff;
	border-radius: 20px;
}
</style>
