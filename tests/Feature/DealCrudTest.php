<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Deal;
use App\Models\Lead;
use App\Models\LeadAction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DealCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Lead $lead;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->lead = Lead::query()->create(['name' => 'Test Lead', 'phone' => '+1234567890']);
    }

    public function test_guest_is_redirected_from_deals_index(): void
    {
        $this->get(route('deals.index'))->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_create_deal(): void
    {
        $response = $this->actingAs($this->user)->post(route('deals.store'), [
            'lead_id' => $this->lead->id,
            'product_service' => 'Web Design',
            'budget' => 5000,
            'status' => 'new',
            'notes' => 'Initial deal',
        ]);

        $deal = Deal::query()->first();
        $this->assertNotNull($deal);
        $response->assertRedirect(route('deals.show', $deal));
        $this->assertDatabaseHas('deals', ['product_service' => 'Web Design', 'lead_id' => $this->lead->id]);
    }

    public function test_deal_creation_requires_lead(): void
    {
        $this->actingAs($this->user)
            ->post(route('deals.store'), [
                'product_service' => 'Web Design',
                'budget' => 5000,
                'status' => 'new',
            ])
            ->assertSessionHasErrors(['lead_id']);
    }

    public function test_authenticated_user_can_update_deal(): void
    {
        $deal = Deal::query()->create([
            'lead_id' => $this->lead->id,
            'product_service' => 'Old Product',
            'budget' => 1000,
            'status' => 'new',
        ]);

        $this->actingAs($this->user)
            ->put(route('deals.update', $deal), [
                'lead_id' => $this->lead->id,
                'product_service' => 'New Product',
                'budget' => 2000,
                'status' => 'won',
            ])
            ->assertRedirect(route('deals.show', $deal));

        $this->assertDatabaseHas('deals', ['id' => $deal->id, 'product_service' => 'New Product', 'status' => 'won']);
    }

    public function test_authenticated_user_can_delete_deal(): void
    {
        $deal = Deal::query()->create([
            'lead_id' => $this->lead->id,
            'product_service' => 'Delete Deal',
            'budget' => 1000,
            'status' => 'new',
        ]);
        LeadAction::query()->create([
            'deal_id' => $deal->id,
            'type' => 'call',
            'scheduled_at' => now(),
        ]);

        $this->actingAs($this->user)
            ->delete(route('deals.destroy', $deal))
            ->assertRedirect(route('deals.index'));

        $this->assertDatabaseMissing('deals', ['id' => $deal->id]);
        $this->assertDatabaseMissing('lead_actions', ['deal_id' => $deal->id]);
    }

    public function test_deals_index_filters_by_status(): void
    {
        Deal::query()->create(['lead_id' => $this->lead->id, 'product_service' => 'Open Deal', 'budget' => 1000, 'status' => 'new']);
        Deal::query()->create(['lead_id' => $this->lead->id, 'product_service' => 'Won Deal', 'budget' => 2000, 'status' => 'won']);

        $this->actingAs($this->user)
            ->get(route('deals.index', ['status' => 'won']))
            ->assertOk()
            ->assertSee('Won Deal')
            ->assertDontSee('Open Deal');
    }
}
