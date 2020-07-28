/* tslint:disable: no-any */
declare const AdyenCheckout: any;
/* tslint:enable: no-any */

import Component from 'ShopUi/models/component';
import ScriptLoader from 'ShopUi/components/molecules/script-loader/script-loader';

export default class AdyenCreditCard extends Component {
    protected scriptLoader: ScriptLoader;
    protected cardNumberInput: HTMLInputElement;
    protected securityCodeInput: HTMLInputElement;
    protected expiryYearInput: HTMLInputElement;
    protected expiryMonthInput: HTMLInputElement;

    protected readyCallback(): void {}

    protected init(): void {
        this.cardNumberInput = <HTMLInputElement>this.querySelector(this.cardNumberSelector);
        this.securityCodeInput = <HTMLInputElement>this.querySelector(this.securityCodeSelector);
        this.expiryYearInput = <HTMLInputElement>this.querySelector(this.expiryYearSelector);
        this.expiryMonthInput = <HTMLInputElement>this.querySelector(this.expiryMonthSelector);
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
        const configuration = {
            locale: this.locale,
            environment: this.environment,
            originKey: this.originKey,
            paymentMethodsResponse: JSON.parse(this.paymentMethodsResponse),
            onChange: state => {
                if (state.isValid) {
                    this.cardNumberInput.value = state.data.paymentMethod.encryptedCardNumber;
                    this.securityCodeInput.value = state.data.paymentMethod.encryptedSecurityCode;
                    this.expiryYearInput.value = state.data.paymentMethod.encryptedExpiryYear;
                    this.expiryMonthInput.value = state.data.paymentMethod.encryptedExpiryMonth;
                }
            }
        };

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

    protected get cardNumberSelector(): string {
        return this.getAttribute('cart-number-selector');
    }

    protected get securityCodeSelector(): string {
        return this.getAttribute('security-code-selector');
    }

    protected get expiryYearSelector(): string {
        return this.getAttribute('expiry-year-selector');
    }

    protected get expiryMonthSelector(): string {
        return this.getAttribute('expiry-month-selector');
    }
}
