# API-RESTFul-Bip v1.0
## API RESTFul para obtener el saldo de una tarjeta Bip! (Chile)
### Para la creación de dicha API se utilizó el Framework PHP Slim
#### En la carpeta ejemplo se encuentra una aplicación programada en AngularJS para poder consumir la API antes señalada

## Documentación API
El único método soportado es __GET__
```
GET /api/getSaldo/{id_tarjeta}
```

| METHOD        | ENDPOINT                          | USAGE          | RETURNS   |
| ------------- |:----------------------------------| :--------------| :---------|
| GET           | api/getSaldo/{id_tarjeta} | Get bip Status | bip Status|

| ENDPOINT                                                             |
| :--------------------------------------------------------------------|
| GET __http://bip.franciscocapone.com/api/getSaldo/{id_tarjeta}  |

| PARAMETROS   | VALOR                                       |
|--------------|:--------------------------------------------|
| id_tarjeta           | Número de identificación de la tarjeta bip! |



### Ejemplo de uso
Al hacer una llamada GET se obtiene un JSON con la data del estado de la tarjeta
```
http://bip.franciscocapone.com/api/getSaldo/19420273
```
donde __19420273__ corresponde al número de identificación de la tarjeta Bip.
Siguiendo el ejemplo anterior, se obtiene como respuesta el siguiente JSON:
```
{
  numero_tarjeta: "19420273",
  estado_contrato: "Contrato Activo",
  saldo: "$3.040",
  fecha_saldo: "31/08/2015 20:22"
}
```
### Formatos de respuesta
El formato de respuesta de la API es JSON (JavaScript Object Notation)

##### Ejemplos para la ejecución de la API
[Llamado a la API para consultar por el saldo de una tarjeta](http://bip.franciscocapone.com/api/getSaldo/19420273)

<img src="http://bip.franciscocapone.com/ejemplo_uso.png" alt="Ejemplo llamado a API" width="1202" height="778" border="2" />

[Ejemplo de consumo de la API mediante una aplicación AngularJS](http://bip.franciscocapone.com/ejemplo/)

<img src="http://bip.franciscocapone.com/ejemplo_app.png" alt="Ejemplo App AngularJS" width="670" height="455" border="2" />

###### Links de referencia:
[Framework PHP Slim](http://www.slimframework.com)

[Recursos de ayuda y clases de apoyo para el scrapping de la fuente oficial de los datos de una tarjeta Bip!](https://github.com/Psep/apis-servicios)

[Página oficial de Transantiago: Bip! en línea](http://pocae.tstgo.cl/PortalCAE-WAR-MODULE/)
