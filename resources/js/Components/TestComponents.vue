<!-- <script>
import tt from "@tomtom-international/web-sdk-maps"

export default {
    data() {
        return {
            map,
        }
    },

    mounted() {
        this.initMap();
    },
    methods: {
        initMap() {
            let center = [14, 42.4]
            this.map = tt.map({
                key: "0GaJeIIm0LI9Q7jst1IQIUzSO9jDa8m6",
                container: "map",
                center: center,
                zoom: 10
            });

            this.map.on('load', () => {
                new tt.Marker().setLngLat(center).addTo(this.map)
            })
        }
    }
}



</script>

<template>
    <div id="map" class="map" style="width:600px; height: 400px"></div>
</template> -->