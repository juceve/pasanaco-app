<div class="space-y-6">
    
    <div>
        <x-input-label for="pasanaco_group_id" :value="__('Pasanaco Group Id')"/>
        <x-text-input id="pasanaco_group_id" name="pasanaco_group_id" type="text" class="mt-1 block w-full" :value="old('pasanaco_group_id', $pasanacoSchedule?->pasanaco_group_id)" autocomplete="pasanaco_group_id" placeholder="Pasanaco Group Id"/>
        <x-input-error class="mt-2" :messages="$errors->get('pasanaco_group_id')"/>
    </div>
    <div>
        <x-input-label for="participant_id" :value="__('Participant Id')"/>
        <x-text-input id="participant_id" name="participant_id" type="text" class="mt-1 block w-full" :value="old('participant_id', $pasanacoSchedule?->participant_id)" autocomplete="participant_id" placeholder="Participant Id"/>
        <x-input-error class="mt-2" :messages="$errors->get('participant_id')"/>
    </div>
    <div>
        <x-input-label for="scheduled_date" :value="__('Scheduled Date')"/>
        <x-text-input id="scheduled_date" name="scheduled_date" type="text" class="mt-1 block w-full" :value="old('scheduled_date', $pasanacoSchedule?->scheduled_date)" autocomplete="scheduled_date" placeholder="Scheduled Date"/>
        <x-input-error class="mt-2" :messages="$errors->get('scheduled_date')"/>
    </div>
    <div>
        <x-input-label for="status" :value="__('Status')"/>
        <x-text-input id="status" name="status" type="text" class="mt-1 block w-full" :value="old('status', $pasanacoSchedule?->status)" autocomplete="status" placeholder="Status"/>
        <x-input-error class="mt-2" :messages="$errors->get('status')"/>
    </div>
    <div>
        <x-input-label for="adjusted" :value="__('Adjusted')"/>
        <x-text-input id="adjusted" name="adjusted" type="text" class="mt-1 block w-full" :value="old('adjusted', $pasanacoSchedule?->adjusted)" autocomplete="adjusted" placeholder="Adjusted"/>
        <x-input-error class="mt-2" :messages="$errors->get('adjusted')"/>
    </div>
    <div>
        <x-input-label for="adjustment_reason" :value="__('Adjustment Reason')"/>
        <x-text-input id="adjustment_reason" name="adjustment_reason" type="text" class="mt-1 block w-full" :value="old('adjustment_reason', $pasanacoSchedule?->adjustment_reason)" autocomplete="adjustment_reason" placeholder="Adjustment Reason"/>
        <x-input-error class="mt-2" :messages="$errors->get('adjustment_reason')"/>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>