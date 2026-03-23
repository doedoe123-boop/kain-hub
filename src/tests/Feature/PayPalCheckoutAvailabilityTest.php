<?php

use App\Models\GlobalSeoSetting;
use App\Models\User;

it('returns the PayPal checkout availability in the public seo settings payload', function () {
    GlobalSeoSetting::current()->update([
        'paypal_checkout_enabled' => false,
    ]);

    $this->getJson(route('api.v1.seo.global'))
        ->assertOk()
        ->assertJsonPath('paypal_checkout_enabled', false);
});

it('blocks PayPal order creation when checkout is disabled', function () {
    GlobalSeoSetting::current()->update([
        'paypal_checkout_enabled' => false,
    ]);

    $user = User::factory()->create();

    $this->actingAs($user)
        ->postJson(route('api.v1.paypal.create-order'))
        ->assertUnprocessable()
        ->assertJsonPath('errors.payment_method.0', 'PayPal checkout is temporarily unavailable.');
});
