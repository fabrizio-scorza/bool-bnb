<script>
export default {
    props: ['houses', 'logged_user'],
    data() {
        return {}
    },
    methods: {
        isHidden(sponsored_house) {
            return !(sponsored_house.plans && sponsored_house.plans.length);
        },
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
                        <img src="https://www.produceshop.it/blog/wp-content/uploads/2021/09/MicrosoftTeams-image-54-930x620.jpg" class="d-block w-100 position-relative" alt="...">
                        <!-- <h2 class="position-absolute top-50 start-0 text-white">Questo è il nostro sito!</h2> -->
                        </div>
                        <div class="carousel-item" data-bs-interval="8000">
                        <img src="https://www.produceshop.it/blog/wp-content/uploads/2021/09/MicrosoftTeams-image-55-930x620.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item" data-bs-interval="8000">
                        <img src="https://www.produceshop.it/blog/wp-content/uploads/2021/09/MicrosoftTeams-image-56-930x620.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item" data-bs-interval="8000">
                        <img src="https://www.produceshop.it/blog/wp-content/uploads/2021/09/MicrosoftTeams-image-51-930x620.jpg" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <section class="searchbar">
        <div class="container">
            <h2>qui ci va la barra di ricerca</h2>
        </div>
    </section>
    <section class="sponsored">
        <div class="container">
            <div class="row row-gap-4">
                <div class="col-3 d-flex align-items-stretch justify-content-center" v-for="sponsored_house in houses"
                    :class="[isHidden(sponsored_house) ? 'hidden' : '']" :key="sponsored_house.id">
                    <div v-if="sponsored_house.plans && sponsored_house.plans.length">
                        <div v-for="plan in sponsored_house.plans" :key="plan.id">

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
                </div>
            </div>
        </div>
    </section>

</template>

<style lang="scss" scoped>
.hidden {
    display: none !important;
}

.slide{
width: 800px;
}
</style>