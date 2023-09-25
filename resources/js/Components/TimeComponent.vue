<template>
    <div class="w-full md:w-10/12 flex flex-col">
        <h2 class="text-xl font-medium text-gray-900">Time</h2>
        <div class="w-full">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 md:gap-5 py-2">
                <button
                    type="button"
                    @click="handleTime(time)"
                    v-for="time in times"
                    :style="{ borderColor: selectedTime === time ? 'indigo' : '' }"
                    class="flex items-center justify-center rounded-xl px-3 py-2 bg-gray-100 border-2 border-transparent hover:border-indigo-800 duration-300"
                >
                    {{ time }}
                </button>
            </div>
        </div>
        <p class="flex items-center justify-center mt-3 text-sm text-gray-500">
            Note: The default reservation time is 2 hours.
        </p>
    </div>
</template>

<script setup>
import {ref, defineProps, defineEmits} from 'vue';

const props = defineProps({
    times: {
        type: Array,
        required: true,
    },
});

const times = ref(props.times);
const selectedTime = ref();

const emit = defineEmits(['update:time']);

const handleTime = (newTime) => {
    selectedTime.value = newTime;
    emit('update:time', newTime);
};
</script>

<style lang="scss" scoped>

</style>-
