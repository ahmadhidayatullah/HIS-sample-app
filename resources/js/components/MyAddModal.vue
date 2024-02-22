<template>
  <v-dialog v-model="dialogVisible">
    <v-card>
      <v-card-title primary-title>Add Data</v-card-title>
      <v-card-text>
        <v-text-field label="Client Name" v-model="clientName" :rules="[clientNameRule]" />
        <v-text-field label="Phone Number" v-model="phoneNumber" :rules="[phoneNumberRule]" />
        <v-text-field label="IC Number" v-model="icNumber" :rules="[icNumberRule]" />
        <v-select
          label="Service Name"
          v-model="serviceId"
          :items="services"
          item-title="name"
          item-value="id"
        />
        <v-select
          label="User"
          v-model="userId"
          :items="users"
          item-title="name"
          item-value="id"
        />
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="primary" :disabled="!isValid" @click="addData">Add</v-btn>
        <v-btn color="secondary" @click="closeModal">Close</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup>
import { ref, watch, computed } from 'vue';
import axios from '../axiosConfig';
// defineEmits(['addData']);
// Define props
// const props = defineProps({
//   // Define any props you need from LiveQueue (e.g., headers)
// });

// Define reactive state variables
const dialogVisible = ref(false);

const requiredRule = (v) => !!v || 'This field is required';
const maxLengthRule = (v, maxLength) => v.length <= maxLength || `Must be less than ${maxLength} characters`;

// Define reactive state variables
const clientName = ref('');
const phoneNumber = ref('');
const icNumber = ref('');
const serviceId = ref(null);
const userId = ref(null);
const services = ref([
  { id: 522, name: 'Registration' }
]);

const users = ref([
  { id: 383, name: 'Registration' }
]);

// Computed property for validation
const isValid = computed(() => {
  return (
    clientName.value &&
    phoneNumber.value &&
    icNumber.value &&
    serviceId.value &&
    userId.value
  );
});

// Define validation rules as computed properties for clarity
const clientNameRule = computed(() => [requiredRule, maxLengthRule(clientName.value, 50)]);
const phoneNumberRule = computed(() => [requiredRule, maxLengthRule(phoneNumber.value, 15)]);
const icNumberRule = computed(() => [requiredRule, maxLengthRule(icNumber.value, 12)]);
const serviceIdRule = computed(() => [requiredRule]);
const userIdRule = computed(() => [requiredRule]);

const emit = defineEmits(['addData']);
// ... other data fields (add as needed)

// Methods
const openModal = () => {
  console.log('open modal');
  dialogVisible.value = true;
};

const closeModal = () => {
  dialogVisible.value = false;
  resetData(); // Clear form fields
};

const addData = async () => {
  // Validate data (add validation logic as needed)
  if (!isValid.value) {
    return; // Prevent submission if any required field is empty
  }
  // Implement logic to add new data to Firebase or backend API
  // For example:
  const newVisit = {
    name: clientName.value,
    phone: phoneNumber.value,
    ic_number: icNumber.value,
    service_id: serviceId.value,
    user_id: userId.value,
    dependants: [],
    status: 1
  }

  console.log('Adding data:', newVisit);

  // ... (your data submission logic to Firebase or backend API)

  emit('addData', newVisit); // Emit an event to LiveQueue
  closeModal();
};

const resetData = () => {
  clientName.value = '';
  phoneNumber.value = '';
  icNumber.value = '';
  serviceId.value = null;
  userId.value = null;
};

defineExpose({ openModal });
</script>

  