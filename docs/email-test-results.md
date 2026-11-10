# Email test results

Tested on 10 November 2026 against the local support application.

| Check | Result |
| --- | --- |
| Email routing, templates, validation, access control, failure handling | 81 passed; 0 failed |
| Existing ticket/application regression suite | 33 passed; 0 failed |
| Live Mailtrap Sandbox SMTP | 9 sample messages accepted |

The automated email checks cover committee/chapter/Both assignments, individual and mixed assignments, distinct creator/committee/chapter/member message bodies for creation and updates, CC, sender, extra recipients, duplicate addresses, missing group email, guest creators, disabled/deleted templates, placeholders and escaping, real status/comment model events, edited/deleted comments and replies, no-op saves, template saving and validation, guest/non-admin restrictions, and rejection of writes to unrelated main-site templates.

An injected SMTP exception verified that a ticket status change remains saved when email transport fails. This expected test exception appears in the Laravel log with the text `INJECTED SMTP FAILURE FOR REGRESSION TEST`.

The existing suite covers creation, assignment settings, ticket editing, attachments, comments/replies, authorization, project settings, and application pages.

## Live SMTP results

Find these messages in Mailtrap under reference `MAILTRAP-VERIFY-20261110-172719`:

| Sample action | Messages accepted |
| --- | --- |
| Both committee and chapter groups, without individual members | 3: committee group, chapter group, creator |
| Committee with individual member | 2: selected member, creator |
| Comment by creator | 2: selected member, creator |
| Status change by assigned member | 2: selected member, creator |

All messages included `technology@nriva.org` in CC. Live checks verified expected recipients, different message bodies, and absence of unresolved audience tags.

The stored data contains exactly two active support template records, each with four distinct audience bodies and no Additional Mail To recipients.

Automated test database writes were rolled back. Live samples did not save tickets or comments. SMTP acceptance and routing were verified; the Mailtrap inbox UI and real production inbox delivery were not tested.
