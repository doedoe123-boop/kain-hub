<?php

use App\Models\Faq;
use App\Models\User;

describe('FAQ Model', function () {

    it('has correct fillable attributes', function () {
        $faq = new Faq;

        expect($faq->getFillable())->toBe([
            'question',
            'answer',
            'is_active',
            'sort_order',
        ]);
    });

    it('casts is_active to boolean', function () {
        $faq = Faq::factory()->create(['is_active' => 1]);

        expect($faq->is_active)->toBeTrue()->and($faq->is_active)->toBeBool();
    });

    it('casts sort_order to integer', function () {
        $faq = Faq::factory()->create(['sort_order' => '5']);

        expect($faq->sort_order)->toBe(5)->and($faq->sort_order)->toBeInt();
    });

    it('defaults to active', function () {
        $faq = Faq::factory()->create();

        expect($faq->is_active)->toBeTrue();
    });

    it('can be created with factory', function () {
        $faq = Faq::factory()->create();

        expect($faq)->toBeInstanceOf(Faq::class)
            ->and($faq->question)->not->toBeEmpty()
            ->and($faq->answer)->not->toBeEmpty();
    });

    it('supports inactive factory state', function () {
        $faq = Faq::factory()->inactive()->create();

        expect($faq->is_active)->toBeFalse();
    });
});

describe('FAQ Active Scope', function () {

    it('returns only active FAQs', function () {
        Faq::factory()->count(3)->create(['is_active' => true]);
        Faq::factory()->count(2)->inactive()->create();

        $active = Faq::active()->get();

        expect($active)->toHaveCount(3);
    });

    it('orders by sort_order ascending', function () {
        Faq::factory()->create(['sort_order' => 3, 'is_active' => true]);
        Faq::factory()->create(['sort_order' => 1, 'is_active' => true]);
        Faq::factory()->create(['sort_order' => 2, 'is_active' => true]);

        $faqs = Faq::active()->get();

        expect($faqs->pluck('sort_order')->all())->toBe([1, 2, 3]);
    });

    it('excludes inactive FAQs', function () {
        Faq::factory()->create(['is_active' => true, 'question' => 'Visible']);
        Faq::factory()->create(['is_active' => false, 'question' => 'Hidden']);

        $faqs = Faq::active()->get();

        expect($faqs)->toHaveCount(1)
            ->and($faqs->first()->question)->toBe('Visible');
    });
});

describe('FAQ Homepage Display', function () {

    it('shows FAQs section on homepage when FAQs exist', function () {
        Faq::factory()->count(3)->create(['is_active' => true]);

        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertSee('Frequently Asked Questions');
    });

    it('hides FAQs section when no active FAQs exist', function () {
        Faq::factory()->count(2)->inactive()->create();

        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertDontSee('Frequently Asked Questions');
    });

    it('displays FAQ questions on the homepage', function () {
        Faq::factory()->create([
            'question' => 'How do I register my store?',
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertSee('How do I register my store?');
    });

    it('does not display inactive FAQs on homepage', function () {
        Faq::factory()->create([
            'question' => 'This should be visible',
            'is_active' => true,
        ]);
        Faq::factory()->create([
            'question' => 'This should be hidden',
            'is_active' => false,
        ]);

        $response = $this->get('/');

        $response->assertSee('This should be visible')
            ->assertDontSee('This should be hidden');
    });
});

describe('FAQ Admin Resource', function () {

    it('prevents guest access to FAQ admin', function () {
        $this->get(adminPath().'/faqs')
            ->assertRedirect();
    });

    it('allows admin to access FAQ list', function () {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(adminPath().'/faqs')
            ->assertSuccessful();
    });

    it('allows admin to access FAQ creation page', function () {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(adminPath().'/faqs/create')
            ->assertSuccessful();
    });
});
