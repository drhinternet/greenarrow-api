## Users


### Get a list of users

Get a list of the basic details of all login users on the current organization.

#### URL

    GET /ga/api/v2/users

#### Request Parameters

This API method does not require any additional parameters.

#### Response

The response will be a JSON array where each element contains the following keys.

| Key             | Meaning                                | Example           | Type    |
| --------------- | -------------------------------------- | ----------------- | ------- |
| id              | Internal identifier                    | 123               | Integer |
| full_name       | Full name of this user                 | "Bob Example"     | String  |
| email           | Email address for this user            | "bob@example.com" | String  |
| active          | True or false if this user can sign in | true              | Boolean |
| role            | Role of the user, see table below      | "standard"        | String  |
| show_quick_tips | The user sees tips in the UI           | false             | Boolean |
| permissions     | A permissions hash as described below  | ...               | Hash    |

The permissions hash has an entry for each of the following keys with the
values being the available permissions.

| Permission Key        | Valid Permissions                                                  |
| --------------------- | ------------------------------------------------------------------ |
| mailing_list          | "create", "update", "delete"                                       |
| subscriber            | "create", "update", "delete", "read", "import", "export"           |
| segmentation_criteria | "create", "update", "delete"                                       |
| autoresponder         | "create", "update", "delete", "update_state", "read_stats"         |
| web_form              | "create", "update", "delete                                        |
| custom_field          | "create", "update", "delete"                                       |
| campaign              | "create", "update", "delete", "send", "update_state", "read_stats" |
| campaign/template     | "create", "update", "delete"                                       |
| seed_list             | "create", "update", "delete"                                       |

Here's an example of a valid permissions hash.

    {
      "mailing_list": [ "update" ],
      "autoresponder": [ "update" ],
      "seed_list": [ "create", "update", "delete" ],
    }

#### Example Request

Note that the JSON response will not be "pretty formatted" as it is below.

    > GET /ga/api/v2/users HTTP/1.1
    > Authorization: Basic MTo1ZTk2NDY1Yzg4M2YzMzA5ZjAxMDVhMmUxMDc2NjMyYjY4N2U2MWQy
    > User-Agent: curl/7.24.0 (x86_64-apple-darwin12.0) libcurl/7.24.0 OpenSSL/0.9.8r zlib/1.2.5
    > Host: greenarrow-studio.dev
    > Accept: */*
    >
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
       "data":[
          {
             "active":true,
             "email":"admin@example.com",
             "full_name":"Organization Administrator",
             "id":1,
             "permissions":{
                "mailing_list":[
                   "create",
                   "update",
                   "delete"
                ],
                "subscriber":[
                   "create",
                   "update",
                   "delete",
                   "read",
                   "import",
                   "export"
                ],
                "segmentation_criteria":[
                   "create",
                   "update",
                   "delete"
                ],
                "autoresponder":[
                   "create",
                   "update",
                   "delete",
                   "update_state",
                   "read_stats"
                ],
                "web_form":[
                   "create",
                   "update",
                   "delete"
                ],
                "custom_field":[
                   "create",
                   "update",
                   "delete"
                ],
                "campaign":[
                   "create",
                   "update",
                   "delete",
                   "send",
                   "update_state",
                   "read_stats"
                ],
                "campaign/template":[
                   "create",
                   "update",
                   "delete"
                ],
                "seed_list":[
                   "create",
                   "update",
                   "delete"
                ]
             },
             "role":"system_admin",
             "show_quick_tips":true,
             "time_zone":null
          },
          {
             "active":true,
             "email":"api@example.com",
             "full_name":"API User",
             "id":2,
             "permissions":{
                "mailing_list":[
                   "create",
                   "update",
                   "delete"
                ],
                "subscriber":[
                   "create",
                   "update",
                   "delete",
                   "read",
                   "import",
                   "export"
                ],
                "segmentation_criteria":[
                   "create",
                   "update",
                   "delete"
                ],
                "autoresponder":[
                   "create",
                   "update",
                   "delete",
                   "update_state",
                   "read_stats"
                ],
                "web_form":[
                   "create",
                   "update",
                   "delete"
                ],
                "custom_field":[
                   "create",
                   "update",
                   "delete"
                ],
                "campaign":[
                   "create",
                   "update",
                   "delete",
                   "send",
                   "update_state",
                   "read_stats"
                ],
                "campaign/template":[
                   "create",
                   "update",
                   "delete"
                ],
                "seed_list":[
                   "create",
                   "update",
                   "delete"
                ]
             },
             "role":"system_admin",
             "show_quick_tips":true,
             "time_zone":null
          }
       ]
    }


### Create a new user

Create a new user on the current organization.

#### URL

    POST /ga/api/v2/users

#### Request Parameters

The request body should be a JSON hash in the format of `{ 'user': USER_DETAILS }`
where "USER_DETAILS" is a hash defined below.

| Key             | Meaning                                                            | Example | Type    |
| --------------- | ------------------------------------------------------------------ | ------- | ------- |
| full_name       |                                                                    |         | String  |
| email           |                                                                    |         | String  |
| time_zone       |                                                                    |         | String  |
| active          |                                                                    |         | Boolean |
| role            |                                                                    |         | String  |
| show_quick_tips |                                                                    |         | Boolean |
| permissions     | A permissions hash as described in the 'Users index' section above | ...     | Hash    |

#### Response

The response will be a JSON object in the same format as the response to the users index.

#### Example Request

Note that the JSON response will not be "pretty formatted" as it is below.

    > POST /ga/api/v2/users HTTP/1.1
    > Authorization: Basic MTo1ZTk2NDY1Yzg4M2YzMzA5ZjAxMDVhMmUxMDc2NjMyYjY4N2U2MWQy
    > User-Agent: curl/7.24.0 (x86_64-apple-darwin12.0) libcurl/7.24.0 OpenSSL/0.9.8r zlib/1.2.5
    > Host: greenarrow-studio.dev
    > Accept: */*
    >
    {
        "user": {
            "active":true,
            "email":"bob@example.com",
            "full_name":"The Second Administrator",
            "permissions":{
               "mailing_list":[
                  "create",
                  "update",
                  "delete"
               ],
               "subscriber":[
                  "create",
                  "update",
                  "delete",
                  "read",
                  "import",
                  "export"
               ],
               "segmentation_criteria":[
                  "create",
                  "update",
                  "delete"
               ],
               "autoresponder":[
                  "create",
                  "update",
                  "delete",
                  "update_state",
                  "read_stats"
               ],
               "web_form":[
                  "create",
                  "update",
                  "delete"
               ],
               "custom_field":[
                  "create",
                  "update",
                  "delete"
               ],
               "campaign":[
                  "create",
                  "update",
                  "delete",
                  "send",
                  "update_state",
                  "read_stats"
               ],
               "campaign/template":[
                  "create",
                  "update",
                  "delete"
               ],
               "seed_list":[
                  "create",
                  "update",
                  "delete"
               ]
            },
            "role":"organization_admin",
            "show_quick_tips":true,
            "time_zone":null
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
          "active":true,
          "email":"bob@example.com",
          "full_name":"The Second Administrator",
          "id":3,
          "permissions":{
             "mailing_list":[
                "create",
                "update",
                "delete"
             ],
             "subscriber":[
                "create",
                "update",
                "delete",
                "read",
                "import",
                "export"
             ],
             "segmentation_criteria":[
                "create",
                "update",
                "delete"
             ],
             "autoresponder":[
                "create",
                "update",
                "delete",
                "update_state",
                "read_stats"
             ],
             "web_form":[
                "create",
                "update",
                "delete"
             ],
             "custom_field":[
                "create",
                "update",
                "delete"
             ],
             "campaign":[
                "create",
                "update",
                "delete",
                "send",
                "update_state",
                "read_stats"
             ],
             "campaign/template":[
                "create",
                "update",
                "delete"
             ],
             "seed_list":[
                "create",
                "update",
                "delete"
             ]
          },
          "role":"system_admin",
          "show_quick_tips":true,
          "time_zone":null
       }
    }

### Update an existing user

#### URL

    PUT /ga/api/v2/users/:id

#### Request Parameters

The request body should be a JSON hash in the format of `{ 'user': USER_DETAILS }`
where "USER_DETAILS" is a hash defined in the 'Create user' section above.

#### Response

The response will be a JSON object in the same format as the response to the users index.

#### Example Request

Note that the JSON response will not be "pretty formatted" as it is below.

    > PUT /ga/api/v2/users/3 HTTP/1.1
    > Authorization: Basic MTo1ZTk2NDY1Yzg4M2YzMzA5ZjAxMDVhMmUxMDc2NjMyYjY4N2U2MWQy
    > User-Agent: curl/7.24.0 (x86_64-apple-darwin12.0) libcurl/7.24.0 OpenSSL/0.9.8r zlib/1.2.5
    > Host: greenarrow-studio.dev
    > Accept: */*
    >
    {
        "user": {
            "full_name":"The Second Administrator ZOMG"
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
          "active":true,
          "email":"bob@example.com",
          "full_name":"The Second Administrator ZOMG",
          "id":3,
          "permissions":{
             "mailing_list":[
                "create",
                "update",
                "delete"
             ],
             "subscriber":[
                "create",
                "update",
                "delete",
                "read",
                "import",
                "export"
             ],
             "segmentation_criteria":[
                "create",
                "update",
                "delete"
             ],
             "autoresponder":[
                "create",
                "update",
                "delete",
                "update_state",
                "read_stats"
             ],
             "web_form":[
                "create",
                "update",
                "delete"
             ],
             "custom_field":[
                "create",
                "update",
                "delete"
             ],
             "campaign":[
                "create",
                "update",
                "delete",
                "send",
                "update_state",
                "read_stats"
             ],
             "campaign/template":[
                "create",
                "update",
                "delete"
             ],
             "seed_list":[
                "create",
                "update",
                "delete"
             ]
          },
          "role":"system_admin",
          "show_quick_tips":true,
          "time_zone":null
       }
    }
