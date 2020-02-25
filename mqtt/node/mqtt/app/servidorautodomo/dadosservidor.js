var dbconnection = require('../../config/dbConnection');
//var connection = dbconnection();

module.exports = function()
{
        
        
		connection.query('SELECT * FROM `servidor`', function(error, result)
		{
			if (error) throw error;
			console.log(result[0].id);
			return (result[0].id);
			
			
		});

}
