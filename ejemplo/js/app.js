/* 
	Description: Aplicación AngularJS para ruteo y consumo de API BIP!
	Version: 1
	Author: Francisco Capone
	Author Mail: francisco.capone@gmail.com
	Author URI: http://www.franciscocapone.com
*/

var app = angular.module('saldoBip', ['ngRoute']);


app.factory("services", ['$http',
	function($http) {
		var url_servicio = 'http://franciscocapone.com/bip/apiBip/';
		var obj = {};
		obj.getSaldo = function(idTarjetaBip) {
			return $http.get(url_servicio + 'getSaldo/' + idTarjetaBip);
		};

		return obj;
	}
]);

app.controller('saldoCtrl',
	function ($scope, saldo) {
		var original = saldo.data;
		$scope.saldo = angular.copy(original);
	}
);

app.config(['$routeProvider',
	function($routeProvider) {
		$routeProvider.
		when('/', {
			title: 'Ver saldo BIP! App',
			templateUrl: 'templates/formulario.html'
		})
		.when('/ver-saldo/:idTarjetaBip', {
			title: 'Ver saldo BIP! App >> Resultados',
			templateUrl: 'templates/saldo.html',
			controller: 'saldoCtrl',
			resolve: {
				saldo: function(services, $route){
					var idTarjetaBip = $route.current.params.idTarjetaBip;
					return services.getSaldo(idTarjetaBip);
				}
			}
		})
		.otherwise({
			redirectTo: '/'
		});
	}
]);

app.run(['$location', '$rootScope',
	function($location, $rootScope) {
		$rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
			$rootScope.title = current.$$route.title;
		});
	}
]);


$(document).ready(function(){
	$(document).on('click', '#consulta_saldo', function(e)
		{
			e.preventDefault();
			var numTarjeta = $('#num_tarjeta').val();
			if($.trim(numTarjeta) != ''){
				numTarjeta = $.trim(numTarjeta);
				var iPrimerCaracterValido = -1;
				for(var iTmp1=0; iTmp1 <= numTarjeta.length - 1; iTmp1++){ 
					if (numTarjeta.substr(iTmp1,1) != '0'){
						iPrimerCaracterValido = iTmp1;
						break;
					}
				}

				if(iPrimerCaracterValido >= 0){
					numTarjeta = numTarjeta.substring(iPrimerCaracterValido);
				}
				else{
					numTarjeta = '';
				}
			}

			if($.trim(numTarjeta) == ''){
				$('#num_tarjeta').val('');
				alert('Por favor, ingrese el número de su tarjeta Bip!');
				$('#num_tarjeta').focus();
				return false;
			}
			$('#txtNumTarjeta').val(numTarjeta);
			location.href = '#/ver-saldo/'+$('#num_tarjeta').val();
		}
	);
});

/* Función para restringir el ingreso de sólo números en un campo de texto */
function onlyNumbers(e){
	var keynum;
	var keychar;

	if(window.event){  //IE
			keynum = e.keyCode;
	}
	if(e.which){ //Netscape/Firefox/Opera
			keynum = e.which;
	}
	if((keynum == 8 || keynum == 9 || keynum == 46 || (keynum >= 35 && keynum <= 40) ||
		 (event.keyCode >= 96 && event.keyCode <= 105)))return true;

	if(keynum == 110 || keynum == 190){
			var checkdot=document.getElementById('price').value;
			var i=0;
			for(i=0;i<checkdot.length;i++){
					if(checkdot[i]=='.')return false;
			}
			if(checkdot.length==0)document.getElementById('price').value='0';
			return true;
	}
	keychar = String.fromCharCode(keynum);

  return !isNaN(keychar);
}