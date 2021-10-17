const mysql = require("mysql2");

const connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: 'bamanx',
    database: 'recipio'
})

connection.connect(function (err){
    if (err) throw err;
})

module.exports = connection;


