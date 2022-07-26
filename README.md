### Librería para leer los códigos PDF417 de las cédulas de ciudadanía de colombia 


## Requerimientos

-   PHP >= 7.1


## Instalación
Puedes instalar el paquete a través de composer:

```json
{  
    "require": {
        "eitol/colombian-cedula-reader": "dev-master"
    }  
}
```

Se requiere tener instalada la siguiente extensión de PHP:

ext-intl

--------------------


## Uso

```php
require __DIR__.'/vendor/autoload.php';

use Eitol\ColombianCedulaReader\ColombianIDCardDecoder;

// Leemos el archivo que contiene una foto 
// del posterior de la cédula
$file = file_get_contents("imagen_de_cedula.jpg");

// Decodificamos
$decoder = new ColombianIDCardDecoder();
$result = $decoder->decode($file);

```

resultado 

![doc/result.png](doc/result.png)

## Colombian PDF417 explanation

note: This document was obtained publicly on the internet 

The Colombian ID contains a 417 pdf code on the back.

You can use the android app "verifcame" or "pdf417 reader" to check the internal data of the code.

fields:

- Afis code
- finger card
- document number
- document type
- document info
- name
- person type
- gender
- birthday
- blood type
- municipality (see pre_divipol_02_agosto_2011)
- department (see pre_divipol_02_agosto_2011)

![tests/test_data/best_quality_1.jpg](tests/testdata/best_quality_1.jpg)

## Explicación

La cédula de ciudadanía de Colombia contiene en su posterior un código pdf417, el cual se debe leer en formato binario. Para extraer información se debe hacer lo siguiente:

Primero leer el código desde la imagen. 
Para Android / iOS puedes usar las librerías de ML Vision.
Si quieres leer el contenido del PDF417 desde el backend entonces no existe una alternativa buena para hacerlo que sea gratuita. Puedes usar zxing pero su rendimiento es demasiado pobre. Si quieres obtener buenos resultados lamentablemente tendrás que pagar por librerías que decodifican el PDF417 como dynamsoft, microblink, etc.

Segundo: Deberás extraer los campos que están en posiciones delimitadas dentro del arreglo de bytes.

| Field             | Start - End | Example                 |
| ----------------- | ----------- | ----------------------- |
| afis code         | 2 - 10      | 30847811                |
| finger card       | 40 - 48     | 16434054                |
| document number   | 48 - 58     | 51907053                |
| last name         | 58 - 80     | GONZALEZ                |
| second last name  | 81 - 104    | MARIN                   |
| first name        | 104 - 127   | MARIA                   |
| middle name       | 127 - 150   | GABRIELA                |
| gender            | 151 - 152   | F (para masculino es M) |
| birthday year     | 152 - 156   | 1967                    |
| birthday month    | 156 - 158   | 01                      |
| birthday day      | 158 - 160   | 28                      |
| municipality code | 160 - 162   | 15 (CUNDINAMARCA)       |
| department code   | 162 - 165   | 001 (BOGOTA, D.C.)      |
| blood type        | 166 - 168   | O+                      |

Cosas a considerar:

El campo document number a veces tiene ‘0’ como padding a la izquierda. Deberás eliminarlos.

Hay varios campos (nombre, apellido, etc) que tienen el carácter “0x00” (null) a la derecha como padding. Deberás eliminarlos.

Se recomienda usar un visualizador binario para observar los campos y debuguear en tu proceso de desarrollo




