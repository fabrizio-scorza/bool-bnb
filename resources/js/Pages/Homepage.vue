<script>
import { store } from '../store';
import axios from 'axios';
export default {
    props: ['houses', 'logged_user', 'search_route', 'show_route', 'admin_show_route'],
    data() {
        return {
            store,
            currentSlideIndex: 0,
            sponsored_houses: [],
            sponsoredHousesData: {},
        }
    },
    created() {

        this.getSponsoredHouses()
    },
    computed: {
        sponsoredHouses() {
            if (!this.sponsoredHousesData.data) {
                return []
            }
            return this.sponsoredHousesData.data
        }
    },
    methods: {
        getSponsoredHouses(page = 1) {
            axios.get(`/api/sponsoredHouses?page=${page}`).then((res) => {
                
                this.sponsoredHousesData = res.data

            }).catch(() => {

            })
        },
        prevPage() {
            if (this.sponsoredHousesData.current_page > 1) {
                this.getSponsoredHouses(this.sponsoredHousesData.current_page - 1);
            }
        },
        nextPage() {
            if (this.sponsoredHousesData.current_page < this.sponsoredHousesData.last_page) {
                this.getSponsoredHouses(this.sponsoredHousesData.current_page + 1);
            }
        },
        callShow(house){
            const houseId = house.id;
            
            if(house.user_id == this.logged_user){

                return `${this.admin_show_route}/${houseId}`;
            }else{
                return `${this.show_route}/${houseId}`;
            }
            
        },

    }
}
</script>

<template>
    <section class="carousel pb-5">

        <div>
            <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="8000">
                        <img src="/public/img/banner1.jpg"
                            class="d-block w-100" alt="...">
                        <h2 class="text-white carousel-text">Trova il tuo rifugio ideale per una fuga perfetta!</h2>
                    </div>
                    <div class="carousel-item" data-bs-interval="8000">
                        <img src="/public/img/banner2.jpg"
                            class="d-block w-100" alt="...">
                        <h2 class="text-white carousel-text">Vivi esperienze autentiche e scopri nuove tradizioni!</h2>
                    </div>
                    <div class="carousel-item" data-bs-interval="8000">
                        <img src="/public/img/banner3.jpg"
                            class="d-block w-100" alt="...">
                        <h2 class="text-white carousel-text">Dalle case sugli alberi agli appartamenti di lusso, c'è qualcosa per tutti!</h2>
                    </div>
                    <div class="carousel-item" data-bs-interval="8000">
                        <img src="/public/img/banner4.jpg"
                            class="d-block w-100" alt="...">
                        <h2 class="text-white carousel-text">Trova l'alloggio ideale con pochi semplici click!</h2>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>

    </section>
    <section class="searchbar">
        <div class="container position-relative">
            <address-component></address-component>
            <a class="search-link" :href="search_route"> &#x1F50D; Cerca</a>


        </div>
    </section>


    <section class="sponsored my-5">
        <div class="px-5">
            <div class="card p-3 bg-personal border border-dark">
                <h2 class="mb-5 text-white text-center">Appartamenti in evidenza</h2>

                <div class="row row-gap-4 position-relative">
                    <div class="col-md-4 col-12 d-flex align-items-stretch"
                        v-for="(sponsored_house, index) in sponsoredHouses" :key="sponsored_house.id">
                        <div class="card flex-fill">
                            <div class="card-header yellow">
                                <a :href="callShow(sponsored_house)" class="link-underline link-underline-opacity-0">
                                    {{ sponsored_house.title }}
                                </a>
                            </div>

                            <div class="card-body">
                                <div class="position-relative">
                                    <img :src="'storage/' + sponsored_house.thumb" alt="Immagine Appartamento" class="img-fluid">
                                    <div v-if="sponsored_house.user_id === logged_user" class="position-absolute badge rounded-pill my_house">
                                        Mio annuncio
                                    </div>       
                                </div>                                                             
                                <div class="mt-3">
                                {{ sponsored_house.address }}
                                </div>
                                <div class="d-flex gap-5 mt-1">
                                    <span>Stanze: {{ sponsored_house.rooms }}</span>
                                    <span><i class="fa-solid fa-bed"></i> {{ sponsored_house.beds }}</span>
                                </div>
                                <div class="mt-1">
                                    <strong>{{ sponsored_house.price_per_night }}€</strong> notte
                                </div>
                                
                                <div v-for="house in houses">
                                    <div v-if="house.id === sponsored_house.id">
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
                </div>


                <div class="mt-3 d-flex justify-content-center align-items-baseline ">
                    <button class="m-1" @click="prevPage"
                        :disabled="sponsoredHousesData.current_page <= 1">Indietro</button>

                    <button v-if="sponsoredHousesData.current_page > 2" class="m-1" @click="getSponsoredHouses(1)">
                        {{ 1 }}
                    </button>

                    <span v-if="sponsoredHousesData.current_page > 3">...</span>

                    <button v-if="sponsoredHousesData.current_page > 1" class="m-1"
                        @click="getSponsoredHouses(sponsoredHousesData.current_page - 1)">
                        {{ sponsoredHousesData.current_page - 1 }}
                    </button>
                    <button class="active-button" @click="getSponsoredHouses(sponsoredHousesData.current_page)">
                        {{ sponsoredHousesData.current_page }}
                    </button>

                    <button v-if="sponsoredHousesData.current_page < sponsoredHousesData.last_page" class="m-1"
                        @click="getSponsoredHouses(sponsoredHousesData.current_page + 1)">
                        {{ sponsoredHousesData.current_page + 1 }}
                    </button>

                    <span v-if="sponsoredHousesData.current_page < sponsoredHousesData.last_page - 2">...</span>

                    <button v-if="sponsoredHousesData.current_page < sponsoredHousesData.last_page - 1" class="m-1"
                        @click="getSponsoredHouses(sponsoredHousesData.last_page)">
                        {{ sponsoredHousesData.last_page }}
                    </button>

                    <button class="m-1" @click="nextPage"
                        :disabled="sponsoredHousesData.current_page >= sponsoredHousesData.last_page">Avanti</button>

                </div>

            </div>
        </div>
    </section>

</template>

<style lang="scss" scoped>
.show {
    display: inline;
}

.active-button {
    background-color: var(--yellow);
}

.hidden {
    display: none !important;
}

.slide {
    img {
        height: 650px;
        object-fit: cover;
        position: relative;
    }

    .carousel-text {
        position: absolute;
        bottom: 25px;
        right: 25px;
        padding: 3px 12px;
        background-color: rgba($color: #a290b8, $alpha: 0.8);
        font-size: 38px;

        @media screen and (max-width:576px) {
            right: 0;
            text-align: center;
        }
    }
}

.search-link {
    position: absolute;
    transform: translateY(-50%);
    top: 50%;
    right: 45px;
}

.carousel {
    position: relative;
}

.active {
    display: block;
}

.carousel-control-prev,
.carousel-control-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 1;
    width: 5%;
    height: 15%;
}

.bg-personal {
    background-color: var(--lavander);
}

.yellow{
    background-color: var(--yellow);
    a{
        color: #56456b;
        font-size: 28px;
        font-weight: 600;
    }
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