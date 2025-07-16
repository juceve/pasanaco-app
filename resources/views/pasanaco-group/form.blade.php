<div class="space-y-6">
    
    <div>
        <x-input-label for="name" :value="__('Name')"/>
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $pasanacoGroup?->name)" autocomplete="name" placeholder="Name"/>
        <x-input-error class="mt-2" :messages="$errors->get('name')"/>
    </div>
    <div>
        <x-input-label for="start_date" :value="__('Start Date')"/>
        <x-text-input id="start_date" name="start_date" type="text" class="mt-1 block w-full" :value="old('start_date', $pasanacoGroup?->start_date)" autocomplete="start_date" placeholder="Start Date"/>
        <x-input-error class="mt-2" :messages="$errors->get('start_date')"/>
    </div>
    <div>
        <x-input-label for="frequency" :value="__('Frequency')"/>
        <x-text-input id="frequency" name="frequency" type="text" class="mt-1 block w-full" :value="old('frequency', $pasanacoGroup?->frequency)" autocomplete="frequency" placeholder="Frequency"/>
        <x-input-error class="mt-2" :messages="$errors->get('frequency')"/>
    </div>
    <div>
        <x-input-label for="custom_days_interval" :value="__('Custom Days Interval')"/>
        <x-text-input id="custom_days_interval" name="custom_days_interval" type="text" class="mt-1 block w-full" :value="old('custom_days_interval', $pasanacoGroup?->custom_days_interval)" autocomplete="custom_days_interval" placeholder="Custom Days Interval"/>
        <x-input-error class="mt-2" :messages="$errors->get('custom_days_interval')"/>
    </div>
    <div>
        <x-input-label for="day_of_week" :value="__('Day Of Week')"/>
        <x-text-input id="day_of_week" name="day_of_week" type="text" class="mt-1 block w-full" :value="old('day_of_week', $pasanacoGroup?->day_of_week)" autocomplete="day_of_week" placeholder="Day Of Week"/>
        <x-input-error class="mt-2" :messages="$errors->get('day_of_week')"/>
    </div>
    <div>
        <x-input-label for="day_of_month" :value="__('Day Of Month')"/>
        <x-text-input id="day_of_month" name="day_of_month" type="text" class="mt-1 block w-full" :value="old('day_of_month', $pasanacoGroup?->day_of_month)" autocomplete="day_of_month" placeholder="Day Of Month"/>
        <x-input-error class="mt-2" :messages="$errors->get('day_of_month')"/>
    </div>
    <div>
        <x-input-label for="amount_per_participant" :value="__('Amount Per Participant')"/>
        <x-text-input id="amount_per_participant" name="amount_per_participant" type="text" class="mt-1 block w-full" :value="old('amount_per_participant', $pasanacoGroup?->amount_per_participant)" autocomplete="amount_per_participant" placeholder="Amount Per Participant"/>
        <x-input-error class="mt-2" :messages="$errors->get('amount_per_participant')"/>
    </div>
    <div>
        <x-input-label for="status" :value="__('Status')"/>
        <x-text-input id="status" name="status" type="text" class="mt-1 block w-full" :value="old('status', $pasanacoGroup?->status)" autocomplete="status" placeholder="Status"/>
        <x-input-error class="mt-2" :messages="$errors->get('status')"/>
    </div>
    <div>
        <x-input-label for="progress_percent" :value="__('Progress Percent')"/>
        <x-text-input id="progress_percent" name="progress_percent" type="text" class="mt-1 block w-full" :value="old('progress_percent', $pasanacoGroup?->progress_percent)" autocomplete="progress_percent" placeholder="Progress Percent"/>
        <x-input-error class="mt-2" :messages="$errors->get('progress_percent')"/>
    </div>
    <div>
        <x-input-label for="settings" :value="__('Settings')"/>
        <x-text-input id="settings" name="settings" type="text" class="mt-1 block w-full" :value="old('settings', $pasanacoGroup?->settings)" autocomplete="settings" placeholder="Settings"/>
        <x-input-error class="mt-2" :messages="$errors->get('settings')"/>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>