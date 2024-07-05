<script>
import { store } from '../store';
export default {
    props: ['houses', 'logged_user'],
    data() {
        return {
            store,
            closeHouses: [],
        }
    },
    methods: {
        isHidden(sponsored_house) {
            return !(sponsored_house.plans && sponsored_house.plans.length);
        },
        searchHouses(houses) {
            // cercare dentro l'array houses la latitudine e longitudine in un raggio di 20km del risultato di store addresses
            this.closeHouses = [];
            let latitude = store.addresses[0].position.lat;
            let longitude = store.addresses[0].position.lon;
            houses.forEach((house) => {
                if (this.distanceFromCenter(latitude, longitude, house.latitude, house.longitude) < 20) {
                    this.closeHouses.push(house)
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
        }
    }
}
</script>

<template>
    <section class="searchbar">
        <div class="container">
            <address-component></address-component>
            <a href="#" @click="searchHouses(houses)">Cerca</a>
        </div>
    </section>
    <section class="filter">
        <div class="container">
            <h2>qui ci vanno i filtri</h2>
        </div>
    </section>
    <section class="sponsored">
        <div class="container">
            <div class="row row-gap-4">
                <div class="col-3 d-flex align-items-stretch" v-for="sponsored_house in houses"
                    :class="[isHidden(sponsored_house) ? 'hidden' : '']" :key="sponsored_house.id">
                    <div v-if="sponsored_house.plans && sponsored_house.plans.length" class="card flex-fill">
                        <div v-for="plan in sponsored_house.plans" :key="plan.id">
                            <div class="card-header">
                                <a href="" class="link-underline link-underline-opacity-0">
                                    {{ sponsored_house.title }}
                                </a>
                            </div>

                            <div class="card-body">
                                <img :src="'./img/' + sponsored_house.thumb" alt="Immagine Appartamento">
                                <div>
                                    {{ sponsored_house.price_per_night }}€
                                </div>
                            </div>


                            <div v-if="sponsored_house.user_id == logged_user"
                                class="card-footer d-flex justify-content-between">
                                <div>
                                    <button class="me-3">
                                        <a href="">
                                            Modifica
                                        </a>
                                    </button>
                                    <form action="" method="POST">
                                        <button>
                                            Ripristina
                                        </button>
                                    </form>
                                    <button data-bs-toggle="modal" data-bs-target="#modal-{{$house->id}}" class="">
                                        Elimina
                                    </button>
                                </div>

                                <div>
                                    <a href="" class="me-3 link-underline link-underline-opacity-0">St</a>
                                    <a href="" class="link-underline link-underline-opacity-0">Sp</a>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-3 d-flex align-items-stretch" v-for="house in closeHouses" :key="house.id">
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

                        <div v-if="house.user_id == logged_user" class="card-footer d-flex justify-content-between">
                            <div>
                                <button class="me-3">
                                    <a href="">
                                        Modifica
                                    </a>
                                </button>
                                <form action="" method="POST">
                                    <button>
                                        Ripristina
                                    </button>
                                </form>
                                <button data-bs-toggle="modal" data-bs-target="#modal-{{$house->id}}" class="">
                                    Elimina
                                </button>
                            </div>

                            <div>
                                <a href="" class="me-3 link-underline link-underline-opacity-0">St</a>
                                <a href="" class="link-underline link-underline-opacity-0">Sp</a>
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
</style>