<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Deal;
use App\Models\Lead;
use App\Models\LeadAction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadActionCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Deal $deal;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $lead = Lead::query()->create(['name' => 'Test Lead', 'phone' => '+1234567890']);
        $this->deal = Deal::query()->create([
            'lead_id' => $lead->id,
            'product_service' => 'Test Product',
            'budget' => 1000,
            'status' => 'new',
        ]);
    }

    public function test_guest_is_redirected_from_actions_index(): void
    {
        $this->get(route('actions.index'))->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_create_action(): void
    {
        $scheduledAt = now()->addDay()->format('Y-m-d\TH:i');

        $response = $this->actingAs($this->user)->post(route('actions.store'), [
            'deal_id' => $this->deal->id,
            'type' => 'call',
            'scheduled_at' => $scheduledAt,
            'notes' => 'Follow up call',
        ]);

        $action = LeadAction::query()->first();
        $this->assertNotNull($action);
        $response->assertRedirect(route('actions.show', $action));
        $this->assertDatabaseHas('lead_actions', ['deal_id' => $this->deal->id, 'type' => 'call']);
    }

    public function test_action_creation_requires_deal(): void
    {
        $this->actingAs($this->user)
            ->post(route('actions.store'), [
                'type' => 'call',
                'scheduled_at' => now()->format('Y-m-d\TH:i'),
            ])
            ->assertSessionHasErrors(['deal_id']);
    }

    public function test_authenticated_user_can_update_action(): void
    {
        $action = LeadAction::query()->create([
            'deal_id' => $this->deal->id,
            'type' => 'call',
            'scheduled_at' => now(),
        ]);

        $this->actingAs($this->user)
            ->put(route('actions.update', $action), [
                'deal_id' => $this->deal->id,
                'type' => 'meeting',
                'scheduled_at' => now()->addDays(2)->format('Y-m-d\TH:i'),
                'notes' => 'Updated notes',
            ])
            ->assertRedirect(route('actions.show', $action));

        $this->assertDatabaseHas('lead_actions', ['id' => $action->id, 'type' => 'meeting']);
    }

    public function test_authenticated_user_can_delete_action(): void
    {
        $action = LeadAction::query()->create([
            'deal_id' => $this->deal->id,
            'type' => 'call',
            'scheduled_at' => now(),
        ]);

        $this->actingAs($this->user)
            ->delete(route('actions.destroy', $action))
            ->assertRedirect(route('actions.index'));

        $this->assertDatabaseMissing('lead_actions', ['id' => $action->id]);
    }

    public function test_actions_index_filters_by_type(): void
    {
        $meetingDeal = Deal::query()->create([
            'lead_id' => $this->deal->lead_id,
            'product_service' => 'Meeting Only Product',
            'budget' => 2000,
            'status' => 'new',
        ]);

        LeadAction::query()->create(['deal_id' => $this->deal->id, 'type' => 'call', 'scheduled_at' => now()]);
        LeadAction::query()->create(['deal_id' => $meetingDeal->id, 'type' => 'meeting', 'scheduled_at' => now()->addHour()]);

        $this->actingAs($this->user)
            ->get(route('actions.index', ['type' => 'meeting']))
            ->assertOk()
            ->assertSee('Meeting Only Product')
            ->assertDontSee('Test Product');
    }
}
