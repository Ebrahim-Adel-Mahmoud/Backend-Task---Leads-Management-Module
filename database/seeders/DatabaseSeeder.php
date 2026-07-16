<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\ActionType;
use App\Enums\DealStatus;
use App\Models\Deal;
use App\Models\Lead;
use App\Models\LeadAction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('12345678'),
        ]);

        $leads = [
            [
                'name' => 'Ahmed Hassan',
                'phone' => '+201012345678',
                'email' => 'ahmed@example.com',
                'address' => 'Cairo, Egypt',
                'notes' => 'Interested in web development services.',
                'deals' => [
                    [
                        'product_service' => 'Corporate Website',
                        'budget' => 15000.00,
                        'status' => DealStatus::InProgress,
                        'notes' => 'Needs responsive design.',
                        'actions' => [
                            ['type' => ActionType::Call, 'scheduled_at' => now()->addDays(1), 'notes' => 'Initial discovery call.'],
                            ['type' => ActionType::Meeting, 'scheduled_at' => now()->addDays(3), 'notes' => 'Requirements meeting.'],
                        ],
                    ],
                ],
            ],
            [
                'name' => 'Sara Mohamed',
                'phone' => '+201098765432',
                'email' => 'sara@example.com',
                'address' => 'Alexandria, Egypt',
                'notes' => 'Looking for CRM integration.',
                'deals' => [
                    [
                        'product_service' => 'CRM Integration',
                        'budget' => 25000.00,
                        'status' => DealStatus::New,
                        'notes' => null,
                        'actions' => [
                            ['type' => ActionType::Call, 'scheduled_at' => now()->addDays(2), 'notes' => 'Follow-up call.'],
                        ],
                    ],
                    [
                        'product_service' => 'Mobile App',
                        'budget' => 50000.00,
                        'status' => DealStatus::Won,
                        'notes' => 'Contract signed.',
                        'actions' => [],
                    ],
                ],
            ],
            [
                'name' => 'Omar Ali',
                'phone' => '+201055512345',
                'email' => null,
                'address' => null,
                'notes' => 'Cold lead from referral.',
                'deals' => [
                    [
                        'product_service' => 'SEO Package',
                        'budget' => 5000.00,
                        'status' => DealStatus::Lost,
                        'notes' => 'Budget too low.',
                        'actions' => [
                            ['type' => ActionType::Meeting, 'scheduled_at' => now()->subDays(5), 'notes' => 'Final negotiation meeting.'],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($leads as $leadData) {
            $deals = $leadData['deals'];
            unset($leadData['deals']);

            $lead = Lead::query()->create($leadData);

            foreach ($deals as $dealData) {
                $actions = $dealData['actions'];
                unset($dealData['actions']);

                $deal = Deal::query()->create([
                    ...$dealData,
                    'lead_id' => $lead->id,
                ]);

                foreach ($actions as $actionData) {
                    LeadAction::query()->create([
                        ...$actionData,
                        'deal_id' => $deal->id,
                    ]);
                }
            }
        }
    }
}
