<template>
    <div class="relative w-full md:w-10/12 flex flex-col">
        <h2 class="text-xl font-medium text-gray-900">Table</h2>
        <div class="w-full flex flex-col gap-3">
            <div class="w-full grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 md:gap-5 py-2">
                <div v-for="table in tables" :key="table.id">
                    <button @click="selectTable(table)"
                            :class="{
                                'hover:border-indigo-800': !isTableReserved(table),
                                'cursor-not-allowed': isTableReserved(table),
                            }"
                            :style="{ borderColor: selectedTable === table.id ? 'indigo' : '' }"
                            class="w-full flex flex-col items-center justify-center rounded-xl p-6 md:p-8 bg-gray-100 border-2 border-transparent duration-300"
                            :disabled="isTableReserved(table)"
                    >{{ table.table_number }}
                        <span v-if="isTableReserved(table)" class="text-xs text-indigo-800">Reserved</span>
                        <span v-else class="text-xs text-indigo-800">Table available</span>
                    </button>
                </div>
            </div>
            <div v-if="areAllTablesReserved()" class="w-full flex items-center text-center text-red-600 my-3">
                Warning: All tables for this date and time are reserved. Please select another date or time.
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, defineEmits, watch } from 'vue';

const props = defineProps({
    tables: {
        type: Array,
        required: true,
    },
    selectedTime: {
        type: String,
        required: true,
    },
});

const tables = ref(props.tables);
const localSelectedTime = ref(props.selectedTime);
const selectedTable = ref();

const emit = defineEmits(['update:table']);

const selectTable = (table) => {
    if (!table.reservation) {
        selectedTable.value = table.id;
        emit('update:table', [table.id, table.table_number]);
    }
};

const isTableReserved = (table) => {
    if (!table.reservation) {
        return false;
    }

    for (const reservation of table.reservation) {
        if (
            localSelectedTime.value >= reservation.time_from &&
            localSelectedTime.value < reservation.time_to
        ) {
            return true;
        }
    }
    return false;
};
const areAllTablesReserved = () => {
    return tables.value.every((table) => isTableReserved(table));
};

watch(() => props.selectedTime, (newSelectedTime) => {
    localSelectedTime.value = newSelectedTime;
    selectedTable.value = null;
});

watch(() => props.tables, (newTables) => {
    tables.value = newTables;
    selectedTable.value = null;
});
</script>

<style lang="scss" scoped>
</style>
