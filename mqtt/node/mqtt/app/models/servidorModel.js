module.exports = function(connection, callback)
{

   var getDadosServidor = function(connection, callback)
  {
    connection.query('SELECT * FROM `servidor`', callback);
  }

  return getDadosServidor;
}