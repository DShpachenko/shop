# Shop API



#### Установка:

Импортировать дамп БД, изменить в конфиге название БД , пользователя, пароль.

#### Методы:

* Выдача товара по ID

```
    GET - product/find

    входные параметры:
        - requirement int id

    результат:
        {
            "id": "int",
            "name": "string",
            "availability": "int",
            "cost": "int",
            "manufacturer_id": "int",
            "manufacturerName": "string"
        }
```


* Выдача товаров по вхождению подстроки в названии

```
    GET - product/search

    входные параметры:
        - requirement string name
        - int from

    результат :
        [
            {
                "id": "int",
                "name": "string",
                "availability": "int",
                "cost": "int",
                "manufacturer_id": "int",
                "manufacturerName": "string"
            },
            ...
        ]
```


* Выдача товаров по производителю/производителям

```
    GET - product/getByManufacturers

    входные параметры:
        - requirement int array manufacturers

    результат :
        [
            {
                "id": "int",
                "name": "string",
                "availability": "int",
                "cost": "int",
                "manufacturer_id": "int",
                "manufacturerName": "string"
            },
            ...
        ]
```


* Выдача товаров по разделу (только раздел)

```
    GET - product/getBySection

    входные параметры:
        - requirement int section

    результат :
        [
            {
                "id": "int",
                "name": "string",
                "availability": "int",
                "cost": "int",
                "manufacturer_id": "int",
                "manufacturerName": "string"
            },
            ...
        ]
```


* Выдача товаров по разделу и вложенным разделам

```
    GET - product/getBySections

    входные параметры:
        - requirement int section

    результат :
        [
            {
                "id": "int",
                "name": "string",
                "availability": "int",
                "cost": "int",
                "manufacturer_id": "int",
                "manufacturerName": "string"
            },
            ...
        ]
```