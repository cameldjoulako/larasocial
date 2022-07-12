// creating express instance
var express = require("express");
var app = express();
 
// creating http instance
var http = require("http").createServer(app);
 
// creating socket io instance
var io = require("socket.io")(http, {
    "cors": {
        "origin": "*"
    }
});
 
// start the server
http.listen(3000, function () {
    console.log("Server started");

    var users = [];

    io.on("connection", function (socket) {
        // console.log("User connected", socket.id);

        socket.on("user_connected", function (id) {
            users[id] = socket.id;
        });

        socket.on("post_updated", function (data) {
            socket.broadcast.emit("post_updated", data);
        });

        socket.on("post_deleted", function (data) {
            socket.broadcast.emit("post_deleted", data);
        });

        // socket.on("post_added", function (data) {
            // send event to those who are user's friends
            // io.emit("post_added", data);
        // });
    });
});