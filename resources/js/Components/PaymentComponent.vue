<template>
    <div  class="container d-flex justify-content-center">
        <div class="text-center">
            <div  id="dropin-container"></div>
            <button v-if="amount > 0 " @click="pay" :disabled="isProcessing">Paga {{ amount }}€</button>
        </div>
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
                translations: {
                    'it_IT': {
                        'card': {
                            'cardholderName': 'Nome sulla carta',
                            'cardNumber': 'Numero di carta',
                            'cvv': 'CVV',
                            'expirationDate': 'Data di scadenza',
                            'submit': 'Paga adesso'
                        },
                        'paypal': {
                            'payWithPayPal': 'Paga con PayPal'
                        },
                        'applePay': {
                            'payWithApplePay': 'Paga con Apple Pay'
                        }
                    }
                },
                locale: 'it_IT',
                card: {
                    cardholderName: {
                        required: true
                    },
                    overrides: {
                        fields: {
                            number: {
                                styles: {
                                    'input': {
                                        'font-size': '16px',
                                        'color': '#333'
                                    },
                                    ':focus': {
                                        'color': '#333'
                                    }
                                }
                            },
                            cvv: {
                                styles: {
                                    'input': {
                                        'font-size': '16px',
                                        'color': '#333'
                                    }
                                }
                            },
                            expirationDate: {
                                styles: {
                                    'input': {
                                        'font-size': '16px',
                                        'color': '#333'
                                    }
                                }
                            }
                        }
                    }
                }
            }, (err, instance) => {
                if (err) {
                    console.error('Error creating Drop-in:', err);
                    return;
                }
                this.dropinInstance = instance;
                this.addPrivacyStatement();
            });
        },
        addPrivacyStatement() {
            const expirationDateField = document.querySelector('.braintree-expiration');
            if (expirationDateField) {
                const privacyStatement = document.createElement('p');
                privacyStatement.textContent = "Pagando con la carta, accetto la Dichiarazione sulla privacy di PayPal.";
                privacyStatement.style.fontSize = '12px';
                privacyStatement.style.color = '#666';
                privacyStatement.style.marginTop = '10px';
                expirationDateField.parentNode.insertBefore(privacyStatement, expirationDateField.nextSibling);
            }
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
                    alert('Pagamento andato a buon fine');
                } else {
                    alert(`Non è stato possibile effettuare il pagamento: ${data.error}`);
                }
            } catch (error) {
                console.error('Payment error:', error);
                alert('Non è stato possibile effettuare il pagamento');
            } finally {
                this.isProcessing = false;
            }
        }
    }
};
</script>

<style>

    #dropin-container{
        max-width: 500px;
    }

</style>