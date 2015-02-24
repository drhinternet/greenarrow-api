## Preview Emails

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**

- [Create a preview email](#create-a-preview-email)
  - [URL](#url)
  - [Request Payload](#request-payload)
  - [Response](#response)
  - [Example Request](#example-request)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

### Create a preview email

Send a campaign or autoresponder preview email.

Preview delivery settings in the `System` configuration must already be set.

#### URL

Send a campaign preview email:

    POST /ga/api/v2/campaigns/:campaign_id/send_preview

Send an autoresponder preview email:
	
    POST /ga/api/v2/autoresponders/:autoresponder_id/send_preview

#### Request Payload

The payload for the request is a JSON document containing the email addresses
of the recipients.

<table>
  <tr>
    <td colspan="2">
      <b>preview</b><br><em>hash</em><br>
      <table>
        <tr>
          <td><b>recipients</b><br><em>array of strings</em></td>
          <td>The email addresses to which to deliver the preview emails</td>
        </tr>
        <tr>
          <td><b>split_emails_by_format</b><br><em>boolean</em></td>
          <td>Enable this to send the text and html portions of the content as separate emails.</td>
        </tr>
      </table>
    </td>
  </tr>
</table>

#### Response

The response will be an empty success response if the preview has been enqueued for delivery.

Failures can result from the following cases:

* The campaign or autoresponder does not have any content configured.
* The recipient list sent contains a string that is not a valid email address.
* The system preview delivery settings have not yet been configured.

#### Example Request

Note that the JSON response will not be "pretty formatted" as it is below.

```
> POST /ga/api/campaigns/2/send_preview HTTP/1.1
> Authorization: Basic MTpmYzA2MzI4MjhjMThjMWIzMDgxYzAzNjI4ZTVlOTdmZjc4M2RiZjkx
> Accept: application/json
> Content-Type: application/json

{
  "preview": {
    "recipients": [
      "user-1@example.com",
      "user-2@example.com"
    ],
    "split_emails_by_format": true
  }
}

< Content-Type: application/json; charset=utf-8
< X-UA-Compatible: IE=Edge
< ETag: "f744395dc73a323ce47b552d60a1c6cb"
< Cache-Control: max-age=0, private, must-revalidate
< Set-Cookie: _session_id=860cad951b67c6e411cb633efa437e76; path=/; HttpOnly
< X-Request-Id: b8247a3feecddf8397380ecd99f1f2ef
< X-Runtime: 0.085857
< Connection: close
< Server: thin 1.5.0 codename Knife

{
  "success": true,
  "data": null,
  "error_code": null,
  "error_message": null
}
```
