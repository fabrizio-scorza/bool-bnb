<script>
import { store } from '../store';
import axios from 'axios';
delete axios.defaults.headers.common['X-Requested-With'];

export default {
    emits: ['coordinates-updated'],
    props: {
        initialAddress: {
            type: String,
            default: ''
        },
        initialLatitude: {
            type: Number,
            default: 0
        },
        initialLongitude: {
            type: Number,
            default: 0
        }
    },
    data() {
        return {
            store,
            address: this.initialAddress,
            latitude: this.initialLatitude,
            longitude: this.initialLongitude,
            setVisible: false,
            activeIndex: null,
        }
    },
    methods: {
        fetchData(fetchAdderess) {
            this.setVisible = true;
            axios.get(`https://api.tomtom.com/search/2/geocode/${fetchAdderess}.json?key=${store.api_key}&typehead=true`).then((res) => {
                store.addresses = res.data.results
                sessionStorage.setItem('addresses', store.addresses);

                

                if (res.data.results.length > 0) {

                    this.latitude = res.data.results[0].position.lat
                    this.longitude = res.data.results[0].position.lon
                    sessionStorage.setItem('latitude', this.latitude);
                    sessionStorage.setItem('longitude', this.longitude);
                }
            });
        },
        setValue(value_address) {
            sessionStorage.setItem('address', value_address);
            this.address = value_address;
            this.fetchData(value_address);
            this.setVisible = false;
        },
        hiddenOnDelete() {
            if (this.address == '') {
                this.setVisible = false;
            }
        },
        setActive(index) {
            this.activeIndex = index;
        },
        clearActive() {
            this.activeIndex = null;
        }
    }
}


</script>

<template>
    <div class="position-relative">
        <input type="search" required v-model="address" class="form-control" id="address"
            placeholder="Via Nazionale 1, Roma" name="address" maxlength="255" @keyup="fetchData(address)"
            @keyup.delete="hiddenOnDelete()" @keyup.esc="hiddenOnDelete()">
        <div :class="setVisible ? 'is-visible' : 'not-visible'" class="form-control position-absolute z-1">
            <ul class="list-unstyled">
                <li v-for="(address, index) in store.addresses" @click="setValue(address.address.freeformAddress)" class="value"
                    @mouseenter="setActive(index)"
                    @mouseleave="clearActive"
                    :class="{'bg-light-gray': activeIndex === index}">
                    {{ address.address.freeformAddress }}
                </li>
            </ul>
        </div>
        <div class="form-group mb-4 ">
            <input type="hidden" id="latitude" name="latitude" readonly :value="latitude">
            <input type="hidden" id="longitude" name="longitude" readonly :value="longitude">
        </div>
    </div>
</template>

<style lang="scss" scoped>
.value {
    cursor: pointer;

}

.is-visible {
    display: block;
}

.not-visible {
    display: none;
}

.bg-light-gray {
    background-color: lightgray;
}
</style>
