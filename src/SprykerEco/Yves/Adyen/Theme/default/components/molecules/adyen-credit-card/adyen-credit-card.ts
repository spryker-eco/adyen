/* tslint:disable:no-any */
declare var csf: any;
/* tslint:enable:no-any */

import Component from 'ShopUi/models/component';
import ScriptLoader from 'ShopUi/components/molecules/script-loader/script-loader';

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

export default class AdyenCreditCard extends Component {
    protected scriptLoader: ScriptLoader;

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

    /* tslint:disable:no-any */
    protected gethostedIframesConfig(): any {
    /* tslint:enable:no-any */
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
        };
    }

    /* tslint:disable:no-any */
    protected get stylesIframesConfig(): any {
    /* tslint:enable:no-any */
        return {
            ...stylesConfig
        };
    }

    protected get configKey(): string {
        return this.getAttribute('client-config-key');
    }
}
