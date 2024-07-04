<script>
import { store } from "../store";
import tt from "@tomtom-international/web-sdk-maps"

export default {
    props: ['house'],
    data() {
        return {
        }
    },

    mounted() {
        this.loadMap();
    },
    methods: {
        loadMap() {
            const latitude = this.house.latitude;
            const longitude = this.house.longitude;

            const map = tt.map({
                key: store.api_key,
                container: "map",
                center: [longitude, latitude],
                zoom: 12
            })
            const marker = new tt.Marker().setLngLat([longitude, latitude]).addTo(map)

            map.addControl(new tt.NavigationControl(), 'top-right')
        }
    }
}



</script>

<template>
    <div class="container mb-3">
        <div id="map"></div>
    </div>

</template>

<style lang="scss" scoped>
#map {
    width: 100%;
    height: 400px;
}
</style>
