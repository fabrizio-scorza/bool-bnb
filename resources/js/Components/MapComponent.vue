<script>
import tt from "@tomtom-international/web-sdk-maps"

export default {
    data() {
        return {
        }
    },

    mounted() {
        this.loadMap();
    },
    methods: {
        loadMap() {
            const latitude = 41.87;
            const longitude = 12.47;

            const map = tt.map({
                key: "0GaJeIIm0LI9Q7jst1IQIUzSO9jDa8m6",
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
    width: 600px;
    height: 400px;
}
</style>
