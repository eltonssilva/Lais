var dbconnection = require('../../config/dbConnection');

module.exports = function(app)
{
	app.get('/', function(req, res)
	{

		console.log("Teste");

		var connection = dbconnection();

		connection.query('SELECT * FROM `servidor`', function(error, result)
		{
			console.log("Teste 4");
			console.log(result);
			res.render("main/main", ('DataBase', result ));
			
		});

	//	res.render("main/main");
	});
};


// modulo.export = modulomain;