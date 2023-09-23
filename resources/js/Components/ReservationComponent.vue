<template>
    <div class="w-full flex flex-col items-center px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6"
         :class="{ 'blur-effect': loading }">
        <div class="w-full mx-auto flex flex-col items-center justify-center bg-white rounded-t-lg p-8" v-if="showForm">
            <form @submit.prevent="findTable" :class="{ 'blur-effect': !showDateTime }" class="w-full">
                <div class="flex flex-col items-center">
                    <div class="w-full flex flex-col space-y-8">
                        <div class="flex flex-col">
                            <h2 class="text-xl font-medium text-gray-900">Date</h2>
                            <div class="w-full shadow-xl">
                                <vue-date-picker
                                    :model-value="selectedDate"
                                    @update:model-value="handleDate"
                                    placeholder="Date of reservation"
                                    format="d.M.Y"
                                    :min-date="new Date()"
                                    :enable-time-picker="false"
                                    :auto-apply="true"
                                    required
                                ></vue-date-picker>
                            </div>
                        </div>
                        <div class="flex flex-col my-5">
                            <h2 class="text-xl font-medium text-gray-900">Time</h2>
                            <div class="w-full">
                                <div class="grid grid-cols-3 md:grid-cols-5 gap-5">
                                    <button
                                        type="button"
                                        @click="handleTime(time)"
                                        v-for="time in times"
                                        class="flex items-center justify-center rounded-xl px-3 py-2 bg-gray-200 border-2 border-transparent hover:border-indigo-800 focus:border-indigo-800 duration-300"
                                    >
                                        {{ time }}
                                    </button>
                                </div>
                            </div>
                            <p class="flex items-center justify-center mt-3 text-sm text-gray-500">
                                Note: The default reservation time is 2 hours.
                            </p>
                        </div>
                    </div>
                    <button
                        v-if="showDateTime"
                        type="submit"
                        class="w-24 mt-10 px-3 py-2 bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 hover:from-red-500 hover:via-pink-500 hover:to-purple-500 text-white font-semibold py-2 px-4 rounded-full transform hover:scale-105 transition duration-500 hover:shadow-xl"
                    >
                        Search
                    </button>

                </div>
            </form>

            <transition name="slide-fade">
                <div :class="{ 'blur-effect': !showTable }" v-if="tables"
                     class="flex flex-col w-full my-4 items-center">
                    <div class="w-full flex justify-end" v-if="showTable">
                        <svg @click="goBack()" xmlns="http://www.w3.org/2000/svg"
                             class="h-12 w-12 cursor-pointer bg-gray-100 rounded-full" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                        </svg>
                    </div>

                    <div class="w-full flex flex-col my-5">
                        <h2 class="text-xl font-medium text-gray-900">Table</h2>
                        <div class="w-full">
                            <div class="grid grid-cols-3 md:grid-cols-5 gap-5">
                                <div v-for="table in tables" :key="table.id">
                                    <button v-if="!table.reservation" @click="chooseTable(table.id, table.table_number)"
                                            class="flex items-center justify-center rounded-xl px-3 py-2 bg-gray-200 border-2 border-transparent hover:border-indigo-800 focus:border-indigo-800 duration-300"
                                    >{{ table.table_number }}
                                    </button>
                                </div>
                            </div>
                            <p class="flex items-center justify-center mt-3 text-sm text-gray-500">
                                Please select table
                            </p>
                        </div>
                    </div>

                    <button
                        v-if="btnNext"
                        @click="buttonNext"
                        class="w-24 mt-10 px-3 py-2 bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 hover:from-red-500 hover:via-pink-500 hover:to-purple-500 text-white font-semibold py-2 px-4 rounded-full transform hover:scale-105 transition duration-500 hover:shadow-xl"
                    >
                        Next
                    </button>
                </div>
            </transition>

            <transition name="slide-fade">
                <div class="flex flex-col w-full items-center" v-if="showSum">
                    <div class="w-full flex justify-end" v-if="showSum">
                        <svg @click="goBackSum()" xmlns="http://www.w3.org/2000/svg"
                             class="h-12 w-12 cursor-pointer bg-gray-100 rounded-full" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                        </svg>
                    </div>
                    <div class="w-full flex flex-col justify-center items-center space-y-2 my-5">
                        <h2 class="text-xl font-medium text-gray-900">Sumarization</h2>
                        <div class="w-full flex flex-col space-x-4">
                            <div class="flex flex-col space-y-2">
                                <span class="text-base text-xl text-gray-800">Date</span>
                                <span class="text-base text-base text-gray-600">{{ selectedDate }}</span>
                            </div>
                            <div class="flex flex-col space-y-2">
                                <span class="text-base text-xl text-gray-800">Time</span>
                                <span class="text-base text-base text-gray-600">{{ selectedTime }}</span>
                            </div>
                            <div class="flex flex-col space-y-2">
                                <span class="text-base text-xl text-gray-800">Table</span>
                                <span class="text-base text-base text-gray-600">{{ selectedTableNumber }}</span>
                            </div>
                        </div>
                    </div>

                    <button
                        @click="makeReservation"
                        class="mt-10 px-3 py-2 bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 hover:from-red-500 hover:via-pink-500 hover:to-purple-500 text-white font-semibold py-2 px-4 rounded-full transform hover:scale-105 transition duration-500 hover:shadow-xl"
                    >
                        Make Reservation
                    </button>
                </div>
            </transition>
        </div>

        <div v-if="!showForm" class="w-full flex flex-col items-center px-4 mx-auto max-w-screen-xl lg:px-6">
            <span class="text-4xl font-bold text-gray-800">Table successfully reserved !</span>
            <a :href="routeHome.value"
               class="mt-10 px-3 py-2 bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 hover:from-red-500 hover:via-pink-500 hover:to-purple-500 text-white font-semibold py-2 px-4 rounded-full transform hover:scale-105 transition duration-500 hover:shadow-xl"
            >
                Go to home page
            </a>
            <a :href="routeReservations.value"
               class="mt-10 px-3 py-2 bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 hover:from-red-500 hover:via-pink-500 hover:to-purple-500 text-white font-semibold py-2 px-4 rounded-full transform hover:scale-105 transition duration-500 hover:shadow-xl"
            >
                See all my reservations
            </a>
        </div>
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
import {ref, defineProps} from 'vue';

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
    routeReservations: {
        type: String,
    },
    routeHome: {
        type: String,
    },
});

const loading = ref(false);

const restaurant = ref(props.restaurant);
const times = ref(props.times);
const user = ref(props.auth);
const routeReservations = ref(props.routeReservations);
const routeHome = ref(props.routeHome);

const tables = ref(null);

const selectedDate = ref();
const selectedTime = ref();
const selectedTable = ref();
const selectedTableNumber = ref();

const showForm = ref(true);
const showDateTime = ref(true);
const showTable = ref(false);
const showSubmitBtn = ref(false);
const btnNext = ref(false);
const showSum = ref(false);

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
        btnNext.value = true;
        loading.value = false;
    });
}

const chooseTable = (tableId, tableNumber) => {
    selectedTable.value = tableId;
    selectedTableNumber.value = tableNumber;
    showSubmitBtn.value = true;
}

const buttonNext = () => {
    if (selectedTable.value == null) {
        alert('Please select another available table');
        return;
    }
    btnNext.value = false;
    showTable.value = false;
    showSum.value = true;
}

const makeReservation = () => {
    showSum.value = false;
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
    }).catch(function (error) {
        console.error(error);
    }).finally(() => {
        clearData();
        showForm.value = false;
        loading.value = false;
    });
}

const goBack = () => {
    tables.value = null;
    showTable.value = false;
    showDateTime.value = true;
}
const goBackSum = () => {
    showTable.value = true;
    showSum.value = false;
}

const clearData = () => {
    tables.value = null;
    selectedDate.value = null;
    selectedTime.value = null;
    selectedTable.value = null;
    selectedTableNumber.value = null;
}
</script>

<style scoped>
.blur-effect {
    filter: blur(1px);
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

.slide-fade-enter-out {
    transform: translateY(40px);
    opacity: 0;
}
</style>
