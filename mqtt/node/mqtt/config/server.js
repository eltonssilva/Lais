var express = require('express');
var consign = require('consign');
var app = express();
app.set('view engine', 'ejs');
app.set ('views', './app/views');

consign()
.include('config/dbConnection.js')
.into(app);
//consign().include('/app/models');

module.exports = app;