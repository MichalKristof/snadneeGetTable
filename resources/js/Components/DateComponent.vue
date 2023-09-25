<template>
    <div class="w-full md:w-10/12 flex flex-col">
        <h2 class="text-xl font-medium text-gray-900">Date</h2>
        <div class="w-full shadow">
            <vue-date-picker
                :model-value="dates"
                @update:model-value="handleDate"
                placeholder="Date of reservation"
                format="d.M.Y"
                :min-date="tomorrow"
                :enable-time-picker="false"
                :auto-apply="true"
                required
            ></vue-date-picker>
        </div>
    </div>
</template>

<script setup>
import { ref, defineEmits } from 'vue';

const emit = defineEmits(['update:date']);

const dates = ref(null);

const tomorrow = new Date();
tomorrow.setDate(tomorrow.getDate() + 1);
const handleDate = (modelData) => {
    const year = modelData.getFullYear();
    const month = (modelData.getMonth() + 1).toString().padStart(2, '0');
    const day = modelData.getDate().toString().padStart(2, '0');

    dates.value = `${year}-${month}-${day}`;

    emit('update:date', dates.value);
};
</script>

<style lang="scss" scoped>

</style>
