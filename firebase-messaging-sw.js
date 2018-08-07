importScripts('https://www.gstatic.com/firebasejs/4.6.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/4.6.2/firebase-messaging.js')

var config = {
    apiKey: "AIzaSyB11eakCFO3jf_aSdxQZJYKI5OXwOVv53s",
    authDomain: "party-2e6be.firebaseapp.com",
    databaseURL: "https://party-2e6be.firebaseio.com",
    projectId: "party-2e6be",
    storageBucket: "party-2e6be.appspot.com",
    messagingSenderId: "425523526587"
};
firebase.initializeApp(config);

const messaging = firebase.messaging();

messaging.setBackgroundMessageHandler(function(payload){
    // console.log('onMessage',payload);
    // console.log(payload.notification.body);
    const title = payload.notification.title;
    const options = {
        body : payload.notification.body,
        icon : payload.notification.icon,
        data : payload.notification.click_action
    }

    return self.registration.showNotification(title,options);
})

