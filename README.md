# Websocket Server

This is a simple Websocket server written in PHP.

## How to use it?

Clone this repo and use the Composer to install all dependencies:

```
composer install
```

Now you need to copy the existing .env.example file to .env file. Open it and 
change the default PORT variable if you want. This port must be added to the 
exception list in the firewall on your web server. For example, on Ubuntu:

```
sudo ufw allow 8080/tcp
```

Run the following command to start the server:

```
php websocket-server.php
```

Server can now accept connections and relay messages. To keep server running 
24/7 you should probably use something like a [Supervisord](http://supervisord.org)

## Client side

Open the console in your web browser, enter the following code and hit Enter:

```
var connection = new WebSocket('ws://IP_ADDRESS:PORT');

connection.onopen = function(e) {
    console.log("Connection established!");
};

connection.onmessage = function(e) {
    console.log(e.data);
};
```

You can now send messages:

```
connection.send('This is a message');
```

### AUTHOR

Goran Nikolovski  
Website: http://gorannikolovski.com  
Email: nikolovski84@gmail.com  
