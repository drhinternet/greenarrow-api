## Organizations


### Organization Attributes

| Key             | Meaning                                                | Example                                  | Type    |
| --------------- | ------------------------------------------------------ | ---------------------------------------- | ------- |
| id              | Internal identifier for this organization              | 123                                      | Integer |
| name            | Identifying (unique) name                              | "System Organization"                    | String  |
| anniversary_day | Day of the month that this organization's quotas reset | 17                                       | Integer |
| time_zone_name  | The time zone for times in this organization           | "(GMT-06:00) Central Time (US & Canada)" | String  |
| html_header     | The HTML header prepended to all emails sent           | `"<h1>Hello from My Org</h1>"`           | String  |
| html_footer     | The HTML footer appended to all emails sent            | `"<h1>Goodbye!</h1>"`                    | String  |
| text_header     | The Text header prepended to all emails sent           | "Hello from My Org"                      | String  |
| text_footer     | The Text footer appended to all emails sent            | "Bye!"                                   | String  |


### Get a list of organizations

#### URL

    GET /ga/api/v2/organizations

#### Response

The response will be a JSON array where each element contains an organization object as defined above.


### Create a new organization

#### URL

    POST /ga/api/v2/organizations

#### Payload

You should send a JSON object that is of the format `{ "organization" => { ... } }`
with the attributes as defined above. No `id` field is needed for creating a new organization.

#### Response

The response will be a JSON object that is an organization object as defined
above containing details about the new organization.


### Update an existing organization

#### URL

    PUT /ga/api/v2/organizations/:organization_id

#### Payload

You should send a JSON object that is of the format `{ "organization" => { ... } }`
with the attributes as defined above. No `id` field is needed in the JSON object
itself, as it is specified on the URL.

#### Response

The response will be a JSON object that is an organization object as defined
above containing details about the updated organization.
