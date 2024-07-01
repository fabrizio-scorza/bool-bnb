<script>
import { store } from '../store';
import axios from 'axios';
delete axios.defaults.headers.common['X-Requested-With'];
export default {

    data() {
        return {
            store,
            address: "",
            latitude: 0,
            longitude: 0
        }
    },

    methods: {
        fetchData(fetchAdderess) {
            axios.get(`https://api.tomtom.com/search/2/geocode/${fetchAdderess}.json?key=${store.api_key}&typehead=true`).then((res) => {
                store.addresses = res.data.results
                console.log(res.data.results)
            })
        },
        setValue(value_address) {
            this.address = value_address;
            this.fetchData(value_address);

        }
    }
}

</script>

<template>
    <div class="form-group">
        <label for="address">Inserici l'indirizzo</label>
        <input type="search" v-model="address" class="form-control" id="address"
            placeholder="indirizzo del tuo alloggio" name="address" maxlength="255" @keyup="fetchData(address)">
        <div class="form-control">
            <ul class="list-unstyled">
                <li v-for="address in store.addresses" @click="setValue(address.address.freeformAddress)" class="value">
                    {{ address.address.freeformAddress }}
                </li>
            </ul>
        </div>
    </div>
    <div>

    </div>
</template>

<style lang="scss" scoped>
.value {
    cursor: pointer;
}
</style>
