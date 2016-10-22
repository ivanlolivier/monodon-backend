---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/docs/collection.json)
<!-- END_INFO -->

#general
<!-- START_817d3da13b9ffab89ce801b090b7bdf6 -->
## Creates clinic

Creates a new clinic

> Example request:

```bash
curl "http://monodon.dev/api/clinics" \
-H "Accept: application/json" \
    -d "name"="doloremque" \
    -d "address"="doloremque" \
    -d "phones"="doloremque" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://monodon.dev/api/clinics",
    "method": "POST",
    "data": {
        "name": "doloremque",
        "address": "doloremque",
        "phones": "doloremque"
},
        "headers": {
    "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
console.log(response);
});
```


### HTTP Request
`POST api/clinics`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  required  | Maximum: `255`
    address | string |  required  | Maximum: `255`
    phones | array |  optional  | 

<!-- END_817d3da13b9ffab89ce801b090b7bdf6 -->
<!-- START_e8cb0bf1c77361b59396d7927ed24fdf -->
## Shows clinic

Shows the information of a clinic specified by id

> Example request:

```bash
curl "http://monodon.dev/api/clinics/{clinic}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://monodon.dev/api/clinics/{clinic}",
    "method": "GET",
        "headers": {
    "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
console.log(response);
});
```

> Example response:

```json
{
    "data": {
        "id": null,
        "name": null,
        "address": null,
        "phones": [
            ""
        ]
    }
}
```

### HTTP Request
`GET api/clinics/{clinic}`

`HEAD api/clinics/{clinic}`


<!-- END_e8cb0bf1c77361b59396d7927ed24fdf -->
<!-- START_c19a3442a4625f88ce07b7e7bcd5e268 -->
## Updates a clinic

Updates a clinic

> Example request:

```bash
curl "http://monodon.dev/api/clinics/{clinic}" \
-H "Accept: application/json" \
    -d "name"="vitae" \
    -d "address"="vitae" \
    -d "phones"="vitae" \

```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://monodon.dev/api/clinics/{clinic}",
    "method": "PUT",
    "data": {
        "name": "vitae",
        "address": "vitae",
        "phones": "vitae"
},
        "headers": {
    "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
console.log(response);
});
```


### HTTP Request
`PUT api/clinics/{clinic}`

#### Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    name | string |  required  | Maximum: `255`
    address | string |  required  | Maximum: `255`
    phones | array |  optional  | 

<!-- END_c19a3442a4625f88ce07b7e7bcd5e268 -->
<!-- START_86db2924d725c9bc9768a417095f0e66 -->
## Show patient (me)

Shows logged patient's info

> Example request:

```bash
curl "http://monodon.dev/api/patients/me" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://monodon.dev/api/patients/me",
    "method": "GET",
        "headers": {
    "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
console.log(response);
});
```

> Example response:

```json
null
```

### HTTP Request
`GET api/patients/me`

`HEAD api/patients/me`


<!-- END_86db2924d725c9bc9768a417095f0e66 -->
<!-- START_af9e328446da20b0254c610784e0ad32 -->
## Updates patient (me)

Updates the information of the patient logged

> Example request:

```bash
curl "http://monodon.dev/api/patients/me" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://monodon.dev/api/patients/me",
    "method": "PUT",
        "headers": {
    "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
console.log(response);
});
```


### HTTP Request
`PUT api/patients/me`


<!-- END_af9e328446da20b0254c610784e0ad32 -->
<!-- START_f68416bf50b405d435dde1ec3644606a -->
## Show patient

Shows a patient info specified by id

> Example request:

```bash
curl "http://monodon.dev/api/patients/{patient}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://monodon.dev/api/patients/{patient}",
    "method": "GET",
        "headers": {
    "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
console.log(response);
});
```

> Example response:

```json
null
```

### HTTP Request
`GET api/patients/{patient}`

`HEAD api/patients/{patient}`


<!-- END_f68416bf50b405d435dde1ec3644606a -->
<!-- START_9595666a103e105bb3f677f002653307 -->
## Creates patient

Creates a new patient

> Example request:

```bash
curl "http://monodon.dev/api/patients" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://monodon.dev/api/patients",
    "method": "POST",
        "headers": {
    "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
console.log(response);
});
```


### HTTP Request
`POST api/patients`


<!-- END_9595666a103e105bb3f677f002653307 -->
<!-- START_423bbb3c42a5978f387dafe2fcae2089 -->
## Updates patient

Updates a patient's info specified by id

> Example request:

```bash
curl "http://monodon.dev/api/patients/{patient}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://monodon.dev/api/patients/{patient}",
    "method": "PUT",
        "headers": {
    "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
console.log(response);
});
```


### HTTP Request
`PUT api/patients/{patient}`


<!-- END_423bbb3c42a5978f387dafe2fcae2089 -->
