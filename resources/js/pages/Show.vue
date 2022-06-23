<template>
    <div class="MyContainer w-100">
        <div class="row mx-auto px-5 w-100" v-if="apartment.visible">
            <div class="pics position-relative col-12 mx-sm-auto d-flex gap-1">
                <img :src="(apartment.image.startsWith('https://')) ? apartment.image : '../../storage/'+ apartment.image" class="w-50 rounded h-100" alt="">
                <div class="otherPics w-50 h-100 d-flex flex-column flex-wrap gap-1">
                    <img v-for="pic,index in pictures" :key="index" :src="(pic.image.startsWith('https://')) ? pic.image : '../../storage/'+ pic.image" class="rounded">
                </div>
                <div class="price position-absolute px-2 py-1 bg-light rounded-pill">
                    <span v-if="apartment.available">{{apartment.price}}	&euro;</span>
                    <span v-else class="text-danger">Non Disponibile</span>
                </div>
            </div>
            <div class="col-sm-12 col-md-8 col-lg-7 mt-4">
                <h1>{{apartment.title}}</h1>
                <span id="apartment_address">{{apartment.address}}</span>
                <hr>
                <h3>Description</h3>
                <p>{{apartment.description}}</p>
            </div>
            <div class="col-sm-12 col-md-8 col-lg-7 mt-3">
                <h3>Detalis</h3>
                <Details :apartment="apartment"/>
                <h3 class="mt-5">Servizi</h3>
                <Services :id="id"/>
            </div>
            <div class="col-sm-12 col-md-8 col-lg-7 mt-4">
                <h3>Map</h3>
                <h3>Meet The Host</h3>
                <div class="hostCard my-4 w-100 d-flex justify-content-between align-items-center p-3 rounded bg-white shadow">
                    <div class="d-flex justify-content-around align-items-center">
                        <img class="rounded-circle" :src="(host.profile_picture.startsWith('https://')) ? host.profile_picture : '../../storage/'+ host.profile_picture" :alt="host.id">
                        <h4 class="m-0">{{host.first_name}} {{host.last_name}}</h4>
                    </div>
                    <button type="button" class="btn btn-outline-dark shadow-none" @click="showContact = true">Contatta l'host</button>
                </div>
            </div>
        </div>
        <div v-if="showContact" class="contactContainer shadow border rounded my-4">
            <section id="contacts" class="col-12 mx-auto">
                <div class="container">
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
                        <span @click="alert = !alert" class="h2 mb-0" role="button">&times;</span>
                    </div>
                    <h2 class="h1-responsive font-weight-bold text-center my-4">Contattaci</h2>
                    <p class="text-center w-responsive mx-auto">
                        Hai qualche domanda? Non esitare a contattarci direttamente.
                        l'Host ti risponderà in poche ore per aiutarti.
                    </p>
                    <div class="row p-0">
                        <div class="col-md-12 mb-md-0 mb-5 p-0 ">
                            <div class="row p-0">
                                <div class="col-md-6 px-4">
                                    <div class="md-form mb-3">
                                        <input
                                            type="text"
                                            id="full_name"
                                            v-model="form.full_name"
                                            class="form-control border-info"
                                            :class="{ 'is-invalid': errors.full_name }"
                                            placeholder="Il tuo nome"
                                        />
                                        <div v-if="errors.full_name" class="invalid-feedback">
                                            {{ errors.full_name }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 px-4 mb-3">
                                    <div class="md-form mb-0">
                                        <input
                                            type="text"
                                            id="email"
                                            v-model="form.email"
                                            class="form-control border-info"
                                            :class="{ 'is-invalid': errors.email }"
                                            placeholder="La tua email"
                                        />
                                        <div v-if="errors.email" class="invalid-feedback">
                                            {{ errors.email }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row p-0">
                                <div class="col-md-12 px-4">
                                    <div class="md-form">
                                        <textarea
                                            type="text"
                                            id="text"
                                            v-model="form.text"
                                            rows="4"
                                            class="form-control border-info md-textarea"
                                            :class="{ 'is-invalid': errors.text }"
                                            placeholder="Il tuo messaggio"></textarea>
                                        <div v-if="errors.text" class="invalid-feedback">
                                            {{ errors.text }}
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center my-3 p-0">
                                    <button class="btn btn-primary" @click="sendForm">
                                        Invia
                                    </button>
                                </div>
                                <div class="status"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
            <h1 class="text-center mt-5" v-if="apartment.visible == 0">Nothing To See Here</h1>
    </div>
</template>

<script>
import Axios from 'axios';
import Details from '../components/Details.vue';
import Services from '../components/Services.vue';
export default {
    name:'Show',
    components:{
        Details,
        Services
    },
    data(){
        return {
            id: this.$route.params.id,
            apartment:[],
            pictures:[],
            host:[],

            showContact: false,
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
    computed: {
        hasErrors() {
        // ! Ha errori se non è vuoto, se è vuoto non ha errori
        return !isEmpty(this.errors); //Object.keys(this.errors).lenth;
        },
    },
    methods:{
        getInfo(){
            Axios.get('/api/apartment/'+this.id)
            .then(response=>{
                this.apartment=response.data;
                console.log(this.apartment);
            this.getHost(this.apartment.user_id);
            })

        },
        getpics(){
            Axios.get('/api/apartment/pictures/'+this.id)
            .then(response=>{
                this.pictures=response.data;
            })
        },
        getHost(id){
            Axios.get('/api/apartment/host/'+id)
            .then(response=>{
                this.host=response.data[0][0];    
                // console.log(this.host);
            })
        },
        validateForm() {
            // Validazione
            const errors = {}; // ! oggetto vuoto inizialmente
            if (!this.form.full_name.trim())
                errors.full_name = "Il nome non è valido.";
            if (!this.form.email.trim()) errors.email = "La mail è obbligatoria.";
            if (!this.form.text.trim())
                errors.text = "Il testo del messaggio è obbligatorio.";
            // Controllo che sia una mail e che sia valida usando le espressioni regolari
            if (
                this.form.email.trim() &&
                !this.form.email.match(
                    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                )
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
                    this.alertMessage =
                    "'Messaggio non inviato. Si è verificato un errore. Riprovare più tardi";
                    this.alert = true;
                    this.type = "danger";
                })
                .then(() => {
                    this.isLoading = false;
                });
            }
        },
    },
    created(){
        this.getInfo();
        this.getpics();
    },
}
</script>

<style lang="scss" scoped>

    @import 'resources/sass/_variables.scss';
    .MyContainer{
        background-color: $light-dark-background;
        padding: 2rem 0;
    }
    #apartment_address{
        color: $light-grey;
    }
    @media (min-width: 992px){
        .MyContainer{
            padding: 2rem 10vw;
        }
    }

    .pics{
        height: 50vh;
        // width: 80vw;
        min-width: 455px;
        img, .otherPics img{
            object-fit: cover;
        }
        .otherPics{
            overflow-y: hidden;
            img{
                width: 49.5%;
                height: 49%;
            }
        }
    
    @media(max-width: 767.98px)  {
        .otherPics{
            img{
                width: 99.5%;
            }
            }
        .contactContainer{
            max-width: 90vw;
        }
        }
    @media(max-width: 1399.98px){
        .contactContainer{
            max-width: 70vw;
            margin: 0 auto;
        }
    } 
        .otherPics::-webkit-scrollbar{
            height: 1.5vh;
        }
        .otherPics::-webkit-scrollbar-track {
            background: rgb(214, 214, 214);
            border-radius: 1rem;
        }
        .otherPics::-webkit-scrollbar-thumb {
            background-color: rgb(163, 163, 163) ;
            border-radius: 1rem;
            border: .15rem solid rgb(214, 214, 214);
        }
        .price{
            bottom: 0.3rem;
            left: 1rem;
        }
    }
    .hostCard{
        div{
            width: 17rem;
        }
        img{
            height: 5rem;
            width: 5rem;
            object-fit: cover;
        }
        h4{
            vertical-align: auto;
        }
        #contacts {
            background-color: #fff;
            border-radius: 20px;
        }
    }

</style>
