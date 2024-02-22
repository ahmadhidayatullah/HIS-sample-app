<template>
  <v-container fluid class="live-queue-container">

    <v-card elevation="3" flat>
      <v-card-title primary-title>
        Live Queue HIS
        <v-btn size="small" color="info" @click="openAddModal">Add Data</v-btn>

      </v-card-title>

      <v-card-text>
        <v-data-table :headers="headers" :items="liveQueue" :loading="isLoading" dense class="elevation-1" height="auto">
          <template v-slot:item="{ item }">
            <tr>
              <td>{{ item.id }}</td>
              <td>{{ item.client_name }}</td>
              <td>{{ item.service_name }}</td>
              <td>{{ item.state_name }}</td>
              <td>{{ item.updated_at }}</td>
              <td>
                <v-btn size="small" color="info" @click="alertItem(item)" :disabled="isLoading">
                  Alert
                </v-btn>
                <v-btn size="small" color="error" @click="deleteItem(item.id)" :disabled="isLoading">
                  Delete
                </v-btn>
              </td>
            </tr>
          </template>
          <template v-slot:isLoading>
            <v-skeleton-loader type="table-tbody" />
          </template>
        </v-data-table>
      </v-card-text>
    </v-card>
    <MyAddModal ref="myAddModalRef" @addData="handleAddData" @isLoading="updateLoading"/>

  </v-container>
</template>


<script>
import { onMounted, ref, onUnmounted } from 'vue';
import { db } from '../firebaseInit'; // Adjust path as necessary
import { collection, getDocs, onSnapshot } from 'firebase/firestore';
import axios from '../axiosConfig'

import { VCard, VCardTitle, VCardText, VDataTable, VBtn, VContainer, VSkeletonLoader } from 'vuetify/components';

import MyAddModal from './MyAddModal.vue';
export default {
  name: 'LiveQueue',
  components: {
    VCard,
    VCardTitle,
    VCardText,
    VDataTable,
    VBtn,
    VContainer,
    VSkeletonLoader,
    MyAddModal
  },
  setup() {
    console.log('tsetset');
    const liveQueue = ref([]);
    const isLoading = ref(false); // Add this line
    const headers = ref([
      {
        title: 'ID',
        align: 'start',
        sortable: false,
        key: 'id',
      },
      { title: 'Name', key: 'client_name' },
      { title: 'Service Name', key: 'service_name' },
      { title: 'State Name', key: 'state_name' },
      { title: 'Updated At', key: 'updated_at' },
      { title: 'Action', key: 'action', sortable: false },
    ]);

    // Modal visibility and data
    const addModalVisible = ref(false);
    const newClientName = ref('');
    const newServiceName = ref('');

    const myAddModalRef = ref(null);

    onMounted(async () => {
      await getData();
    });

    const updateLoading = (value) => {
      isLoading.value = value;
    };

    const getData = async () => {
      try {
        const unsubscribe = onSnapshot(collection(db, 'live_queue'), (querySnapshot) => {
          isLoading.value = true; // Start loading
          const items = [];

          console.log('getting data from firebase');
          querySnapshot.forEach((doc) => {
            items.push({ id: doc.id, ...doc.data().data });
          });
          liveQueue.value = items;
          isLoading.value = false;
        }, (error) => {
          console.error("Error fetching live updates:", error);
          isLoading.value = false;
          // Handle the error appropriately
        });

      } finally {
        isLoading.value = false; // End loading
      }
    };

    const alertItem = async (item) => {
      isLoading.value = true; // Start loading
      console.log('start alerting');
      const userApiUrl = '/user'; // Replace with your actual API URL
      const url = `${userApiUrl}/visits/${item.id}/alert`;

      try {
        const response = await axios.put(url);

        console.log(response);

      } catch (error) {
        let err = error.response.data;
        console.error("Failed to alert item:", error);
        alert(err.message);
        isLoading.value = false; // End loading
      } finally {
        console.log('finish alerted');
        // isLoading.value = false; // End loading
      }
    };

    const deleteItem = async (id) => {
      isLoading.value = true; // Start loading
      console.log('start delete');
      const userApiUrl = '/user'; // Replace with your actual API URL
      const url = `${userApiUrl}/visits/${id}/delete`;

      try {
        const response = await axios.put(url);

        // Assuming the API call was successful, now remove the item from the liveQueue
        console.log(response);
        
      } catch (error) {
        let err = error.response.data;
        console.error("Failed to delete item:", error);
        alert(err.message);
        isLoading.value = false; // End loading
      } finally {
        console.log('finish delete');
      }
    };

    const openAddModal = () => {
      if (myAddModalRef.value) {
        myAddModalRef.value.openModal(); // Assuming your modal has an openModal method
      } else {
        console.error("myAddModal ref not available");
      }
    };

    const closeAddModal = () => {
      addModalVisible.value = false;
      // Reset form fields (if needed)
      newClientName.value = '';
      newServiceName.value = '';
    };

    const handleAddData = async (newData) => {
      isLoading.value = true; // End loading
      const userApiUrl = '/user'; // Replace with your actual API URL
      const url = `${userApiUrl}/visits/store`;

      try {
        const response = await axios.post(url, newData);

        console.log(response);

      } catch (error) {
        let err = error.response.data;
        console.error("Failed to alert item:", error);
        alert(err.message);
        isLoading.value = false; // End loading
      } finally {
        console.log('finish alerted');
        // isLoading.value = false; // End loading
      }

      // // Add the new visit to the liveQueue
      
      console.log('handleAddData:', newData);
    };


    return { liveQueue, alertItem, deleteItem, isLoading, headers, openAddModal, closeAddModal,handleAddData, newClientName, newServiceName, addModalVisible, myAddModalRef, updateLoading};
  }
};
</script>
<style scoped>
  .live-queue-container {
    padding: 20px;
  }
  
  .v-data-table {
    border-collapse: collapse;
  }
  
  .v-data-table th, .v-data-table td {
    padding: 8px;
    border: 1px solid #ddd;
  }
  
  .v-data-table th {
    background-color: #04AA6D;
    color: white;
  }
  
  .v-data-table tr:nth-child(even) {
    background-color: #f2f2f2;
  }
  
  .v-data-table tr:hover {
    background-color: #ddd;
  }
  </style>
  
  
  