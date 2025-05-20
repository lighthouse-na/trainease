<?php

use App\Exports\NTAClaimExport;
use App\Models\Training\Course;
use App\Models\Training\Reports\Summary;
use App\Models\User;
use App\Models\UserDetail;
use Livewire\Livewire;
use Maatwebsite\Excel\Facades\Excel;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    // Create trainer role
    \Spatie\Permission\Models\Role::create(['name' => 'trainer']);
    $this->user = User::factory()->create([
        'email' => 'trainer@example.com',
        'name' => 'Test Trainer',
    ]);
    UserDetail::factory()->create([
        'user_id' => $this->user->id,
        'phone_number' => '1234567890',
        'address' => '123 Training Street',
    ]);
    $this->user->assignRole('trainer');

    $this->course = Course::factory()->create(['user_id' => $this->user->id]);
    actingAs($this->user);
});

it('exports report for valid standard periods', function (string $period) {
    Excel::fake();

    Summary::create([
        'user_id' => $this->user->id,
        'course_id' => $this->course->id,
    ]);

    Livewire::test('trainer/reports/trainersummary')->set('period', $period)->set('exportFormat', 'excel')->call('exportReport');

    Excel::assertDownloaded('training-summary-'.now()->format('Y-m-d').'.xlsx', function (NTAClaimExport $export) {
        expect($export)->toBeInstanceOf(NTAClaimExport::class);

        return true;
    });
})->with(['this_month', 'last_month', 'this_year']);

it('fails validation for custom range without dates', function () {
    Livewire::test('trainer/reports/trainersummary')
        ->set('period', 'custom')
        ->call('exportReport')
        ->assertHasErrors(['startDate' => 'required', 'endDate' => 'required']);
});

it('fails validation when endDate is before startDate', function () {
    Livewire::test('trainer/reports/trainersummary')
        ->set('period', 'custom')
        ->set('startDate', now()->toDateString())
        ->set('endDate', now()->subDay()->toDateString())
        ->call('exportReport')
        ->assertHasErrors(['endDate' => 'after_or_equal']);
});

it('exports custom range if dates are valid', function () {
    Excel::fake();

    Summary::create([
        'user_id' => $this->user->id,
        'course_id' => $this->course->id,
    ]);

    Livewire::test('trainer/reports/trainersummary')
        ->set('period', 'custom')
        ->set('startDate', now()->subWeek()->toDateString())
        ->set('endDate', now()->toDateString())
        ->set('exportFormat', 'csv')
        ->call('exportReport');

    Excel::assertDownloaded('training-summary-'.now()->format('Y-m-d').'.csv');
});

it('paginates summary data correctly', function () {
    for ($i = 0; $i < 30; $i++) {
        Summary::create([
            'user_id' => $this->user->id,
            'course_id' => $this->course->id,
        ]);
    }

    Livewire::test('trainer/reports/trainersummary')->assertSee('Training Summary Report')->assertSee('Grand Total');
});
