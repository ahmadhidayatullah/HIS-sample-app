<template>
  <v-app>
    <v-app-bar app>
      <!-- Place navigation links directly in the app bar -->
      <v-toolbar-title>HIS APP</v-toolbar-title>
      <v-spacer></v-spacer> <!-- This pushes the navigation items to the right -->
      <v-btn text :to="{ name: 'LiveQueue' }">Live Queue</v-btn>
      <v-btn text :to="{ name: 'Login' }">Login</v-btn>
      <!-- Add more static navigation buttons here -->
    </v-app-bar>

    <v-main>
      <v-container fluid style="min-height: 300px;">
        <router-view></router-view>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
export default {
  name: 'BaseLayout',
};
</script>

<style>
/* Add your styles here if needed */
</style>
