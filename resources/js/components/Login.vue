<template>
    <v-container>
        <v-row>
            <v-col>
                <v-img class="mx-auto my-6" max-width="500"
                    src="https://seeklogo.com/images/H/hospital-ecg-logo-A894115402-seeklogo.com.png"></v-img>

                <v-card class="mx-auto pa-12 pb-8" elevation="8" max-width="900" rounded="lg">
                    <div class="text-subtitle-1 text-medium-emphasis">Email</div>

                    <v-text-field density="compact" :rules="emailRules" v-model="credentials.email"
                        placeholder="Email address" prepend-inner-icon="mdi-email-outline"
                        variant="outlined"></v-text-field>

                    <div class="text-subtitle-1 text-medium-emphasis d-flex align-center justify-space-between">
                        Password
                    </div>

                    <v-text-field :rules="passwordRules" :append-inner-icon="visible ? 'mdi-eye-off' : 'mdi-eye'"
                        :type="visible ? 'text' : 'password'" v-model="credentials.password" density="compact"
                        placeholder="Enter your password" prepend-inner-icon="mdi-lock-outline" variant="outlined"
                        @click:append-inner="visible = !visible"></v-text-field>

                    <v-alert v-if="errorMessage" type="error" dense>{{ errorMessage }}</v-alert>

                    <v-btn :loading="loading" :disabled="loading" @click="login" block class="mb-8" color="blue"
                        size="large" variant="tonal">
                        Log In
                    </v-btn>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

  
<script>
import { ref } from 'vue';
import axios from '../axiosConfig'; // Adjust the import path as necessary
import { useRouter } from 'vue-router';

export default {
    setup() {
        console.log('hai');
        const router = useRouter();

        const credentials = ref({
            email: '',
            password: '',
        });

        const visible = ref(false);
        const loading = ref(false); // To track loading state
        const errorMessage = ref(''); // To store login error message
        const emailRules = [
            v => !!v || 'E-mail is required',
            v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
        ];
        const passwordRules = [
            v => !!v || 'Password is required',
            v => v.length >= 8 || 'Password must be at least 8 characters',
        ];

        const login = async () => {
            loading.value = true;
            errorMessage.value = '';
            try {
                console.log('start');
                const response = await axios.post('user/auth/login', credentials.value);
                const token = response.data.data.api_token;
                console.log(response.data.data.api_token);
                localStorage.setItem('token', token);

                router.push('/live-queue')
                // window.location.href = '/live-queue';

            } catch (error) {
                // alert(error.response.data.message);
                errorMessage.value = error.response.data.message;
                console.error('Login error:', error);
                // Handle login failure (e.g., show an error message)
            } finally {
                loading.value = false;
            }
        };

        const logout = () => {
            localStorage.removeItem('token');
            // If you're setting the Authorization header globally in Axios, clear it:
            axios.defaults.headers.common['Authorization'] = null;
            window.location.href = '/';
        };

        return {
            credentials,
            login,
            logout,
            visible,
            loading,
            errorMessage,
            emailRules,
            passwordRules,
        };
    },
};
</script>
  