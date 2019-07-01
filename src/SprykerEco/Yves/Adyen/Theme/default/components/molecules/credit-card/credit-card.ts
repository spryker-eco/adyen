declare var csf: any;

import Component from 'ShopUi/models/component';
import ScriptLoader from 'ShopUi/components/molecules/script-loader/script-loader';

// Define a custom style.
const stylesConfig = {
    base: {
        color: '#333',
        fontSize: '14px',
        fontSmoothing: 'antialiased',
        fontFamily: 'Helvetica'
    },
    error: {
        color: '#b2171a'
    },
    placeholder: {
        color: '#d8d8d8'
    },
    validated: {
        color: '#4fc2a0'
    }
};

export default class CreditCard extends Component {
    scriptLoader: ScriptLoader

    protected readyCallback(): void {
        this.scriptLoader = <ScriptLoader>this.querySelector('script-loader');

        this.mapEvents();
    }

    protected mapEvents(): void {
        this.scriptLoader.addEventListener('scriptload', (event: Event) => this.onScriptLoad(event));
    }

    protected onScriptLoad(event: Event): void {
        this.initIframes();
    }

    protected initIframes(): void {
        const securedFields = csf(this.gethostedIframesConfig());
    }

    protected gethostedIframesConfig(): any {
        return {
            configObject : {
                originKey : this.configKey
            },
            rootNode: `.${this.jsName}__form`,
            paymentMethods : {
                card : {
                    sfStyles : this.stylesIframesConfig,
                    placeholders: {
                        hostedCardNumberField : '4111 1111 1111 1111',
                        hostedExpiryDateField : '08/18',
                        hostedSecurityCodeField : '737'
                    }
                }
            }
        }
    }

    get stylesIframesConfig(): any {
        return {
            ...stylesConfig
        }
    }

    get configKey(): string {
        return this.getAttribute('client-config-key');
    }
}