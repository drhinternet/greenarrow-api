<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**

- [Custom Fields](#custom-fields)
  - [Attributes](#attributes)
      - [Extra Attributes: Responses](#extra-attributes-responses)
      - [Extra Attributes: text fields](#extra-attributes-text-fields)
      - [Extra Attributes: text_multiline fields](#extra-attributes-text_multiline-fields)
      - [Extra Attributes: number fields](#extra-attributes-number-fields)
      - [Extra Attributes: date and day_of_year fields](#extra-attributes-date-and-day_of_year-fields)
      - [Extra Attributes: select_single_dropdown, select_single_radio, and select_multiple_checkboxes fields](#extra-attributes-select_single_dropdown-select_single_radio-and-select_multiple_checkboxes-fields)
      - [Extra Attributes: boolean fields](#extra-attributes-boolean-fields)
  - [Get custom field details](#get-custom-field-details)
    - [URL](#url)
    - [Response](#response)
    - [Example Response](#example-response)
  - [Create a new custom field](#create-a-new-custom-field)
    - [URL](#url-1)
    - [Request Parameters](#request-parameters)
    - [Request Payload](#request-payload)
    - [Response](#response-1)
    - [Example](#example)
  - [Update an existing custom field](#update-an-existing-custom-field)
    - [URL](#url-2)
    - [Request Parameters](#request-parameters-1)
    - [Request Payload](#request-payload-1)
    - [Response](#response-2)
    - [Example](#example-1)
  - [Deleting a custom field](#deleting-a-custom-field)
    - [URL](#url-3)
    - [Request Parameters](#request-parameters-2)
    - [Request Payload](#request-payload-2)
    - [Response](#response-3)
    - [Example](#example-2)
  - [Promote a custom field](#promote-a-custom-field)
    - [URL](#url-4)
    - [Request Parameters](#request-parameters-3)
    - [Request Payload](#request-payload-3)
    - [Response](#response-4)
    - [Example](#example-3)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Custom Fields


### Attributes

The POST request should have a JSON document in its payload with all of the following keys.

| Key          | Meaning                                                                            | Example                       | Type    |
| ------------ | ---------------------------------------------------------------------------------- | ----------------------------- | ------- |
| id           | The primary key for this custom field                                              | 123                           | Integer |
| name         | The name of the custom field                                                       | "First Name"                  | String  |
| field_type   | The type of this custom field, see the "Custom Field Types" enumerated value below | text                          | String  |
| required     | This custom field is required to be filled out for all subscribers                 | true                          | Boolean |
| instructions | Instructions on how this field should be used                                      | "Enter your first name here." | String  |

The response will have extra attributes in it that are used based upon the field
type. See the tables below for details on these fields.

[See the "Custom Field Types" enumerated value](./../README.markdown#custom-field-types)

##### Extra Attributes: Responses

The following keys are included when the custom field is sent back in a JSON
response. These keys are not valid input values.

| Key       | Meaning                                         | Example | Type    |
| --------- | ----------------------------------------------- | ------- | ------- |
| is_global | This custom field is global to the organization | false   | Boolean |

##### Extra Attributes: text fields

| Key            | Meaning                                                                                                                      | Example    | Type    |
| -------------- | ---------------------------------------------------------------------------------------------------------------------------- | ---------- | ------- |
| default_string | The default value for this custom field                                                                                      | "John Doe" | String  |
| minimum_length | The minimum length for this string (Note that if the field is not "Required", then it can be blank regardless of this value) | 10         | Integer |
| maximum_length | The maximum length for this string                                                                                           | 100        | Integer |

##### Extra Attributes: text_multiline fields

| Key            | Meaning                                                                                                                      | Example    | Type    |
| -------------- | ---------------------------------------------------------------------------------------------------------------------------- | ---------- | ------- |
| default_string | The default value for this custom field                                                                                      | "John Doe" | String  |
| minimum_length | The minimum length for this string (Note that if the field is not "Required", then it can be blank regardless of this value) | 10         | Integer |
| maximum_length | The maximum length for this string                                                                                           | 100        | Integer |
| number_of_rows | The number of rows that should be displayed when rendering this input field                                                  | 5          | Integer |

##### Extra Attributes: number fields

| Key             | Meaning                                                                                                                     | Example | Type    |
| --------------- | --------------------------------------------------------------------------------------------------------------------------- | ------- | ------- |
| default_integer | The default value for this custom field                                                                                     | 12345   | Integer |
| minimum_value   | The minimum value for this number (Note that if the field is not "Required", then it can be blank regardless of this value) | 100     | Integer |
| maximum_value   | The maximum value for this number                                                                                           | 100000  | Integer |

##### Extra Attributes: date and day_of_year fields

There are no extra attributes for these fields.

##### Extra Attributes: select_single_dropdown, select_single_radio, and select_multiple_checkboxes fields

| Key     | Meaning                                                   | Example | Type   |
| ------- | --------------------------------------------------------- | ------- | ------ |
| options | An options array composed of the elements described below |         | String |

Options Array Elements:

| Key  | Meaning                                                                                  | Example | Type   |
| ---- | ---------------------------------------------------------------------------------------- | ------- | ------ |
| name | The name of this option; The string value presented in dropdowns, radios, and checkboxes | "Cats"  | String |

##### Extra Attributes: boolean fields

| Key             | Meaning                                                              | Example | Type    |
| --------------- | -------------------------------------------------------------------- | ------- | ------- |
| default_boolean | This boolean custom field should / should not be selected by default | true    | Boolean |


### Get custom field details

#### URL

To get the custom fields that apply to a mailing list (this includes both
custom fields that are attached to this mailing list and global custom fields):

    GET /ga/api/v2/mailing_lists/:mailing_list_id/custom_fields

To get the custom fields that are global to the organization:

    GET /ga/api/v2/custom_fields

#### Response

The response will be an array of custom field objects, as defined in the "Attributes" section above.

#### Example Response

```json
{
  "success": true,
  "data": [
    {
      "default_string": "",
      "field_type": "text",
      "id": 1,
      "instructions": "",
      "mailing_list_id": 1,
      "maximum_length": null,
      "minimum_length": null,
      "name": "Subscriber Name",
      "required": false,
      "is_global": false
    },
    {
      "field_type": "select_multiple_checkboxes",
      "id": 2,
      "instructions": "",
      "mailing_list_id": 1,
      "name": "Car Type",
      "required": false,
      "is_global": false,
      "options": [
        {
          "id": 2,
          "index": 2,
          "name": "Minivan"
        },
        {
          "id": 3,
          "index": 3,
          "name": "Passenger Car"
        },
        {
          "id": 4,
          "index": 4,
          "name": "Truck"
        },
        {
          "id": 5,
          "index": 5,
          "name": "Big Rig"
        }
      ]
    }
  ],
  "error_code": null,
  "error_message": null
}
```


### Create a new custom field

#### URL

To create a new custom field on a mailing list:

    POST /ga/api/v2/mailing_lists/:mailing_list_id/custom_fields

To create a new custom field that is global to the organization:

    POST /ga/api/v2/custom_fields

#### Request Parameters

| Key             | Meaning                                          | Example |
| --------------- | ------------------------------------------------ | ------- |
| mailing_list_id | The id of the mailing list for this custom field | 17293   |

#### Request Payload

See the "Attributes" section above for an explanation of the custom field
fields. The JSON object should be a child of the `custom_field` key.

#### Response

A successful response will return the custom field record as described below,
in addition to the "Extra Parameters" listed above.

A failure will return a standard error response with an explanation of what went wrong.

#### Example

```
> POST /ga/api/v2/mailing_lists/1/custom_fields HTTP/1.1
> Authorization: Basic MTo1ZTk2NDY1Yzg4M2YzMzA5ZjAxMDVhMmUxMDc2NjMyYjY4N2U2MWQy
> User-Agent: curl/7.24.0 (x86_64-apple-darwin12.0) libcurl/7.24.0 OpenSSL/0.9.8r zlib/1.2.5
> Host: greenarrow-studio.dev
> Accept: */*
>
{
   "custom_field":{
      "default_string":"",
      "field_type":"text",
      "instructions":"",
      "maximum_length":2,
      "minimum_length":1,
      "name":"text",
      "required":false
   }
}
< HTTP/1.1 200 OK
< Cache-Control: no-cache, no-store, max-age=0, must-revalidate
< Pragma: no-cache
< Expires: Fri, 01 Jan 1990 00:00:00 GMT
< Content-Type: application/json; charset=utf-8
< X-UA-Compatible: IE=Edge
< Set-Cookie: _session_id=458055a23f26f844e74f8cd7300f6445; path=/; HttpOnly
< X-Request-Id: f6e40d578ed1d9c418cca45e1b7fe532
< X-Runtime: 0.025540
< Connection: close
<
{
   "success":true,
   "data":{
      "default_string":"",
      "field_type":"text",
      "id":3,
      "instructions":"",
      "mailing_list_id":1,
      "maximum_length":2,
      "minimum_length":1,
      "name":"text",
      "required":false
   }
}
```


### Update an existing custom field

#### URL

Update a custom field that is associated with a single mailing list:

    PUT /ga/api/v2/mailing_lists/:mailing_list_id/custom_fields/:id

Update a custom field that is global to the organization:

    PUT /ga/api/v2/custom_fields/:id

#### Request Parameters

| Key             | Meaning                                          | Example |
| --------------- | ------------------------------------------------ | ------- |
| id              | The id of the custom field                       | 123     |
| mailing_list_id | The id of the mailing list for this custom field | 17293   |

#### Request Payload

The PUT request should have a JSON document in its payload in the same format
as when creating a new custom field. Some or all of the parameters may be
omitted when updating an existing record.

#### Response

A successful response will return the custom field record described in the "Create a new custom field" section above.

A failure will return a standard error response with an explanation of what went wrong.

#### Example

    > PUT /ga/api/v2/mailing_lists/1/custom_fields/3 HTTP/1.1
    > Authorization: Basic MTo1ZTk2NDY1Yzg4M2YzMzA5ZjAxMDVhMmUxMDc2NjMyYjY4N2U2MWQy
    > User-Agent: curl/7.24.0 (x86_64-apple-darwin12.0) libcurl/7.24.0 OpenSSL/0.9.8r zlib/1.2.5
    > Host: greenarrow-studio.dev
    > Accept: */*
    >
    {
       "custom_field":{
          "maximum_length":200
       }
    }
    < HTTP/1.1 200 OK
    < Cache-Control: no-cache, no-store, max-age=0, must-revalidate
    < Pragma: no-cache
    < Expires: Fri, 01 Jan 1990 00:00:00 GMT
    < Content-Type: application/json; charset=utf-8
    < X-UA-Compatible: IE=Edge
    < Set-Cookie: _session_id=458055a23f26f844e74f8cd7300f6445; path=/; HttpOnly
    < X-Request-Id: f6e40d578ed1d9c418cca45e1b7fe532
    < X-Runtime: 0.025540
    < Connection: close
    <
    {
       "success":true,
       "data":{
          "default_string":"",
          "field_type":"text",
          "id":3,
          "instructions":"",
          "mailing_list_id":1,
          "maximum_length":200,
          "minimum_length":1,
          "name":"text",
          "required":false
       }
    }


### Deleting a custom field

#### URL

Delete a custom field that is associated with a single mailing list:

    DELETE /ga/api/v2/mailing_lists/:mailing_list_id/custom_fields/:id

Delete a custom field that is global to the organization:

    DELETE /ga/api/v2/custom_fields/:id

#### Request Parameters

| Key             | Meaning                                          | Example |
| --------------- | ------------------------------------------------ | ------- |
| id              | The id of the custom field                       | 123     |
| mailing_list_id | The id of the mailing list for this custom field | 17293   |

#### Request Payload

This request has no payload.

#### Response

A successful response will return an empty success response:

```
{
  "success": true,
  "data": null,
  "error_code": null,
  "error_message": null
}
```

A failure will return a standard error response with an explanation of what went wrong.

#### Example

```
> DELETE custom_fields/8 HTTP/1.1
> Authorization: Basic MTpjMmUzNzJmMDAxNmQyYWNhZDIyZjJjYzNhMzQwNWY4MDc5NWVlMThh
> Accept: application/json
> Content-Type: application/json

< Content-Type: application/json; charset=utf-8
< X-UA-Compatible: IE=Edge
< ETag: "f744395dc73a323ce47b552d60a1c6cb"
< Cache-Control: max-age=0, private, must-revalidate
< Set-Cookie: _session_id=3725ce5c714b5298dfddc07ddbf08cef; path=/; HttpOnly
< X-Request-Id: bb1debcd7215b30b540a26e6d7cff517
< X-Runtime: 0.018141
< Connection: close
< Server: thin 1.5.0 codename Knife

{
  "success": true,
  "data": null,
  "error_code": null,
  "error_message": null
}
```



### Promote a custom field

#### URL

Promote a custom field to be an organization global custom field:

    POST /ga/api/v2/custom_fields/promote

Custom Fields that are associated with a single mailing list may be promoted to
be global to the organization. Custom Fields must have a unique name across the
organization in order to be promoted to be a global custom field.

#### Request Parameters

| Key               | Meaning                                               |
| ----------------- | ----------------------------------------------------- |
| `organization_id` | The ID of the organization that owns the custom field |

#### Request Payload

<table>
  <tr>
    <td colspan="2">
      <b>custom_field_promoter</b><br><em>hash</em><br>
      <table>
        <tr>
          <td><b>custom_field_id</b><br><em>integer</em></td>
          <td>ID of the custom field to promote</td>
        </tr>
      </table>
    </td>
  </tr>
</table>

#### Response

A successful response will return the same output as [Create a new custom field](#create-a-new-custom-field).

A failure will return a standard error response with an explanation of what went wrong.

#### Example

```
> POST /ga/api/custom_fields/promote HTTP/1.1
> Authorization: Basic MTozNTZjNTg0ZWM4YWJlMWQ0NDY0OGZlMTY3MmVkM2ZlYmVkYTQxNWRh
> Accept: application/json
> Content-Type: application/json

{
  "promote": {
    "custom_field_id": 7
  }
}

< Content-Type: application/json; charset=utf-8
< X-UA-Compatible: IE=Edge
< ETag: "e23799d92ddae1f210549ac8d6791e43"
< Cache-Control: max-age=0, private, must-revalidate
< Set-Cookie: _session_id=92dd9834947ebd4336a18b11df1daa80; path=/; HttpOnly
< X-Request-Id: 84d088cd5055fd93cb28ebc156381405
< X-Runtime: 0.026102
< Connection: close
< Server: thin 1.5.0 codename Knife

{
  "success": true,
  "data": {
    "default_string": "",
    "field_type": "text",
    "id": 7,
    "instructions": "",
    "mailing_list_id": null,
    "maximum_length": null,
    "minimum_length": null,
    "name": "local field 5",
    "required": false,
    "is_global": true
  },
  "error_code": null,
  "error_message": null
}
```
