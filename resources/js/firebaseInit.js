import { initializeApp } from 'firebase/app';
import { getFirestore } from 'firebase/firestore';

const firebaseConfig = {

    apiKey: "AIzaSyDJwipXHg8E_qZsbFw6QT-JMKVdTonS1do",
  
    authDomain: "example-chuphospital.firebaseapp.com",
  
    databaseURL: "https://example-chuphospital-default-rtdb.asia-southeast1.firebasedatabase.app",
  
    projectId: "example-chuphospital",
  
    storageBucket: "example-chuphospital.appspot.com",
  
    messagingSenderId: "617738764465",
  
    appId: "1:617738764465:web:f1fc615582eb0962e36290",
  
    measurementId: "G-XYRQNL9VMB"
  
  };
// Initialize Firebase
const app = initializeApp(firebaseConfig);
export const db = getFirestore(app);