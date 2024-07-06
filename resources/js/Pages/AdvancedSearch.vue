<script>
import { store } from '../store';
export default {
    props: ['houses', 'logged_user'],
    data() {
        return {
            store,

        }
    },
    created(){

        const session_latitude = sessionStorage.getItem('latitude');

        const session_longitude = sessionStorage.getItem('longitude');

        this.searchHouses(this.houses, session_latitude, session_longitude);
    },
    methods: {
        isHidden(sponsored_house) {
            return !(sponsored_house.plans && sponsored_house.plans.length);
        },
        searchHouses(houses, lat, lon) {
            // cercare dentro l'array houses la latitudine e longitudine in un raggio di 20km del risultato di store addresses
            store.closeHouses = [];
            let latitude = lat;
            let longitude = lon;
            houses.forEach((house) => {
                if (this.distanceFromCenter(latitude, longitude, house.latitude, house.longitude) < 20) {
                    store.closeHouses.push(house)
                }
            });
        },
        deg2rad(deg) {
            return deg * (Math.PI / 180);
        },
        distanceFromCenter(lat1, lon1, lat2, lon2) {
            const R = 6371; //raggio della terra
            //panico e paura
            const dLat = this.deg2rad(lat2 - lat1);
            const dLon = this.deg2rad(lon2 - lon1);

            const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(this.deg2rad(lat1)) * Math.cos(this.deg2rad(lat2)) * Math.sin(dLon / 2) * Math.sin(dLon / 2);

            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            //distanza in chilometri
            const distance = R * c;
            return distance;
        },
        
    }
}
</script>

<template>
    <section class="searchbar py-4">
        <div class="container position-relative">
            <address-component></address-component>
            <a class="search-link" a href="#" @click="searchHouses(houses, store.addresses[0].position.lat, store.addresses[0].position.lon)"> &#x1F50D; Cerca</a>
        </div>
    </section>
    <section class="filter">
        <div class="container">
            <h2>qui ci vanno i filtri</h2>
        </div>
    </section>
    <section class="searched pt-5">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4  row-gap-4 center">
                <div id="#search" class="col-8 m-auto m-sm-0 d-flex align-items-stretch" v-for="house in store.closeHouses" :key="house.id"
                    :class="house.plans.length ? 'order-1' : 'order-2'">
                    <div class="card flex-fill">
                        <div class="card-header">
                            <a href="" class="link-underline link-underline-opacity-0">
                                {{ house.title }}
                            </a>
                        </div>

                        <div class="card-body">
                            <img :src="'./img/' + house.thumb" alt="Immagine Appartamento">
                            <div>
                                {{ house.price_per_night }}€
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

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
</style>
