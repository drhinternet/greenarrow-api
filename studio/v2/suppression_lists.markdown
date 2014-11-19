<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**

- [Suppression Lists](#suppression-lists)
  - [Suppression List Attributes](#suppression-list-attributes)
  - [Suppressed Address Attributes](#suppressed-address-attributes)
  - [Address Formats](#address-formats)
  - [Get a list of suppression lists](#get-a-list-of-suppression-lists)
    - [URL](#url)
    - [Response](#response)
  - [Create a new suppression list](#create-a-new-suppression-list)
    - [URL](#url-1)
    - [Post Data](#post-data)
    - [Response](#response-1)
  - [Update an existing suppression list](#update-an-existing-suppression-list)
    - [URL](#url-2)
    - [Response](#response-2)
  - [Get a list of suppressed addresses](#get-a-list-of-suppressed-addresses)
    - [URL](#url-3)
    - [Response](#response-3)
  - [Add new suppressed addresses](#add-new-suppressed-addresses)
    - [URL](#url-4)
    - [Post Data](#post-data-1)
  - [Remove an address from the suppression list](#remove-an-address-from-the-suppression-list)
    - [URL](#url-5)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Suppression Lists


### Suppression List Attributes

| Key             | Meaning                                                                                     | Example                   | Type    |
| --------------- | ------------------------------------------------------------------------------------------- | ------------------------- | ------- |
| id              | Internal identifier for this suppression list                                               | 123                       | Integer |
| organization_id | The organization this suppression list belongs to                                           | 123                       | Integer |
| name            | Unique name of this list                                                                    | "Invalid Email Addresses" | String  |
| global          | This suppression list is global to this system                                              | false                     | Boolean |
| mailing_list_id | The mailing list this suppression list is for, or NULL if it is for the entire organization | `NULL`                    | Integer |


### Suppressed Address Attributes

| Key                 | Meaning                                                                        | Example           | Type    |
| ------------------- | ------------------------------------------------------------------------------ | ----------------- | ------- |
| id                  | Internal identifier for this address                                           | 123               | Integer |
| suppression_list_id | Identifier of the suppression list for this address                            | 123               | Integer |
| organization_id     | Organization ID for this address                                               | 123               | Integer |
| user_id             | The user ID that added this address                                            | 123               | Integer |
| email               | Address used by this record. See the "Address Formats" table below for details | "bob@example.com" | String  |
| address_type        | Type of this address, see the "Address Formats" table below                    | "a"               | String  |


### Address Formats

| Value of `address_type` | Format of `email`                    | Usage                                       |
| ----------------------- | ------------------------------------ | ------------------------------------------- |
| `"a"`                   | `"bob@example.com"`                  | Email address is matched case-insensitively |
| `"d"`                   | `"@example.com"`                     | All addresses at this domain are matched    |
| `"m"`                   | `"8629e8a722df2930a7513c4955ff886b"` | The MD5 of the email address is matched     |


### Get a list of suppression lists

#### URL

    GET /ga/api/v2/suppression_lists

#### Response

Returns an array of suppression lists.


### Create a new suppression list

#### URL

    POST /ga/api/v2/suppression_lists

#### Post Data

    {
      "suppression_list": {
        "name": "New Suppression List",
        "mailing_list_id": null
      }
    }

#### Response

Returns a suppression list object.


### Update an existing suppression list

#### URL

    PUT /ga/api/v2/suppression_lists/:suppression_list_id

#### Response

Returns the updated suppression list object.


### Get a list of suppressed addresses

#### URL

    GET /ga/api/v2/suppression_lists/:suppression_list_id/suppressed_addresses?page=0&limit=250

#### Response

This endpoint returns an array of suppressed addresses.


### Add new suppressed addresses

#### URL

    POST /ga/api/v2/suppression_lists/:suppression_list_id/suppressed_addresses

#### Post Data

This endpoint accepts a "data" parameter that contains an array of addresses.

    {
      "data": [
        "@example.com",
        "bob@example.com",
        "8629e8a722df2930a7513c4955ff886b"
      ]
    }


### Remove an address from the suppression list

#### URL

    DELETE /ga/api/v2/suppression_lists/:suppression_list_id/suppressed_addresses/:id

The value of `:id` can either be the internal identifier of the suppressed
address or the address of the record.
