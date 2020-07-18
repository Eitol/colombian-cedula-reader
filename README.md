### Librería para leer los códigos PDF417 de las cédulas de ciudadanía de colombia 


## Requerimientos

-   PHP >= 7.1


## Instalación
Puedes instalar el paquete a través de composer:

```json
{  
    "require": {
        "eitol/colombian-cedula-reader": "master"
    }  
}
```

Se requiere tener instalada la siguiente extensión de PHP:

ext-intl

--------------------


## Uso

// TODO
```php
use Eitol\ColombianCedulaReader\ColombianIDCardDecoder;

// Leemos el archivo que contiene una foto 
// del posterior de la cédula
$file = file_get_contents("imagen_de_cedula.jpg");

// Decodificamos
$decoder = new ColombianIDCardDecoder();
$result = $decoder->decode($file);

```

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


