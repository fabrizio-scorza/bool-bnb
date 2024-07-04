<script>
import { store } from '../store';
export default {
    props: ['houses', 'logged_user'],
    data() {
        return {
            store,
            closeHouses: [],
            currentSlideIndex: 0,
            sponsored_houses: [],
        }
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
    },
    methods: {
        showPrevSlide() {
            this.currentSlideIndex = (this.currentSlideIndex === 0) ? this.sponsored_houses.length - 1 : this.currentSlideIndex - 1;
        },
        showNextSlide() {
            this.currentSlideIndex = (this.currentSlideIndex === this.sponsored_houses.length - 1) ? 0 : this.currentSlideIndex + 1;
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
    <section class="carousel">
        <div class="container">
            <div class="d-flex justify-content-center">
                <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active" data-bs-interval="8000">
                            <img src="https://www.produceshop.it/blog/wp-content/uploads/2021/09/MicrosoftTeams-image-54-930x620.jpg"
                                class="d-block w-100 position-relative" alt="...">
                            <!-- <h2 class="position-absolute top-50 start-0 text-white">Questo è il nostro sito!</h2> -->
                        </div>
                        <div class="carousel-item" data-bs-interval="8000">
                            <img src="https://www.produceshop.it/blog/wp-content/uploads/2021/09/MicrosoftTeams-image-55-930x620.jpg"
                                class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item" data-bs-interval="8000">
                            <img src="https://www.produceshop.it/blog/wp-content/uploads/2021/09/MicrosoftTeams-image-56-930x620.jpg"
                                class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item" data-bs-interval="8000">
                            <img src="https://www.produceshop.it/blog/wp-content/uploads/2021/09/MicrosoftTeams-image-51-930x620.jpg"
                                class="d-block w-100" alt="...">
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
        </div>
    </section>
    <section class="searchbar">
        <div class="container">
            <address-component></address-component>
            <a href="#search" @click="searchHouses(houses)">Cerca</a>
        </div>
    </section>
    <!-- <section class="sponsored">
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
                                <img :src="sponsored_house.thumb" alt="Immagine Appartamento">
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
                <div id="#search" class="col-3 d-flex align-items-stretch" v-for="house in closeHouses" :key="house.id">
                    <div class="card flex-fill">
                        <div class="card-header">
                            <a href="" class="link-underline link-underline-opacity-0">
                                {{ house.title }}
                            </a>
                        </div>

                        <div class="card-body">
                            <img :src="house.thumb" alt="Immagine Appartamento">
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
    </section> -->

    <section class="sponsored">
        <div class="container">
            <div class="row row-gap-4 position-relative">


                <div class="col-4 d-flex align-items-stretch" v-for="(sponsored_house, index) in sponsored"
                    :key="sponsored_house.id"
                    :class="(index === currentSlideIndex || index === currentSlideIndex + 1 || index === currentSlideIndex + 2) ? 'active' : 'hidden'">
                    <div class="card flex-fill">
                        <div class="card-header">
                            <a href="" class="link-underline link-underline-opacity-0">
                                {{ sponsored_house.title }}
                            </a>
                        </div>

                        <div class="card-body">
                            <img :src="sponsored_house.thumb" alt="Immagine Appartamento">
                            <div>
                                {{ sponsored_house.price_per_night }}€
                            </div>
                        </div>


                    </div>
                </div>
                <button class="carousel-control-prev" @click="showPrevSlide">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" @click="showNextSlide">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <!-- <div v-for="(sponsored_house, index) in houses"
                :class="[isHidden(sponsored_house) ? 'hidden' : '', (index === currentSlideIndex) ? 'active' : 'hidden']"
                :key="sponsored_house.id">
                {{ sponsored_house.title }}

            </div> -->

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
    width: 800px;
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
}
</style>