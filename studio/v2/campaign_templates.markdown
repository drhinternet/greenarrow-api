<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**

- [Campaign Templates](#campaign-templates)
  - [Create a new template](#create-a-new-template)
    - [URL](#url)
    - [Request Parameters](#request-parameters)
    - [Response](#response)
    - [Example Request](#example-request)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Campaign Templates


### Create a new template

#### URL

    POST /ga/api/v2/mailing_lists/:mailing_list_id/templates

#### Request Parameters

The POST request should have a JSON document in its payload with at least keys
that marked with bold in the following list:

| Key                                                                 | Meaning                                                                                                                                 | Example                                                                                                                | Type     |
| ------------------------------------------------------------------- | --------------------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------- | -------- |
| template.name                                                       | The name of the template                                                                                                                | "Template 1"                                                                                                           | String   |
| template.mailing_list_id                                            | The id of a Mailing List the Template belongs to                                                                                        | 1                                                                                                                      | Integer  |
| template.mailing_list_name                                          | The name of a Mailing List the Template belongs to                                                                                      | "Mailing List 1"                                                                                                       | String   |
| template.template_contents_attributes                               | An array of hashes with content details                                                                                                 | `{ name: "Content A", content_attributes: { format: "html", subject: "My Subj", html: "My HTML Content", text: "" } }` | Hash     |
| template.template_contents_attributes[x].content_attributes.html    | HTML content                                                                                                                            | `"<b>content</b>"`                                                                                                     | String   |
| template.template_contents_attributes[x].content_attributes.text    | Text content                                                                                                                            | "content"                                                                                                              | String   |
| template.template_contents_attributes[x].content_attributes.format  | Email format to deliver                                                                                                                 | "html"                                                                                                                 | String   |
| template.template_contents_attributes[x].content_attributes.subject | Email subject to use                                                                                                                    | "Hey there\!"                                                                                                          | String   |
| template.segmentation_criteria_id                                   | The id of a Segmenetation Criteria                                                                                                      | 1                                                                                                                      | Integer  |
| template.dispatch_attributes                                        | Inline object containing delivery settings of the Template; Comes from the server only if delivery settings of the Template are defined | {}                                                                                                                     | Hash     |
| template.dispatch_attributes.state                                  | The state of delivery; Can be one of: "idle", "scheduled", "sending", "finished", "failed", "cancelled"                                 | "failed"                                                                                                               | String   |
| template.dispatch_attributes.state_description                      | Localized textual description of the state                                                                                              | "Step 2: Scheduled"                                                                                                    | String   |
| template.dispatch_attributes.virtual_mta_id                         | The id of a Virtual MTA explicitly assigned to the Template; Will come blank if Template is about to use general setting                | 1                                                                                                                      | Integer  |
| template.dispatch_attributes.virtual_mta_name                       | The name of a Virtual MTA explicitly assigned to the Template                                                                           | "MTA 1"                                                                                                                | String   |
| template.dispatch_attributes.bounce_email_id                        | The id of a Bounce Email explicitly assigned to the Template; Will come blank if Template is about to use general setting               | 1                                                                                                                      | Integer  |
| template.dispatch_attributes.bounce_email_name                      | The Bounce Email explicitly assigned to the Template                                                                                    | "no@reply.com"                                                                                                         | String   |
| template.dispatch_attributes.url_domain_id                          | The id of an URL domain explicitly assigned to the Template                                                                             | 1                                                                                                                      | Integer  |
| template.dispatch_attributes.url_domain_name                        | The URL domain explicitly assigned to the Template                                                                                      | "example.com"                                                                                                          | String   |
| template.dispatch_attributes.seed_list_id                           | The id of a Seed List assigned to the Template                                                                                          | 1                                                                                                                      | Integer  |
| template.dispatch_attributes.seed_list_name                         | The name of the Seed List assigned to the Template                                                                                      | "Seed List 1"                                                                                                          | String   |
| template.dispatch_attributes.speed                                  | Maximum throughput speed; 0 for unlimited throughput                                                                                    | 0                                                                                                                      | Integer  |
| template.dispatch_attributes.track_opens                            | Marks whether the Template will track openings stats                                                                                    | true                                                                                                                   | Boolean  |
| template.dispatch_attributes.track_links                            | Marks whether the Template will track clicks stats                                                                                      | true                                                                                                                   | Boolean  |
| template.dispatch_attributes.paused                                 | Marks whether the Template has been paused                                                                                              | false                                                                                                                  | Boolean  |
| template.dispatch_attributes.from_name                              | Name to use in the "From:" field                                                                                                        | "John Doe"                                                                                                             | String   |
| template.dispatch_attributes.from_email                             | Email to use in the "From:" field                                                                                                       | "john.doe@example.com"                                                                                                 | String   |
| template.dispatch_attributes.reply_to                               | Email to use in the "ReplyTo:" field                                                                                                    | "john.doe@example.com"                                                                                                 | String   |
| template.dispatch_attributes.begins_at                              | Time to start delivery at                                                                                                               | 2013-01-01T00:00:00Z                                                                                                   | DateTime |
| template.dispatch_attributes.started_at                             | Time when delivery actually started                                                                                                     | 2013-01-01T00:00:00Z                                                                                                   | DateTime |
| template.dispatch_attributes.autowinner_enabled                     | The template is configured to use automatic winner selection.                                                                           | true/false                                                                                                             | Boolean  |
| template.dispatch_attributes.autowinner_percentage                  | The percentage that will be sent for the split-test portion of the template. See note (1) below.                                        | "25.0"                                                                                                                 | String   |
| template.dispatch_attributes.autowinner_delay_amount                | The number of units of time that the template will wait before finishing after a split-test.                                            | 25                                                                                                                     | Integer  |
| template.dispatch_attributes.autowinner_delay_unit                  | The unit used in calculating the delay duration.                                                                                        | "minutes", "hours", "days"                                                                                             | String   |
| template.dispatch_attributes.autowinner_metric                      | The metric used to decide the winner. See the "Automatic Winner Selection Metrics" table for more information.                          | "clicks_unique", "opens_unique"                                                                                        | String   |

1. This value is returned as a string to prevent floating-point conversion errors.
   You may send this value as an Integer, Float or String. Posting a value with
   more than 2 decimals will cause a validation error. Be careful because IEEE
   floating point can not exactly represent some decimal values. For example 94.85
   is represented as 94.85000000000001 which will cause a validation error if used
   here. You may want to print to a string using two decimals of precision.

#### Response

A successful response will return the template record using the format
described in the "Get template details" section of the API.

#### Example Request

Note that the JSON response will not be "pretty formatted" as it is below.
