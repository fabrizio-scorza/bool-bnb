<template>
    <section class="searchbar py-4">
        <div class="container position-relative">
            <address-component :initial-address=this.initialAddress></address-component>
            <a class="search-link" href="#" @click="filteredHouses()"> 
                &#x1F50D; Cerca
            </a>
        </div>
    </section>
    <section class="filter">
        <div class="container mb-4">
            <div class="card p-3">
                <div class="row row-cols-1 row-cols-lg-3 mb-4">
                    <div>
                        <label for="km" class="form-label mb-4">Raggio di ricerca: {{ kms }} km</label>
                        <input type="range" class="form-range" min="1" max="50" step="1" id="km" v-model="kms">
                    </div>
                    <div>
                        <label for="rooms" class="form-label mb-4">Numero minimo di stanze: {{ rooms }}</label>
                        <input type="range" class="form-range" min="1" max="30" step="1" id="rooms" v-model="rooms">
                    </div>
                    <div>
                        <label for="beds" class="form-label mb-4">Numero minimo di posti letto: {{ beds }}</label>
                        <input type="range" class="form-range" min="1" max="90" step="1" id="beds" v-model="beds">
                    </div>
                </div>
                
                <div class=" d-flex flex-wrap gap-3 mt-2">
                    <div v-for="service in services" :key="service.id">
                        <div class="form-check">
                            <input name="services[]" class="form-check-input me-2" type="checkbox" id="service-{{service.id}}" v-model="is_checked[service.id - 1]">
                            <label class="form-check-label"> {{service.name}}</label>
                        </div>
                    </div>
                    <button class="ms-auto">
                        <a href="#" @click="filteredHouses()"> 
                        &#x1F50D; Cerca
                        </a>
                    </button>
                </div>
               
            </div>
        </div>
    </section>
    <section class="searched">
        <div class="container">
            <h3 v-if="noResult" class="no-result">
                La ricerca non ha prodotto risultati.
            </h3>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4  row-gap-4 center">
                <div id="search" class="col-8 m-auto m-sm-0 d-flex align-items-stretch" v-for="house in sortedHouses" :key="house.id">
                    <div class="card flex-fill">
                        <div class="card-header">
                            <a :href="callShow(house)" class="link-underline link-underline-opacity-0">
                                {{ house.title }}
                            </a>
                        </div>
                        <div class="card-body position-relative">
                            <div class="position-relative">
                                <img :src="'storage/' + house.thumb" alt="Immagine Appartamento">
                                <div v-if="notExpired(house)" class="position-absolute badge rounded-pill my_sponsor">
                                    <i class="fa-solid fa-trophy"></i>
                                </div>
                                <div v-if="house.user_id === logged_user" class="position-absolute badge rounded-pill my_house">
                                    Mio annuncio
                                </div>
                            </div>                            
                            <div class="mt-3">
                                {{ house.address }}
                            </div>
                            <div class="mt-1">
                                <span>Distanza: {{ house.distance }} km </span>
                            </div>
                            <div class="d-flex gap-5 mt-1">
                                <span>Stanze: {{ house.rooms }}</span>
                                <span><i class="fa-solid fa-bed"></i> {{ house.beds }}</span>
                            </div>
                            <div class="mt-1">
                                <strong>{{ house.price_per_night }}€</strong> notte
                            </div>
                            <div class="d-flex gap-2 mt-3">
                                <div v-for="service in house.services" :key="service.id">
                                    <div v-if="service.id === 1">
                                        <i class="fa-solid fa-wifi"></i>
                                    </div>
                                    <div v-else-if="service.id === 2">
                                        <i class="fa-solid fa-car"></i>
                                    </div>
                                    <div v-else-if="service.id === 3">
                                        <i class="fa-solid fa-person-swimming"></i>
                                    </div>
                                    <div v-else-if="service.id === 4">
                                        <i class="fa-solid fa-bell-concierge"></i>
                                    </div>
                                    <div v-else-if="service.id === 5">
                                        <i class="fa-solid fa-temperature-full"></i>
                                    </div>
                                    <div v-else-if="service.id === 6">
                                        <i class="fa-solid fa-umbrella-beach"></i>
                                    </div>
                                    <div v-else-if="service.id === 7">
                                        <i class="fa-regular fa-snowflake"></i>
                                    </div>
                                    <div v-else-if="service.id === 8">
                                        <i class="fa-solid fa-hot-tub-person"></i>
                                    </div>
                                    <div v-else-if="service.id === 9">
                                        <i class="fa-solid fa-martini-glass"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { store } from '../store';

export default {
    props: ['houses', 'logged_user', 'show_route', 'admin_show_route', 'services'],
    data() {
        return {
            store,
            noResult: false, 
            rooms: null,
            beds: null,
            kms: 20,
            is_checked: [],
            housesArray: [],
            services_id:[],
            initialAddress: sessionStorage.getItem('address'),
            now : new Date()
            
        }
    },
    computed:{
        sortedHouses(){
            return store.closeHouses.sort((a,b)=>{
                const aHouse = a.plans.some(plan => new Date(plan.pivot.expires_at) > this.now);
                const bHouse = b.plans.some(plan => new Date(plan.pivot.expires_at) > this.now);

                if (aHouse && !bHouse) return -1;
                if(!aHouse && bHouse) return 1;
                return a.distance - b.distance;
            });
        }
    },
    created() {
        const session_latitude = sessionStorage.getItem('latitude');
        const session_longitude = sessionStorage.getItem('longitude');

        store.addresses[0] = {
            'position': {
                'lat': session_latitude, 
                'lon': session_longitude
            },
            'address':{
                'freeformAddress': this.initialAddress,
            }
        }
        
        

        this.searchHouses(this.houses, session_latitude, session_longitude, 20);
        
        if (store.closeHouses.length === 0) {
            this.noResult = true;
        }
        
    },
    methods: {

       notExpired(house){
        const isSponsored = house.plans.some(plan => new Date(plan.pivot.expires_at) > this.now);

        return isSponsored
       },

        filteredHouses(){
            this.services_id = [];

            this.housesArray = this.houses
            
           
            if(this.rooms != null){
                
                this.housesArray = this.housesArray.filter(el => el.rooms  >= this.rooms);
            }
            if(this.beds != null){
            
                this.housesArray = this.housesArray.filter(el => el.beds  >= this.beds);        
            }


            this.is_checked.forEach((service, index) => {
                if(service == true){
                    this.services_id.push(index + 1);
                }
            });            



            if (this.services_id.length !== 0) {
            this.housesArray = this.housesArray.filter(house => {
                // Verifica se la casa ha tutti i servizi selezionati
                const houseServiceIds = house.services.map(service => service.id);
                return this.services_id.every(serviceId => houseServiceIds.includes(serviceId));
            });
            }

           

           
            this.searchHouses(this.housesArray, store.addresses[0].position.lat, store.addresses[0].position.lon, this.kms)
        },
       

        searchHouses(houses, lat, lon, km) {
            store.closeHouses = [];
            let latitude = lat;
            let longitude = lon;
            houses.forEach((house) => {
                if(house.available === 1){
                    const distance = this.distanceFromCenter(latitude, longitude, house.latitude, house.longitude);
                    if (distance < km) {
                        house.distance = distance.toFixed(2);
                        store.closeHouses.push(house);
                    }
                }
            });
            // Aggiorna noResult dopo aver cercato le case
            this.noResult = store.closeHouses.length === 0;
        },
        deg2rad(deg) {
            return deg * (Math.PI / 180);
        },
        distanceFromCenter(lat1, lon1, lat2, lon2) {
            const R = 6371; // Raggio della terra in km
            const dLat = this.deg2rad(lat2 - lat1);
            const dLon = this.deg2rad(lon2 - lon1);
            const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + 
                      Math.cos(this.deg2rad(lat1)) * Math.cos(this.deg2rad(lat2)) * 
                      Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c; // Distanza in km
        },
        callShow(house){
            const houseId = house.id;
            
            if(house.user_id == this.logged_user){

                return `${this.admin_show_route}/${houseId}`;
            }else{
                return `${this.show_route}/${houseId}`;
            }
            
        },
    },
   

}    
</script>

<style lang="scss" scoped>
.show {
    display: inline;
}

.hidden {
    display: none !important;
}

.search-link {
    position: absolute;
    transform: translateY(-50%);
    top: 50%;
    right: 45px;
}

.no-result {
    color: var(--purple);
    margin-top: 20px;
    text-align: center;
}

.my_sponsor {
    background-color: var(--purple);
    color: var(--yellow);
    border: 2px solid var(--yellow);
    padding: 8px 9px;
    font-size: 22px;
    top: 5px;
    right: 5px;
}


.my_house{
    background-color: var(--orange);
    color: var(--white);
    border: 2px solid var(--white);
    padding: 5px 15px;
    font-size: 16px;
    bottom: 8px;
    left: 8px;

}

</style>
