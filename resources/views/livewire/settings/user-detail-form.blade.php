<?php

use App\Models\UserDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\Attributes\Computed;
use App\Models\Organisation\Division;
use App\Models\Organisation\Department;
use App\Models\User;
new class extends Component {
    public ?int $division_id = null;
    public ?int $department_id = null;
    public ?int $supervisor_id = null;
    public int $salary_ref_number;
    public string $gender;
    public string $dob = '';
    public string $phone_number;
    public string $address;
    public string $job_grade = '';
    public string $aa_title = '';
    public ?string $consultant_domain = null;

    public $divisions;
    public $departments;
    public $supervisors;
    public $isTrainer = false;

    public function mount(): void
    {
        $user = Auth::user();
        $userDetail = $user->user_detail;
        $this->isTrainer = $user->hasRole('trainer');

        if ($userDetail) {
            $this->division_id = $userDetail->division_id;
            $this->department_id = $userDetail->department_id;
            $this->supervisor_id = $userDetail->supervisor_id;
            $this->salary_ref_number = $userDetail->salary_ref_number;
            $this->gender = $userDetail->gender;
            $this->dob = $userDetail->dob->format('dd-mm-YYYY');
            $this->phone_number = $userDetail->phone_number;
            $this->address = $userDetail->address;
            $this->job_grade = $userDetail->job_grade ?? '';
            $this->aa_title = $userDetail->aa_title ?? '';
            $this->consultant_domain = $userDetail->consultant_domain ?? null;
        }
    }

    #[Computed()]
    public function divisions(){
        return Division::all();
    }

    #[Computed()]
    public function departments(){
        return Department::where('division_id', $this->division_id)->get();
    }

    #[Computed()]
    public function supervisors(){
       return User::all();
    }

    public function updateUserDetails(): void
    {
        $validated = $this->validate([
            'division_id' => ['nullable', 'exists:divisions,id', 'integer'],
            'department_id' => ['nullable', 'exists:departments,id', 'integer'],
            'supervisor_id' => ['nullable', 'exists:users,id', 'integer'],
            'salary_ref_number' => ['required', 'integer'],
            'gender' => ['required', 'string', Rule::in(['male', 'female'])],
            'dob' => ['required', 'date'],
            'phone_number' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
            'job_grade' => ['required', 'string', Rule::in(['a', 'b', 'c', 'd', 'e', 'f'])],
            'aa_title' => ['required', 'string'],
            'consultant_domain' => [$this->isTrainer ? 'required' : 'nullable', 'string',
                Rule::when($this->isTrainer, Rule::in(['Technical', 'Information Technology', 'Commercial & General']))],
        ]);

        $user = Auth::user();

        // Find existing or create new user detail
        $userDetail = UserDetail::updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        $this->dispatch('user-details-updated');
    }
};
?>

<section class="w-full" >
    @include('partials.settings-heading')

    <x-settings.layout heading="{{ __('User Details') }}" subheading="{{ __('Update your personal information') }}">
        @if (!Auth::user()->user_details_filled())
            <flux:callout icon="exclamation-circle" variant="warning">
                <flux:callout.heading>Complete your profile</flux:callout.heading>
                <flux:callout.text>Please fill in all your profile details to complete your account setup. This information is required for your training records and communications.</flux:callout.text>
                <x-slot name="controls">
                    <flux:button icon="x-mark" variant="ghost" x-on:click="$el.closest('[data-flux-callout]').remove()" />
                </x-slot>
            </flux:callout>
        @endif

        <form wire:submit="updateUserDetails" class="my-6 w-full">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <flux:input wire:model="salary_ref_number" label="{{ __('Salary Ref Number') }}" type="number" required
                        placeholder="123456" />
                </div>
                <div>
                    <flux:radio.group wire:model="gender" label="{{ __('Gender') }}">
                        <flux:radio value="male" label="Male" checked />
                        <flux:radio value="female" label="Female" />
                    </flux:radio.group>
                </div>
                <div>
                    <flux:input wire:model.live="dob" label="{{ __('Date of Birth') }}" type="date" required/>
                </div>
                <div>
                    <flux:input mask="(+264) 99 999 9999" wire:model="phone_number" label="{{ __('Phone Number') }}" type="text" required
                        placeholder="(+264) 85 999 9999" />
                </div>
                <div class="md:col-span-2">
                    <flux:input wire:model="address" label="{{ __('Address') }}" type="text" required
                        placeholder="28 Barbet Street, Hochland Park" />
                </div>
                <div>
                    <flux:select wire:model.live="division_id" label="{{ __('Division') }}" placeholder="Choose division...">
                        @foreach ($this->divisions() as $division)
                            <flux:select.option value="{{ $division->id }}">{{ $division->division_name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
                <div>
                    <flux:select wire:model.live="department_id" label="{{ __('Department') }}" placeholder="Choose department...">
                        @foreach ($this->departments() as $department)
                            <flux:select.option value="{{ $department->id }}">{{ $department->department_name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
                <div>
                    <flux:select wire:model.live="supervisor_id" label="{{ __('Supervisor') }}" placeholder="Choose supervisor...">
                        @foreach ($this->supervisors() as $supervisor)
                            <flux:select.option value="{{ $supervisor->id }}">{{ $supervisor->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
                <div>
                    <flux:select wire:model="job_grade" label="{{ __('Job Grade') }}" required placeholder="Select Paterson job grade...">
                        @foreach (['a', 'b', 'c', 'd', 'e', 'f'] as $grade)
                            <flux:select.option value="{{ $grade }}">{{ strtoupper($grade) }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
                <div>
                    <flux:select wire:model="aa_title" label="{{ __('Affirmative Action Title') }}" required placeholder="Select AA title...">
                        <flux:select.option value="Racially advantaged male">Racially advantaged male</flux:select.option>
                        <flux:select.option value="Racially disadvantaged male">Racially disadvantaged male</flux:select.option>
                        <flux:select.option value="Racially advantaged female">Racially advantaged female</flux:select.option>
                        <flux:select.option value="Racially disadvantaged female">Racially disadvantaged female</flux:select.option>
                    </flux:select>
                </div>

                @if($isTrainer)
                <div class="md:col-span-2">
                    <flux:select wire:model="consultant_domain" label="{{ __('Consultant Domain') }}" required placeholder="Select consultant domain...">
                        <flux:select.option value="Technical">Technical</flux:select.option>
                        <flux:select.option value="Information Technology">Information Technology</flux:select.option>
                        <flux:select.option value="Commercial & General">Commercial & General</flux:select.option>
                    </flux:select>
                </div>
                @endif
            </div>

            <div class="flex items-center gap-4 mt-6">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>
                <x-action-message class="me-3" on="user-details-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>
    </x-settings.layout>
</section>
