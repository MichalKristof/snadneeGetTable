<template>
    <div class="w-full flex flex-col items-center py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6"
         :class="{ 'blur-effect': loading }">
        <form @submit.prevent="findTable" v-if="showDateTime"
              class="flex flex-col items-center justify-center w-full">
            <div class="w-full flex flex-col space-y-8">
                <div class="flex flex-col w-full">
                    <label class="text-xl font-medium text-gray-900">
                        Date
                    </label>
                    <div class="w-full shadow-xl">
                        <vue-date-picker
                            :model-value="selectedDate"
                            @update:model-value="handleDate"
                            placeholder="Date of reservation"
                            format="d.M.Y"
                            :min-date="new Date()"
                            :enable-time-picker="false"
                            :auto-apply="true"
                            requireds
                        ></vue-date-picker>
                    </div>
                </div>
                <div class="flex flex-col w-full my-5">
                    <label class="text-xl font-medium text-gray-900">
                        Time
                    </label>

                    <div class="w-full">
                        <div class="grid grid-cols-3 md:grid-cols-5 gap-5">
                            <button type="button" @click="handleTime(time)" v-for="time in times"
                                    class="flex items-center justify-center rounded-xl bg-gray-200 hover:bg-green-200 focus:bg-green-200 duration-300">
                                {{ time }}
                            </button>
                        </div>
                    </div>

                    <p class="flex items-center justify-center mt-3 text-sm text-gray-500">
                        Note: The default reservation time is 2 hours.
                    </p>
                </div>
            </div>
            <button type="submit" class="w-6/12 mt-10 bg-gray-200 hover:bg-gray-300 py-2 px-4 rounded-xl">
                <span class="text-gray-900 font-bold">Search</span>
            </button>
        </form>

        <transition name="slide-fade">
            <div v-if="showTable" class="flex flex-col w-full my-10">
                <div class="w-full flex flex-col space-y-3 my-10">
                    <span class="text-xl font-medium text-gray-900">
                        Selected date: {{ selectedDate }}
                    </span>
                    <span class="text-xl font-medium text-gray-900">
                        Selected time: {{ selectedTime }}
                    </span>
                </div>

                <button @click="goBack()" type="button"
                        class="w-20 text-white mb-5 bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                    Go Back
                </button>

                <label class="text-xl font-medium text-gray-900">
                    Choose table
                </label>

                <div class="w-full">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-10">
                        <div @click="table.reservation ? null : chooseTable(table.id)" v-for="table in tables"
                             :key="table.id"
                             class="relative flex flex-col gap-3 items-center justify-center p-3 rounded-md shadow-md bg-gray-200 hover:scale-105 focus:scale-105 focus:bg-gray-50 cursor-pointer duration-300">
                            <div v-if="table.reservation" class="flex flex-col items-center justify-center">
                                <span class="text-xl font-medium text-red-500">Reserved</span>
                            </div>
                            <span class="absolute bottom-2 right-2 text-base font-bold text-gray-800">#{{
                                    table.table_number
                                }}</span>

                        </div>
                    </div>
                </div>
                <button v-if="showSubmitBtn"
                        class="w-6/12 mt-10 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                        @click="makeReservation">
                    Make reservation
                </button>
            </div>
        </transition>
    </div>

    <div v-show="successReservation" class="w-full flex flex-col items-center py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
        <span class="text-4xl font-bold text-green-400">Table successfully reserved</span>
        <a href="/" class="w-6/12 mt-10 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Go to home page
        </a>
        <a href="" class="w-6/12 mt-10 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            See all my reservations
        </a>
    </div>

    <transition name="fade">
        <div v-show="loading" role="status" class="absolute bottom-3 right-3">
            <svg aria-hidden="true"
                 class="w-32 h-32 mr-2 text-gray-200 animate-spin fill-blue-600"
                 viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                    fill="currentColor"/>
                <path
                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                    fill="currentFill"/>
            </svg>
            <span class="sr-only">Loading...</span>
        </div>
    </transition>
</template>


<script setup>
import {ref, defineProps, computed} from 'vue';

const apiUrl = import.meta.env.VITE_API_URL;

const props = defineProps({
    restaurant: {
        type: String,
        required: true,
    },
    times: {
        type: Array,
        required: true,
    },
    auth: {
        type: String,
        like: Number,
        required: true,
    },
});

const loading = ref(false);

const restaurant = ref(props.restaurant);
const times = ref(props.times);
const user = ref(props.auth);

const tables = ref(null);

const selectedDate = ref();
const selectedTime = ref();
const selectedTable = ref();

const showDateTime = ref(true);
const showTable = ref(false);
const showSubmitBtn = ref(false);
const successReservation = ref(false);

const handleDate = (modelData) => {
    const year = modelData.getFullYear();
    const month = (modelData.getMonth() + 1).toString().padStart(2, '0');
    const day = modelData.getDate().toString().padStart(2, '0');

    selectedDate.value = `${year}-${month}-${day}`;
}

const handleTime = (time) => {
    selectedTime.value = time;
}
const findTable = () => {
    if (selectedTime.value == null || selectedDate.value == null) {
        alert('Please select time and date');
        return;
    }
    loading.value = true;
    axios.get(apiUrl + '/find-table', {
        params: {
            restaurant: restaurant.value,
            time: selectedTime.value,
            date: selectedDate.value,
        },
    }).then((response) => {
        tables.value = response.data.data;
    }).catch(function (error) {
        console.error(error);
    }).finally(() => {
        showDateTime.value = false;
        showTable.value = true;
        loading.value = false;
    });
}

const chooseTable = (tableId) => {
    selectedTable.value = tableId;
    showSubmitBtn.value = true;
}

const makeReservation = () => {
    if (selectedTable.value == null) {
        alert('Please select another available table');
        return;
    }
    loading.value = true;
    axios.get(apiUrl + '/reservation', {
        params: {
            user: user.value,
            restaurant: restaurant.value,
            table: selectedTable.value,
            time: selectedTime.value,
            date: selectedDate.value,
        },
    }).then(() => {
        successReservation.value = true;
    }).catch(function (error) {
        console.error(error);
    }).finally(() => {
        showTable.value = false;
        successReservation.value = true;
        clearData();
        loading.value = false;
    });
}

const goBack = () => {
    showTable.value = false;
    showDateTime.value = true;
}

const clearData = () => {
    tables.value = null;
    selectedDate.value = null;
    selectedTime.value = null;
    selectedTable.value = null;
}
</script>

<style scoped>
.blur-effect {
    filter: blur(2px);
    transition: filter 0.3s ease-in-out;
    pointer-events: none;
    opacity: 0.9;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.slide-fade-enter-active {
    transition: all 0.5s ease-out;
}

.slide-fade-enter-from {
    transform: translateY(-40px);
    opacity: 0;
}
</style>
