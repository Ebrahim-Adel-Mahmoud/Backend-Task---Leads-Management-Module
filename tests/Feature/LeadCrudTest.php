<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Deal;
use App\Models\Lead;
use App\Models\LeadAction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_guest_is_redirected_from_leads_index(): void
    {
        $this->get(route('leads.index'))->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_leads_index(): void
    {
        $this->actingAs($this->user)
            ->get(route('leads.index'))
            ->assertOk();
    }

    public function test_authenticated_user_can_create_lead(): void
    {
        $response = $this->actingAs($this->user)->post(route('leads.store'), [
            'name' => 'John Doe',
            'phone' => '+1234567890',
            'email' => 'john@example.com',
            'address' => '123 Main St',
            'notes' => 'Test lead',
        ]);

        $lead = Lead::query()->first();
        $this->assertNotNull($lead);
        $response->assertRedirect(route('leads.show', $lead));
        $this->assertDatabaseHas('leads', ['name' => 'John Doe', 'email' => 'john@example.com']);
    }

    public function test_lead_creation_requires_name_and_phone(): void
    {
        $this->actingAs($this->user)
            ->post(route('leads.store'), [])
            ->assertSessionHasErrors(['name', 'phone']);
    }

    public function test_authenticated_user_can_update_lead(): void
    {
        $lead = Lead::query()->create([
            'name' => 'Old Name',
            'phone' => '+1111111111',
        ]);

        $this->actingAs($this->user)
            ->put(route('leads.update', $lead), [
                'name' => 'New Name',
                'phone' => '+2222222222',
                'email' => 'new@example.com',
            ])
            ->assertRedirect(route('leads.show', $lead));

        $this->assertDatabaseHas('leads', ['id' => $lead->id, 'name' => 'New Name']);
    }

    public function test_authenticated_user_can_delete_lead(): void
    {
        $lead = Lead::query()->create(['name' => 'Delete Me', 'phone' => '+3333333333']);
        $deal = Deal::query()->create([
            'lead_id' => $lead->id,
            'product_service' => 'Test Product',
            'budget' => 1000,
            'status' => 'new',
        ]);
        LeadAction::query()->create([
            'deal_id' => $deal->id,
            'type' => 'call',
            'scheduled_at' => now(),
        ]);

        $this->actingAs($this->user)
            ->delete(route('leads.destroy', $lead))
            ->assertRedirect(route('leads.index'));

        $this->assertDatabaseMissing('leads', ['id' => $lead->id]);
        $this->assertDatabaseMissing('deals', ['id' => $deal->id]);
    }

    public function test_leads_index_search_filters_results(): void
    {
        Lead::query()->create(['name' => 'Alice', 'phone' => '+111']);
        Lead::query()->create(['name' => 'Bob', 'phone' => '+222']);

        $this->actingAs($this->user)
            ->get(route('leads.index', ['search' => 'Alice']))
            ->assertOk()
            ->assertSee('Alice')
            ->assertDontSee('Bob');
    }
}
