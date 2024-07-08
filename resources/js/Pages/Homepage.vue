<script>
import { store } from '../store';
import axios from 'axios';
export default {
    props: ['houses', 'logged_user', 'search_route'],
    data() {
        return {
            store,
            currentSlideIndex: 0,
            sponsored_houses: [],
            sponsoredHousesData: {},
            activeButton: 1,


        }
    },
    created() {
        console.log('console log di store:' + store.closeHouses)
        this.getSponsoredHouses()
    },
    computed: {

        sponsored() {
            this.houses.forEach(house => {
                if (house.plans && house.plans.length) {
                    this.sponsored_houses.push(house)
                }
            })
            return this.sponsored_houses;

        },
        sponsoredHouses() {
            if (!this.sponsoredHousesData.data) {
                return []
            }
            return this.sponsoredHousesData.data
        }
    },
    methods: {
        // showPrevSlide() {
        //     this.currentSlideIndex = (this.currentSlideIndex === 0) ? this.sponsored_houses.length - 1 : this.currentSlideIndex - 1;
        // },
        // showNextSlide() {
        //     this.currentSlideIndex = (this.currentSlideIndex === this.sponsored_houses.length - 1) ? 0 : this.currentSlideIndex + 1;
        // },
        getSponsoredHouses(page = 1) {
            this.activeButton = page;
            axios.get(`/api/sponsoredHouses?page=${page}`).then((res) => {
                console.log(res.data)
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
        }

    }
}
</script>

<template>
    <section class="carousel py-5">

        <div>
            <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="8000">
                        <img src="https://images.pexels.com/photos/186077/pexels-photo-186077.jpeg"
                            class="d-block w-100" alt="...">
                        <h2 class="text-white carousel-text">Questo è il nostro sito. Vi offriamo la possibilità di
                            cercare alloggi per godervi le vostre vacanze!</h2>
                    </div>
                    <div class="carousel-item" data-bs-interval="8000">
                        <img src="https://images.pexels.com/photos/323780/pexels-photo-323780.jpeg"
                            class="d-block w-100" alt="...">
                        <h2 class="text-white carousel-text">Potrai beneficiare di tutti i tipi di servizi offerti.</h2>
                    </div>
                    <div class="carousel-item" data-bs-interval="8000">
                        <img src="https://images.pexels.com/photos/1438832/pexels-photo-1438832.jpeg"
                            class="d-block w-100" alt="...">
                        <h2 class="text-white carousel-text">Cerca l'alloggio più adatto alle tue esigenze, troverai
                            tutte le categorie che desideri.</h2>
                    </div>
                    <div class="carousel-item" data-bs-interval="8000">
                        <img src="https://images.pexels.com/photos/1396132/pexels-photo-1396132.jpeg"
                            class="d-block w-100" alt="...">
                        <h2 class="text-white carousel-text">Siamo presenti in tutto il mondo. Inizia la tua ricerca
                            adesso!</h2>
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
                            <div class="card-header">
                                <a href="" class="link-underline link-underline-opacity-0 text-white">
                                    {{ sponsored_house.title }}
                                </a>
                            </div>

                            <div class="card-body">
                                <img :src="'./img/' + sponsored_house.thumb" alt="Immagine Appartamento"
                                    class="img-fluid">
                                <div>
                                    {{ sponsored_house.price_per_night }}€
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="mt-3 d-flex justify-content-center align-items-baseline ">
                    <button class="m-1" @click="prevPage"
                        :disabled="sponsoredHousesData.current_page <= 1">Indietro</button>

                    <span v-if="sponsoredHousesData.current_page > 2">...</span>

                    <button v-if="sponsoredHousesData.current_page > 1" class="m-1"
                        @click="getSponsoredHouses(sponsoredHousesData.current_page - 1)">
                        {{ sponsoredHousesData.current_page - 1 }}
                    </button>

                    <button :class="{ 'm-1 selected active': currentPage == activeButton }"
                        @click="getSponsoredHouses(sponsoredHousesData.current_page)">
                        {{ sponsoredHousesData.current_page }}
                    </button>

                    <button v-if="sponsoredHousesData.current_page < sponsoredHousesData.last_page - 1" class="m-1"
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
                    <button v-if="currentPage == sponsoredHousesData.current_page" class="m-1 selected"
                        @click="getSponsoredHouses(sponsoredHousesData.current_page)"> {{
                            sponsoredHousesData.current_page }} </button>
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

.slide {
    img {
        height: 450px;
        object-fit: cover;
        position: relative;
    }

    .carousel-text {
        position: absolute;
        transform: translateY(-50%);
        top: 25%;
        left: 50%;
        transform: translateX(-50%);
        width: 50%;
        background-color: rgba($color: #000000, $alpha: 0.6);
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
</style>