<div class="space-y-6">
    
    <div>
        <x-input-label for="pasanaco_schedule_id" :value="__('Pasanaco Schedule Id')"/>
        <x-text-input id="pasanaco_schedule_id" name="pasanaco_schedule_id" type="text" class="mt-1 block w-full" :value="old('pasanaco_schedule_id', $pasanacoScheduleChange?->pasanaco_schedule_id)" autocomplete="pasanaco_schedule_id" placeholder="Pasanaco Schedule Id"/>
        <x-input-error class="mt-2" :messages="$errors->get('pasanaco_schedule_id')"/>
    </div>
    <div>
        <x-input-label for="action" :value="__('Action')"/>
        <x-text-input id="action" name="action" type="text" class="mt-1 block w-full" :value="old('action', $pasanacoScheduleChange?->action)" autocomplete="action" placeholder="Action"/>
        <x-input-error class="mt-2" :messages="$errors->get('action')"/>
    </div>
    <div>
        <x-input-label for="details" :value="__('Details')"/>
        <x-text-input id="details" name="details" type="text" class="mt-1 block w-full" :value="old('details', $pasanacoScheduleChange?->details)" autocomplete="details" placeholder="Details"/>
        <x-input-error class="mt-2" :messages="$errors->get('details')"/>
    </div>
    <div>
        <x-input-label for="changed_at" :value="__('Changed At')"/>
        <x-text-input id="changed_at" name="changed_at" type="text" class="mt-1 block w-full" :value="old('changed_at', $pasanacoScheduleChange?->changed_at)" autocomplete="changed_at" placeholder="Changed At"/>
        <x-input-error class="mt-2" :messages="$errors->get('changed_at')"/>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>