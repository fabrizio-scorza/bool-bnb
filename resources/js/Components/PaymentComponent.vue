<template>
    <div>
        <div id="dropin-container"></div>
        <button @click="pay" :disabled="isProcessing">Pay {{ amount }}</button>
    </div>
</template>

<script>
import dropin from 'braintree-web-drop-in';

export default {
    props: {
        amount: {
            type: Number,
            required: true
        }
    },
    data() {
        return {
            clientToken: null,
            dropinInstance: null,
            isProcessing: false,
        };
    },
    mounted() {
        this.getClientToken();
    },
    methods: {
        async getClientToken() {
            try {
                const response = await fetch('/braintree/token');
                const data = await response.json();
                this.clientToken = data.token;
                this.initializeDropin();
            } catch (error) {
                console.error('Error fetching client token:', error);
            }
        },
        initializeDropin() {
            dropin.create({
                authorization: this.clientToken,
                container: '#dropin-container',
            }, (err, instance) => {
                if (err) {
                    console.error('Error creating Drop-in:', err);
                    return;
                }
                this.dropinInstance = instance;
            });
        },
        async pay() {
            if (!this.dropinInstance) return;

            this.isProcessing = true;
            try {
                const payload = await this.dropinInstance.requestPaymentMethod();
                const response = await fetch('/braintree/checkout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        payment_method_nonce: payload.nonce,
                        amount: this.amount // Utilizza la prop amount
                    }),
                });
                const data = await response.json();
                if (data.success) {
                    alert('Payment successful!');
                } else {
                    alert(`Payment failed: ${data.error}`);
                }
            } catch (error) {
                console.error('Payment error:', error);
                alert('Payment failed');
            } finally {
                this.isProcessing = false;
            }
        }
    }
};
</script>
