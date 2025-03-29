<?php

namespace App\Services\Payment;

use App\DTO\Payment\IyzicoPaymentDTO;
use Iyzipay\Options;
use Iyzipay\Request\CreatePayWithIyzicoInitializeRequest;
use Iyzipay\Request\RetrievePayWithIyzicoRequest;
use Iyzipay\Request\CreateCheckoutFormInitializeRequest;
use Iyzipay\Request\RetrieveCheckoutFormRequest;
use Iyzipay\Model\PayWithIyzicoInitialize;
use Iyzipay\Model\PayWithIyzico;
use Iyzipay\Model\CheckoutFormInitialize;
use Iyzipay\Model\CheckoutForm;
use Iyzipay\Model\Locale;
use Iyzipay\Model\Currency;
use Iyzipay\Model\BasketItem;
use Iyzipay\Model\Address;
use Iyzipay\Model\Buyer;
use Iyzipay\Model\PaymentGroup;
use Iyzipay\Model\BasketItemType;
use App\DTO\CartProductDTO;

class PaymentService
{
    private $options;

    public function __construct()
    {
        $this->options = new Options();
        $this->options->setApiKey(config('services.iyzico.api_key'));
        $this->options->setSecretKey(config('services.iyzico.secret_key'));
        $this->options->setBaseUrl(config('services.iyzico.base_url'));
    }

    public function initializePayWithIyzico(IyzicoPaymentDTO $orderData)
    {
        $request = new CreatePayWithIyzicoInitializeRequest();
        $request->setLocale(Locale::EN);
        $request->setConversationId($orderData->conversationId);
        $request->setPrice($orderData->price);
        $request->setPaidPrice($orderData->price);
        $request->setCurrency(Currency::TL);
        $request->setBasketId($orderData->cartId);
        $request->setPaymentGroup(PaymentGroup::PRODUCT);
        $request->setCallbackUrl($orderData->callbackUrl);
        $request->setEnabledInstallments([2, 3, 6, 9]);

        //Client shipping address
        $shippingAddress = new Address();
        $shippingAddress->setCountry('Türkiye');
        $shippingAddress->setCity($orderData->buyerAddresses->shippingAddress->province->name);
        $shippingAddress->setAddress($orderData->buyerAddresses->shippingAddress->address_line1);
        $shippingAddress->setContactName($orderData->buyer->name);
        $shippingAddress->setZipCode($orderData->buyerAddresses->shippingAddress->zip);
        $request->setShippingAddress($shippingAddress);

        $billingAddress = new Address();
        $billingAddress->setCountry('Türkiye');
        $billingAddress->setCity($orderData->buyerAddresses->billingAddress->province->name);
        $billingAddress->setAddress($orderData->buyerAddresses->billingAddress->address_line1);
        $billingAddress->setContactName($orderData->buyer->name);
        $billingAddress->setZipCode($orderData->buyerAddresses->billingAddress->zip);
        $request->setBillingAddress($billingAddress);

        // Buyer information
        $buyer = new Buyer();
        $buyer->setId($orderData->buyer->id);
        $buyer->setName($orderData->buyer->name);
        $buyer->setSurname($orderData->buyer->lastName);
        $buyer->setEmail($orderData->buyer->email);
        $buyer->setGsmNumber($orderData->buyer->phone);
        $buyer->setIdentityNumber($orderData->buyer->identityNumber);
        $buyer->setRegistrationAddress($orderData->buyer->registrationAddress);
        $buyer->setIp($orderData->buyer->ip);
        $buyer->setCity($orderData->buyer->city);
        $buyer->setCountry($orderData->buyer->country);
        $request->setBuyer($buyer);

        // Basket items
        $basketItems = [];
        foreach ($orderData->shoppingCart->getProducts() as $item) {
            /**@var CartProductDTO $item */
            $basketItem = new BasketItem();
            $basketItem->setId($item->id);
            $basketItem->setName($item->name);
            $basketItem->setCategory1('Auto part');
            $basketItem->setItemType(BasketItemType::PHYSICAL);
            $basketItem->setPrice($item->discountedPrice * $item->amount);
            $basketItems[] = $basketItem;
        }
        $request->setBasketItems($basketItems);

        return PayWithIyzicoInitialize::create($request, $this->options);
    }

    public function retrievePayWithIyzicoPayment($token)
    {
        $request = new RetrievePayWithIyzicoRequest();
        $request->setLocale(Locale::EN);
        $request->setToken($token);

        return PayWithIyzico::retrieve($request, $this->options);
    }

    public function initializeCheckoutForm(IyzicoPaymentDTO $orderData): CheckoutFormInitialize
    {
        $request = new CreateCheckoutFormInitializeRequest();
        $request->setLocale(Locale::TR);
        $request->setPrice($orderData->price);
        $request->setPaidPrice($orderData->price);
        $request->setCurrency(Currency::TL);
        $request->setCallbackUrl($orderData->callbackUrl);
        $request->setPaymentGroup(PaymentGroup::PRODUCT);

        return CheckoutFormInitialize::create($request, $this->options);
    }

    public function retrieveCheckoutFormPayment($token)
    {
        $request = new RetrieveCheckoutFormRequest();
        $request->setLocale(Locale::EN);
        $request->setToken($token);

        return CheckoutForm::retrieve($request, $this->options);
    }
}
