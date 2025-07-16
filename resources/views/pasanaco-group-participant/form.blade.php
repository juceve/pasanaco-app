<div class="space-y-6">
    
    <div>
        <x-input-label for="pasanaco_group_id" :value="__('Pasanaco Group Id')"/>
        <x-text-input id="pasanaco_group_id" name="pasanaco_group_id" type="text" class="mt-1 block w-full" :value="old('pasanaco_group_id', $pasanacoGroupParticipant?->pasanaco_group_id)" autocomplete="pasanaco_group_id" placeholder="Pasanaco Group Id"/>
        <x-input-error class="mt-2" :messages="$errors->get('pasanaco_group_id')"/>
    </div>
    <div>
        <x-input-label for="participant_id" :value="__('Participant Id')"/>
        <x-text-input id="participant_id" name="participant_id" type="text" class="mt-1 block w-full" :value="old('participant_id', $pasanacoGroupParticipant?->participant_id)" autocomplete="participant_id" placeholder="Participant Id"/>
        <x-input-error class="mt-2" :messages="$errors->get('participant_id')"/>
    </div>
    <div>
        <x-input-label for="status" :value="__('Status')"/>
        <x-text-input id="status" name="status" type="text" class="mt-1 block w-full" :value="old('status', $pasanacoGroupParticipant?->status)" autocomplete="status" placeholder="Status"/>
        <x-input-error class="mt-2" :messages="$errors->get('status')"/>
    </div>
    <div>
        <x-input-label for="removal_reason" :value="__('Removal Reason')"/>
        <x-text-input id="removal_reason" name="removal_reason" type="text" class="mt-1 block w-full" :value="old('removal_reason', $pasanacoGroupParticipant?->removal_reason)" autocomplete="removal_reason" placeholder="Removal Reason"/>
        <x-input-error class="mt-2" :messages="$errors->get('removal_reason')"/>
    </div>
    <div>
        <x-input-label for="joined_at" :value="__('Joined At')"/>
        <x-text-input id="joined_at" name="joined_at" type="text" class="mt-1 block w-full" :value="old('joined_at', $pasanacoGroupParticipant?->joined_at)" autocomplete="joined_at" placeholder="Joined At"/>
        <x-input-error class="mt-2" :messages="$errors->get('joined_at')"/>
    </div>
    <div>
        <x-input-label for="removed_at" :value="__('Removed At')"/>
        <x-text-input id="removed_at" name="removed_at" type="text" class="mt-1 block w-full" :value="old('removed_at', $pasanacoGroupParticipant?->removed_at)" autocomplete="removed_at" placeholder="Removed At"/>
        <x-input-error class="mt-2" :messages="$errors->get('removed_at')"/>
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Submit</x-primary-button>
    </div>
</div>