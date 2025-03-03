<?php

use App\Models\UserDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component {
    public ?int $division_id = null;
    public ?int $department_id = null;
    public ?int $supervisor_id = null;
    public int $salary_ref_number;
    public string $gender;
    public string $dob;
    public string $phone_number;
    public string $address;

    public function mount(): void
    {
        $userDetail = Auth::user()->user_detail;
        if ($userDetail) {
            $this->division_id = $userDetail->division_id;
            $this->department_id = $userDetail->department_id;
            $this->supervisor_id = $userDetail->supervisor_id;
            $this->salary_ref_number = $userDetail->salary_ref_number;
            $this->gender = $userDetail->gender;
            $this->dob = $userDetail->dob->format('dd-mm-YYYY');
            $this->phone_number = $userDetail->phone_number;
            $this->address = $userDetail->address;
        }
    }

    public function updateUserDetails(): void
    {
        $validated = $this->validate([
            'division_id' => ['nullable', 'exists:divisions,id'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'supervisor_id' => ['nullable', 'exists:users,id'],
            'salary_ref_number' => ['required', 'integer'],
            'gender' => ['required', 'string', Rule::in(['male', 'female'])],
            'dob' => ['required', 'date'],
            'phone_number' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:255'],
        ]);

        $user = Auth::user();
        $userDetail = $user->userDetail ?? new UserDetail(['user_id' => $user->id]);
        $userDetail->fill($validated);
        $userDetail->save();

        $this->dispatch('user-details-updated');
    }
};
?>

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout heading="{{ __('User Details') }}" subheading="{{ __('Update your personal information') }}">
        <form wire:submit="updateUserDetails" class="my-6 w-full space-y-6">
            <flux:input wire:model="salary_ref_number" label="{{ __('Salary Ref Number') }}" type="number" required
                placeholder="123456" />
            <flux:radio.group wire:model="gender" label="{{ __('Gender') }}.">
                <flux:radio value="male" label="Male" checked />
                <flux:radio value="female" label="Female" />
            </flux:radio.group>
            <flux:input wire:model="dob" label="{{ __('Date of Birth') }}" type="date" required/>
            <flux:input mask="(+264) 99 999 9999" wire:model="phone_number" label="{{ __('Phone Number') }}" type="text" required
                placeholder="(+264) 85 999 9999" />
            <flux:input wire:model="address" label="{{ __('Address') }}" type="text" required
                placeholder="28 Barbet Street, Hochland Park" />
            <flux:select wire:model="division_id" label="{{ __('Division') }}" placeholder="Choose division...">
                @foreach (App\Models\Organisation\Division::pluck('name', 'id') as $id => $name)
                    <flux:select.option value="{{ $id }}">{{ $name }}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:select wire:model="department_id" label="{{ __('Department') }}" placeholder="Choose department...">
                @foreach (App\Models\Organisation\Department::pluck('name', 'id') as $id => $name)
                    <flux:select.option value="{{ $id }}">{{ $name }}</flux:select.option>
                @endforeach
            </flux:select>
            <flux:select wire:model="supervisor_id" label="{{ __('Supervisor') }}" placeholder="Choose supervisor...">
                @foreach (App\Models\User::pluck('name', 'id') as $id => $name)
                    <flux:select.option value="{{ $id }}">{{ $name }}</flux:select.option>
                @endforeach
            </flux:select>

            <div class="flex items-center gap-4">
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
