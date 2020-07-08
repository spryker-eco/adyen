/* tslint:disable: no-any */
declare const AdyenCheckout: any;
/* tslint:enable: no-any */

import Component from 'ShopUi/models/component';
import ScriptLoader from 'ShopUi/components/molecules/script-loader/script-loader';

export default class AdyenCreditCard extends Component {
    protected scriptLoader: ScriptLoader;

    protected readyCallback(): void {}

    protected init(): void {
        this.scriptLoader = <ScriptLoader>this.getElementsByClassName(`${this.jsName}__script-loader`)[0];

        this.mapEvents();
    }

    protected mapEvents(): void {
        this.onScriptLoad();
    }

    protected onScriptLoad(): void {
        this.scriptLoader.addEventListener('scriptload', () => this.createCheckout());
    }

    protected createCheckout(): void {
        /* tslint:disable: no-unused-expression */
        const configuration = {
            locale: this.locale,
            environment: this.environment,
            originKey: this.originKey,
            paymentMethodsResponse: JSON.parse(this.paymentMethodsResponse),
            onChange: (state, component) => {
                state.isValid;
                state.data;
                component;
            },
            onAdditionalDetails: (state, component) => {
                state.data;
                component;
            }
        };
        /* tslint:disable: no-unused-expression */

        const checkout = new AdyenCheckout(configuration);
        checkout.create('card').mount(`#${this.containerId}`);
    }

    protected get originKey(): string {
        return this.getAttribute('origin-key');
    }

    protected get paymentMethodsResponse(): string {
        return this.getAttribute('payment-methods-response');
    }

    protected get containerId(): string {
        return this.getAttribute('container-id');
    }

    protected get locale(): string {
        return this.getAttribute('locale');
    }

    protected get environment(): string {
        return this.getAttribute('environment');
    }
}
