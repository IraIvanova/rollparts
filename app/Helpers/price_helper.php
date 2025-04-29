<?php

use Illuminate\Support\HtmlString;

if (!function_exists('price_display')) {
    function price_display(float $discountedPrice, float $price, string $context = 'default', int $discount = 0): HtmlString
    {
        $currency = config('app.currency_symbol');
        $priceFormatted = number_format($price, 2);
        $discountedFormatted = number_format($discountedPrice, 2);

        $isDiscounted = $price !== $discountedPrice;

        return match ($context) {
            'product' => getProductPriceHTML($priceFormatted, $discountedFormatted, $currency, $isDiscounted),
            'cart' => getCartPriceHTML($priceFormatted, $discountedFormatted, $currency, $isDiscounted),
            'checkout' => getCheckoutPriceHTML($priceFormatted, $discountedFormatted, $currency, $isDiscounted, $discount),
            default => getDefaultPriceHTML($priceFormatted, $discountedFormatted, $currency, $isDiscounted),
        };
    }
}

if (!function_exists('bank_transfer_discount_display')) {
    function bank_transfer_discount_display(bool $isDiscounted, float $price): HtmlString
    {
        $currency = config('app.currency_symbol');
        $priceFormatted = number_format($price - $price * 0.05, 2);
        $label = __('interface.product.bankTransferDiscount');

        return getBankTransferDiscountHTML($isDiscounted, $priceFormatted, $currency, $label);
    }
}

if (!function_exists('render_order_review_with_credit_card')) {
    function render_order_review_with_credit_card(array $product): HtmlString
    {
        return new HtmlString();
    }
}

if (!function_exists('render_order_review_with_bank_transfer')) {
    function render_order_review_with_bank_transfer(float $price): HtmlString
    {
        $currency = config('app.currency_symbol');
        $priceFormatted = number_format($price - $price * 0.05, 2);

        return new HtmlString("
            <h5 class='d-none bank-transfer-applied'>" . __('interface.checkout.bankTransfer.discount') . "<span class='rp-checkout-order-price'><span
                            class='rp-Price-amount amount'>{$currency}{$priceFormatted}</span></span>
            </h5>
        ");
    }
}

function getProductPriceHTML(string $price, string $discounted, string $currency, bool $isDiscounted): HtmlString
{
    return new HtmlString(
        $isDiscounted
            ? "<span class='rp-Price-amount amount color-red'><span class='rp-currencySymbol'>{$currency}</span>{$discounted}</span>
                <span class='rp-Price-amount amount px-2 color-grey line-through font-size-20px'><span class='rp-currencySymbol'>{$currency}</span>{$price}</span>"
            : "<span class='rp-Price-amount amount'><span class='rp-currencySymbol'>{$currency}</span>{$price}</span>"
    );
}

function getCartPriceHTML(string $price, string $discounted, string $currency, bool $isDiscounted): HtmlString
{
    return new HtmlString(
        $isDiscounted
            ? "<div><small class='text-muted'>{$currency}{$price}</small><strong class='ml-2'>{$currency}{$discounted}</strong></div>"
            : "<div><strong>{$currency}{$price}</strong></div>"
    );
}

function getCheckoutPriceHTML(string $price, string $discounted, string $currency, bool $isDiscounted, int $discount = 0): HtmlString
{
    if ($discount > 0 && !$isDiscounted) {
        $discounted = number_format($price - $price * ($discount / 100), 2);

        return new HtmlString("
                        <span class='rp-checkout-order-price product-total'>
                        <span class='rp-Price-amount amount px-2 color-grey line-through'><span
                                class='rp-currencySymbol'>{$currency}</span>{$price}</span>
                        <span class='rp-Price-amount amount'><span class='rp-currencySymbol'>{$currency}</span>{$discounted}</span>
                        </span>");
    }

    return new HtmlString(
        $isDiscounted
            ? "<span class='rp-checkout-order-price product-total'>
                        <span class='rp-Price-amount amount px-2 color-grey line-through'><span
                                class='rp-currencySymbol'>{$currency}</span>{$price}</span>
                        <span class='rp-Price-amount amount'><span class='rp-currencySymbol'>{$currency}</span>{$discounted}</span>
                        </span>"
            : "<span class='rp-checkout-order-price product-total'><span class='rp-Price-amount amount'><span class='rp-currencySymbol'>{$currency}</span>{$price}</span></span>"
    );
}

function getDefaultPriceHTML(string $price, string $discounted, string $currency, bool $isDiscounted): HtmlString
{
    return new HtmlString(
        $isDiscounted
            ? "<span class='old'>{$currency}{$price}</span> <span class='new'>{$currency}{$discounted}</span>"
            : "<span class='normal'>{$currency}{$price}</span>"
    );
}

function getBankTransferDiscountHTML(bool $isDiscounted, string $price, string $currency, string $label): HtmlString
{
    return new HtmlString($isDiscounted ? "
    <div class='d-flex flex-column border-red width-fit-content mt-3'><div class='px-2 py-1 batch-primary'>{$label}</div>
                                                <div class='rp-Price-amount amount color-red text-center'>{$currency} {$price}</div></div>"
    : '');
}
