<script>
export default {
    props: ['houses', 'logged_user'],
    data() {
        return {}
    },
}
</script>

<template>
    <section class="carousel">
        <div class="container">
            <h2>qui ci va il carosello</h2>
        </div>
    </section>
    <section class="searchbar">
        <div class="container">
            <h2>qui ci va la barra di ricerca</h2>
        </div>
    </section>
    <section class="sponsored">
        <div class="container">
            <div class="row row-cols-3">
                <div v-for="sponsored_house in houses" :key="sponsored_house.id">
                    <div v-if="sponsored_house.plans && sponsored_house.plans.length">
                        <div v-for="plan in sponsored_house.plans" :key="plan.id">
                            <div class="col d-flex align-items-stretch">

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
                                            <button data-bs-toggle="modal" data-bs-target="#modal-{{$house->id}}"
                                                class="">
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
        </div>
    </section>

</template>

<style lang="scss" scoped></style>