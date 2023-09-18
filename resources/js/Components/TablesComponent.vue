<template>
    <div class="w-full flex flex-col items-center py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
        <div class="font-light text-gray-500 sm:text-lg dark:text-gray-400">
            <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900">Choose your table</h2>
        </div>

        <div class="w-full h-full grid grid-cols-1 md:grid-cols-3 gap-5 overflow-visible">
            <div @click="openTable(table.id)" v-for="table in tables"
                 class="flex flex-col gap-3 items-center justify-center p-3 rounded-md shadow-md bg-gray-200 hover:scale-105 focus:scale-105 cursor-pointer duration-300">
                <span class="text-xl font-medium">{{ table.table_number }}</span>
                <span class="text-base font-base">Table capacity {{ table.capacity }}</span>
            </div>
        </div>
        <div v-if="openDialog" class="w-full mt-10 h-full flex flex-col items-center px-5 py-10 bg-red-200 rounded-xl">
            You need to log in to make a reservation !
        </div>

        <Transition name="bounce">
            <div v-show="openModal"
                 class="w-full h-full flex flex-col items-center px-5 py-10 mt-10 bg-gray-100">
                <button
                    class="pr-0 pt-0 w-8 h-8 text-2xl bg-gray-300 text-gray-500 hover:text-gray-900"
                    @click="closeModal">
                    <i class="fas fa-times"></i>
                </button>
                <span class="text-2xl font-medium">New reservation</span>
                <span class="text-base font-base">Table id {{ currentTable }}</span>

                <div class="flex-inline w-11/12">
                    <label class="text-xl font-medium text-gray-900">
                        Date
                    </label>

                    <div class="w-full shadow-xl">
                        <vue-date-picker v-model="date"
                                         placeholder="Date of reservation"
                                         @update:model-value="handleDate"
                                         :min-date="new Date()"
                                         :enable-time-picker="false" :auto-apply="true"
                                         :on-click-outside="true"
                        ></vue-date-picker>
                    </div>
                </div>
                <div v-show=showTimeChoose class="flex-inline w-11/12">
                    <label class="text-xl font-medium text-gray-900">
                        Time from*
                    </label>
                    <div class="w-full shadow-xl">
                        <vue-date-picker v-model="time" time-picker
                                         placeholder="Time"
                                         @update:model-value="handleTime"
                                         :minutes-increment="minutesIncrement"
                                         :minutes-grid-increment="minutesIncrement"
                                         :start-time="{ hours: timeFrom[0], minutes: timeFrom[1] }"
                                         :min-time="{ hours: timeFrom[0], minutes: timeFrom[1] }"
                                         :max-time="{ hours: timeTo[0], minutes: timeTo[1] }"
                                         on-click-outside="true"
                        ></vue-date-picker>
                    </div>
                </div>

                <button v-show="showSubmitBtn" class="w-11/12 mt-10 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                        @click="makeReservation">
                    Make reservation
                </button>
            </div>
        </Transition>
    </div>
</template>


<script setup>
import {ref} from 'vue';

const apiUrl = import.meta.env.VITE_API_URL;

const props = defineProps({
    restaurant: {
        type: String,
        required: true,
    },
    tables: {
        type: Object,
        required: true,
    },
    openFrom: {
        type: Array,
        required: true,
    },
    openTo: {
        type: Array,
        required: true,
    },
    user: {
        type: String,
        required: false,
    },
});

const loading = false;
const showSubmitBtn = ref(false);
const showTimeChoose = ref(false);
const openDialog = ref(false);
const restaurant = ref(props.restaurant);
const tables = ref(props.tables);
const timeFrom = ref(props.openFrom);
const timeTo = ref(props.openTo);
const user = ref(props.user);
const minutesIncrement = ref(30);
const currentTable = ref(null);

const date = ref(null);
const time = ref(null);

const openModal = ref(false);

const openTable = async (id) => {
    await closeModal();
    if (!user) {
        openDialog.value = true;
        return;
    }

    currentTable.value = id;
    openModal.value = true;
}

const closeModal = () => {
    currentTable.value = null;
    showTimeChoose.value = false;
    date.value = null;
    time.value = null;
    openModal.value = false;
}

const handleDate = (modelData) => {
    const year = modelData.getFullYear();
    const month = (modelData.getMonth() + 1).toString().padStart(2, '0');
    const day = modelData.getDate().toString().padStart(2, '0');

    const formattedDate = `${year}-${month}-${day}`;
    axios.get(apiUrl + '/date', {
        params: {date: formattedDate, table: currentTable.value},
    }).then((response) => {
        if(response.data.data){
            timeTo.value = [response.data.data[1], response.data.data[0]];
        }
    }).catch(function (error) {
        console.error(error);
    }).finally(() => {
        showTimeChoose.value = true;
    });
}

const handleTime = () => {
    showSubmitBtn.value = true;
}

const makeReservation = () => {
    axios.get(apiUrl + '/reservation', {
        params: {
            restaurant: restaurant.value,
            table: currentTable.value,
            date: date.value,
            time_from: timeFrom.value,
            time_to: timeTo.value,
        },
    }).then((response) => {
        console.log(response);
    }).catch(function (error) {
        console.error(error);
    }).finally(() => {
        closeModal();
    });
}

</script>

<style scoped>
.bounce-enter-active {
    animation: bounce-in 0.5s;
}

.bounce-leave-active {
    animation: bounce-in 0.3s reverse;
}

@keyframes bounce-in {
    0% {
        transform: scale(0);
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
    }
}
</style>
