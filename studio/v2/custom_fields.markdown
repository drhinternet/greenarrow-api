<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**

- [Custom Fields](#custom-fields)
  - [Attributes](#attributes)
      - [Extra Attributes: text](#extra-attributes-text)
      - [Extra Attributes: text_multiline](#extra-attributes-text_multiline)
      - [Extra Attributes: number](#extra-attributes-number)
      - [Extra Attributes: date, day_of_year](#extra-attributes-date-day_of_year)
      - [Extra Attributes: select_single_dropdown, select_single_radio, select_multiple_checkboxes](#extra-attributes-select_single_dropdown-select_single_radio-select_multiple_checkboxes)
      - [Extra Attributes: booelean](#extra-attributes-booelean)
  - [Get custom field details](#get-custom-field-details)
    - [URL](#url)
    - [Response](#response)
    - [Example Response](#example-response)
  - [Create a new custom field](#create-a-new-custom-field)
    - [URL](#url-1)
    - [Request Parameters](#request-parameters)
    - [Request Payload](#request-payload)
      - [Extra Parameters: text](#extra-parameters-text)
      - [Extra Parameters: text_multiline](#extra-parameters-text_multiline)
      - [Extra Parameters: number](#extra-parameters-number)
      - [Extra Parameters: date, day_of_year](#extra-parameters-date-day_of_year)
      - [Extra Parameters: select_single_dropdown, select_single_radio, select_multiple_checkboxes](#extra-parameters-select_single_dropdown-select_single_radio-select_multiple_checkboxes)
      - [Extra Parameters: booelean](#extra-parameters-booelean)
    - [Response](#response-1)
    - [Example](#example)
  - [Update an existing custom field](#update-an-existing-custom-field)
    - [URL](#url-2)
    - [Request Parameters](#request-parameters-1)
    - [Request Payload](#request-payload-1)
    - [Response](#response-2)
    - [Example](#example-1)

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

##### Extra Attributes: text

| Key            | Meaning                                                                                                                      | Example    | Type    |
| -------------- | ---------------------------------------------------------------------------------------------------------------------------- | ---------- | ------- |
| default_string | The default value for this custom field                                                                                      | "John Doe" | String  |
| minimum_length | The minimum length for this string (Note that if the field is not "Required", then it can be blank regardless of this value) | 10         | Integer |
| maximum_length | The maximum length for this string                                                                                           | 100        | Integer |

##### Extra Attributes: text_multiline

| Key            | Meaning                                                                                                                      | Example    | Type    |
| -------------- | ---------------------------------------------------------------------------------------------------------------------------- | ---------- | ------- |
| default_string | The default value for this custom field                                                                                      | "John Doe" | String  |
| minimum_length | The minimum length for this string (Note that if the field is not "Required", then it can be blank regardless of this value) | 10         | Integer |
| maximum_length | The maximum length for this string                                                                                           | 100        | Integer |
| number_of_rows | The number of rows that should be displayed when rendering this input field                                                  | 5          | Integer |

##### Extra Attributes: number

| Key             | Meaning                                                                                                                     | Example | Type    |
| --------------- | --------------------------------------------------------------------------------------------------------------------------- | ------- | ------- |
| default_integer | The default value for this custom field                                                                                     | 12345   | Integer |
| minimum_value   | The minimum value for this number (Note that if the field is not "Required", then it can be blank regardless of this value) | 100     | Integer |
| maximum_value   | The maximum value for this number                                                                                           | 100000  | Integer |

##### Extra Attributes: date, day_of_year

There are no extra attributes for these fields.

##### Extra Attributes: select_single_dropdown, select_single_radio, select_multiple_checkboxes

| Key     | Meaning                                                   | Example | Type   |
| ------- | --------------------------------------------------------- | ------- | ------ |
| options | An options array composed of the elements described below |         | String |

Options Array Elements:

| Key  | Meaning                                                                                  | Example | Type   |
| ---- | ---------------------------------------------------------------------------------------- | ------- | ------ |
| name | The name of this option; The string value presented in dropdowns, radios, and checkboxes | "Cats"  | String |

##### Extra Attributes: booelean

| Key             | Meaning                                                              | Example | Type    |
| --------------- | -------------------------------------------------------------------- | ------- | ------- |
| default_boolean | This boolean custom field should / should not be selected by default | true    | Boolean |


### Get custom field details

#### URL

    GET /ga/api/v2/mailing_lists/:mailing_list_id/custom_fields

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
      "required": false
    },
    {
      "field_type": "select_multiple_checkboxes",
      "id": 2,
      "instructions": "",
      "mailing_list_id": 1,
      "name": "Car Type",
      "required": false,
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

    POST /ga/api/v2/mailing_lists/:mailing_list_id/custom_fields

#### Request Parameters

| Key             | Meaning                                          | Example |
| --------------- | ------------------------------------------------ | ------- |
| mailing_list_id | The id of the mailing list for this custom field | 17293   |

#### Request Payload

The POST request should have a JSON document in its payload with all of the following keys.

| Key          | Meaning                                                                            | Example                       | Type    |
| ------------ | ---------------------------------------------------------------------------------- | ----------------------------- | ------- |
| name         | The name of the custom field                                                       | "First Name"                  | String  |
| field_type   | The type of this custom field, see the "Custom Field Types" enumerated value below | text                          | String  |
| required     | This custom field is required to be filled out for all subscribers                 | true                          | Boolean |
| instructions | Instructions on how this field should be used                                      | "Enter your first name here." | String  |

The response will have extra parameters in it that are used based upon the field
type. See the tables below for details on these fields.

##### Extra Parameters: text

| Key            | Meaning                                                                                                                      | Example    | Type    |
| -------------- | ---------------------------------------------------------------------------------------------------------------------------- | ---------- | ------- |
| default_string | The default value for this custom field                                                                                      | "John Doe" | String  |
| minimum_length | The minimum length for this string (Note that if the field is not "Required", then it can be blank regardless of this value) | 10         | Integer |
| maximum_length | The maximum length for this string                                                                                           | 100        | Integer |

##### Extra Parameters: text_multiline

| Key            | Meaning                                                                                                                      | Example    | Type    |
| -------------- | ---------------------------------------------------------------------------------------------------------------------------- | ---------- | ------- |
| default_string | The default value for this custom field                                                                                      | "John Doe" | String  |
| minimum_length | The minimum length for this string (Note that if the field is not "Required", then it can be blank regardless of this value) | 10         | Integer |
| maximum_length | The maximum length for this string                                                                                           | 100        | Integer |
| number_of_rows | The number of rows that should be displayed when rendering this input field                                                  | 5          | Integer |

##### Extra Parameters: number

| Key             | Meaning                                                                                                                     | Example | Type    |
| --------------- | --------------------------------------------------------------------------------------------------------------------------- | ------- | ------- |
| default_integer | The default value for this custom field                                                                                     | 12345   | Integer |
| minimum_value   | The minimum value for this number (Note that if the field is not "Required", then it can be blank regardless of this value) | 100     | Integer |
| maximum_value   | The maximum value for this number                                                                                           | 100000  | Integer |

##### Extra Parameters: date, day_of_year

There are no extra parameters for these fields.

##### Extra Parameters: select_single_dropdown, select_single_radio, select_multiple_checkboxes

| Key     | Meaning                                                   | Example | Type   |
| ------- | --------------------------------------------------------- | ------- | ------ |
| options | An options array composed of the elements described below |         | String |

Options Array Elements:

| Key  | Meaning                                                                                  | Example | Type   |
| ---- | ---------------------------------------------------------------------------------------- | ------- | ------ |
| name | The name of this option; The string value presented in dropdowns, radios, and checkboxes | "Cats"  | String |

##### Extra Parameters: booelean

| Key             | Meaning                                                              | Example | Type    |
| --------------- | -------------------------------------------------------------------- | ------- | ------- |
| default_boolean | This boolean custom field should / should not be selected by default | true    | Boolean |

#### Response

A successful response will return the custom field record as described below,
in addition to the "Extra Parameters" listed above.

| Key             | Meaning                                                                            | Example                       | Type    |
| --------------- | ------------------------------------------------                                   | -------                       | ------- |
| id              | The id of the custom field                                                         | 17293                         | Integer |
| mailing_list_id | The id of the mailing list for this custom field                                   | 17293                         | Integer |
| name            | The name of the custom field                                                       | "First Name"                  | String  |
| field_type      | The type of this custom field, see the "Custom Field Types" enumerated value below | text                          | String  |
| required        | This custom field is required to be filled out for all subscribers                 | true                          | Boolean |
| instructions    | Instructions on how this field should be used                                      | "Enter your first name here." | String  |

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

    PUT /ga/api/v2/mailing_lists/:mailing_list_id/custom_fields/:id

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
