// Création de la connexion WebSocket sur le port 8080
const conn = new WebSocket('ws://localhost:8080');
const messagesDiv = document.getElementById('chat-messages');
const messageForm = document.getElementById('message-form');
const messageInput = document.getElementById('message-input');

// Actions à effectuer lorsque la connexion est établie
conn.onopen = function(e) {
    console.log("Connexion établie!");
};

// Actions à effectuer lorsqu'un message est reçu
conn.onmessage = function(e) {
    // traitement json reçu
    msgArr = JSON.parse(e.data);
    const message = document.createElement('div');
    message.textContent = msgArr["author"] + " a écrit : " + msgArr["message"];
    // message.textContent = e.data;
    message.className = 'message received';
    messagesDiv.appendChild(message);
    messagesDiv.scrollTop = messagesDiv.scrollHeight;
};

// Actions à effectuer lorsqu'une erreur survient
conn.onerror = function(e) {
    console.error("Erreur de connexion WebSocket : ", e);
};

// Actions à effectuer le message est envoyé
messageForm.onsubmit = function(e) {
    e.preventDefault();
    if (messageInput.value) {
        const message = document.createElement('div');
        console.log(messageInput.value);
        let authorPseudo = document.forms["message-form"].elements["message-pseudo"].value;
        let authorId = document.forms["message-form"].elements["message-user-id"].value;
        message.textContent = authorPseudo + " (vous) : " + messageInput.value;
        message.className = 'message sent';
        messagesDiv.appendChild(message);
        let msgAndauthor = '{"message":"'+messageInput.value+'","author":"'+authorPseudo+'","authorId":"'+authorId+'"}';
        conn.send(msgAndauthor);
        // conn.send(messageInput.value);
        messageInput.value = '';
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }
};