var mysql = require('mysql');

module.exports = 
{
   dbproducao: function()
        {
            var connection = mysql.createConnection(
            {
            //    host: '25.85.163.152',
                host: 'localhost',
                user: 'userautohome',
                password: 'UserautohomeMysql1.0bi',
                database: 'autohome'
            });
            return connection;
        },
    dbteste: function()
        {
            var connection = mysql.createConnection(
            {
            //    host: '25.85.163.152',
                host: 'db',
                user: 'root',
                password: 'Comida$05$',
                database: 'autohome'
            });
            return connection;
        }
  
}
