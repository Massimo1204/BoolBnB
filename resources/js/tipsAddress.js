import {APP_KEYMAPS} from "./key";
let address = document.getElementById('address');
address.addEventListener('keyup', callApi);
function callApi() {
        let newAdress = address.value.replace(/ /g, "%20");
        let search ='https://api.tomtom.com/search/2/search/' + newAdress + '.json?countrySet=IT&lat=37.337&lon=-121.89&extendedPostalCodesFor=Str&minFuzzyLevel=1&maxFuzzyLevel=2&view=Unified&relatedPois=off&key=' + APP_KEYMAPS + '&countrySet=Italia';
        let request = new XMLHttpRequest(); // Create a request variable and assign a new XMLHttpRequest object to it.
        request.open('GET', search); // Open a new connection, using the GET request on the URL endpoint
        request.send();
        
        let tips;
        request.onload = async function () {
            const data = JSON.parse(this.response);
            for (let index = 0; index < 5; index++) {
                let id=index+1+"-result";
                let li=document.getElementById(id);
                if(data["results"][index]["address"]["freeformAddress"] != undefined && data["results"][index]["address"]["countryCode"] != undefined ){
                    li.innerHTML = data["results"][index]["address"]["freeformAddress"] + " " + data["results"][index]["address"]["countryCode"];
                    li.addEventListener('click',function(){
                        address.value = data["results"][index]["address"]["freeformAddress"] + " " + data["results"][index]["address"]["countryCode"];
                        document.getElementById("results").classList.add("d-none");
                    })  
                    li.classList.remove("d-none"); 
                }
            }
        }
        if(address.value == ""){
            document.getElementById("results").classList.add("d-none");
        }
    }