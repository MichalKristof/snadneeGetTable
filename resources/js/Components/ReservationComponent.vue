<template>
    <div
        class="relative w-full flex flex-col items-center px-4 mx-auto max-w-screen-xl py-24 lg:py-32 lg:px-6 bg-white rounded-xl shadow-xl">
        <div class="w-full flex flex-col items-center" :class="{ 'blur-effect': loading }"
             v-if="!successReservation">
            <div v-show="!showSumElement" class="w-full flex flex-col items-center justify-center">
                <date-component @update:date="updateDate"></date-component>
                <time-component :times="times" @update:time="updateTime"></time-component>
                <table-component v-show="showTableComponent" :selectedTime="selectedTime"
                                 :tables="tables"
                                 @update:table="updateTable"></table-component>
                <div class="w-full md:w-10/12 flex flex-inline items-center justify-between gap-5 mt-10">
                    <button type="button" @click="goToRestaurants()"
                            class="flex items-center justify-center px-3 py-2 text-center bg-gray-400 border-2 border-gray-100 hover:border-gray-800 text-white font-semibold py-2 px-4 rounded-2xl hover:shadow-xl duration-500">
                        Back to restaurants
                    </button>
                    <button
                        v-if="showSumBtn"
                        @click="confirmData"
                        type="submit"
                        class="flex items-center justify-center px-3 py-2 text-center bg-gradient-to-r from-purple-500 to-red-500 border-2 border-gray-100 hover:border-gray-800 text-white font-semibold py-2 px-4 rounded-2xl hover:shadow-xl duration-500">
                        Confirm
                    </button>
                </div>
            </div>

            <div v-if="showSumElement" class="w-full md:w-10/12 flex flex-col items-center gap-5">
                <span class="text-2xl font-medium text-gray-900 underline">Summary</span>
                <div class="w-full flex flex-inline items-center justify-center gap-2">
                    <span class="text-xl font-semibold text-gray-900">Date:</span>
                    <span class="text-lg font-semibold text-purple-600">{{ selectedDate }}</span>
                </div>
                <div class="w-full flex flex-inline items-center justify-center gap-2">
                    <span class="text-xl font-semibold text-gray-900">Time:</span>
                    <span class="text-lg font-semibold text-purple-600">{{ selectedTime }} - {{ selectedTable[2] }}</span>
                </div>
                <div class="w-full flex flex-inline items-center justify-center gap-2">
                    <span class="text-xl font-semibold text-gray-900">Table number:</span>
                    <span class="text-lg font-semibold text-purple-600">{{ selectedTable[1] }}</span>
                </div>
                <div class="flex w-full items-center justify-between gap-5 mt-10">
                    <button type="button" @click="goBack()"
                            class="flex items-center justify-center px-3 py-2 text-center bg-gray-400 border-2 border-gray-100 hover:border-gray-800 text-white font-semibold py-2 px-4 rounded-2xl hover:shadow-xl duration-500">
                        Back
                    </button>
                    <button
                        @click="makeReservation"
                        class="flex items-center justify-center px-3 py-2 text-center bg-gradient-to-r from-purple-500 to-red-500 border-2 border-gray-100 hover:border-gray-800 text-white font-semibold py-2 px-4 rounded-2xl hover:shadow-xl duration-500">
                        Make Reservation
                    </button>
                </div>
            </div>
        </div>

        <div v-if="successReservation" class="w-full flex flex-col items-center my-4 md:my-8">
            <div class="relative w-full md:w-10/12 flex flex-col items-center gap-5">
                <span class="w-full text-center text-3xl font-semibold text-indigo-900">Your table is successfully reserved!</span>
                <span class="w-full text-center text-lg font-semibold text-gray-700">Have a great time and enjoy your meal.</span>
                <button @click="redirectHome()"
                        class="flex items-center justify-center px-3 py-2 text-center bg-gradient-to-r from-purple-500 to-red-500 border-2 border-gray-100 hover:border-gray-800 text-white font-semibold py-2 px-4 rounded-2xl hover:shadow-xl duration-500">
                    Home page
                </button>

            </div>
        </div>

        <transition name="fade">
            <div v-show="loading" role="status" class="absolute bottom-1 right-1 z-30">
                <div
                    class="m-12 inline-block h-8 w-8 animate-spin rounded-full text-indigo-800 border-4 border-solid border-current border-r-transparent align-[-0.125em] motion-reduce:animate-[spin_1.5s_linear_infinite]"
                    role="status">
                  <span
                      class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]"
                  >Loading...</span
                  >
                </div>
            </div>
        </transition>
    </div>
</template>


<script setup>
import {ref, defineProps, watch} from 'vue';

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

const showTableComponent = ref(false);
const showSumBtn = ref(false);
const showSumElement = ref(false);
const successReservation = ref(false);

const selectedDate = ref(null);
const selectedTime = ref(null);
const selectedTable = ref(null);

const updateDate = (updatedDate) => {
    selectedDate.value = updatedDate;
};

const updateTime = (updatedTime) => {
    selectedTime.value = updatedTime;
};

watch([selectedTime, selectedDate], ([newSelectedTime, newSelectedDate]) => {
    if (newSelectedTime !== null && newSelectedDate !== null) {
        findTable();
    }
});

const findTable = () => {
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
        showTableComponent.value = true;
        loading.value = false;
    });
}

const updateTable = (updatedTable) => {
    selectedTable.value = updatedTable;
    showSumBtn.value = true;
};

const goBack = () => {
    showSumElement.value = false;
    showTableComponent.value = true;
    showSumBtn.value = true;
    loading.value = false;
}

const confirmData = () => {
    loading.value = true;
    showSumBtn.value = false;
    showSumElement.value = true;
    loading.value = false;
}

const makeReservation = () => {
    loading.value = true;
    axios.get(apiUrl + '/reservation', {
        params: {
            user: user.value,
            restaurant: restaurant.value,
            table: selectedTable.value[0],
            time: selectedTime.value,
            date: selectedDate.value,
        },
    }).then((response) => {
        console.log(response.data.message);
    }).catch(function (error) {
        console.error(error);
    }).finally(() => {
        showSumElement.value = false;
        successReservation.value = true;
        loading.value = false;
    });
}

const goToRestaurants = () => {
    window.location.href = '/restaurants';
}

const redirectHome = () => {
    window.location.href = '/';
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
