# Support ticket email requirements and testing

Ticket creation, comments, replies, status changes, and other saved ticket changes notify both the creator and the assigned targets. Each recipient receives a separate email. The creator and targets use different editable message bodies.

## Recipient rules

| Assignment | Targets, in addition to the creator |
| --- | --- |
| Committee, no member | Committee email stored in NRIVA |
| Chapter, no member | Chapter email stored in NRIVA |
| Both, no members | Committee email and chapter email |
| Committee with selected member | Selected member's email, replacing the committee email |
| Chapter with selected member | Selected member's email, replacing the chapter email |
| Both with optional members | Resolve each assignment independently using the rules above |

Unselected group members do not receive individual emails. A group must have a valid saved email address to receive group notifications. Duplicate addresses are combined. The configured CC applies to each message; keep `technology@nriva.org` in both templates' CC field.

## Admin templates

In Support Admin, open **Mail Templates**. Two event templates are stored in the existing shared NRIVA `mail_templates` table:

- **Ticket Created**: creator acknowledgment and target assignment message.
- **Ticket Updated**: creator update message and target update message.

Each event has four independent message editors: **creator**, **committee group**, **chapter group**, and **selected member**. Both assignments send the committee and chapter their own respective messages; selecting a member uses the member body instead of that group's body. Target placeholders `{{assignment_type}}` and `{{assignment_name}}` identify the committee, chapter, or individual. `{{changes}}` contains the comment or changed ticket fields. `{{actor_name}}` identifies the person who made the change.

Leave **Mail From** blank to use the sender in `.env`. Leave **Additional Mail To** blank for only the automatic recipients. Any address entered there receives an extra copy for every occurrence of that template.

## Mailtrap Sandbox

SMTP settings belong in this project's `.env`, not in a template or the other NRIVA application's `.env`. Use the sandbox's SMTP credentials and run `php artisan config:clear` after changing them. Never commit credentials.

The configured sandbox captures emails inside Mailtrap, including copies addressed to the Technology CC. Real recipient inboxes do not receive these emails unless forwarding has separately been configured in Mailtrap. This does not prove production inbox delivery.

## Automated regression tests

Run from the support project directory:

```powershell
php tests/manual/mail-routing.php
php tests/manual/ticket-regression.php
```

The first suite verifies routing, distinct creator/committee/chapter/member bodies, template saves, and actual model events. It also checks disabled/deleted templates, missing/duplicate addresses, sender and additional recipients, multiple CCs, HTML escaping, guest creators, comment edits/replies/deletions, no-op saves, SMTP failure handling, admin-only access, invalid template inputs, and protection of unrelated main-site templates. The second suite verifies 33 existing application checks. Both fake outbound email and roll back database changes.

## Explicit live SMTP smoke test

```powershell
php tests/manual/mailtrap-smoke.php --send
```

This command refuses to send unless Mailtrap Sandbox SMTP is configured. It sends sample Both-group creation, individual-member creation, comment, and status messages using the saved templates, verifies SMTP acceptance, To/CC, different body text for each audience, and absence of unresolved audience tags. It does not create tickets or save comments. Sample ticket links do not refer to a real ticket. The command prints a unique reference for finding its messages in Mailtrap.

Sandbox sends are spaced out to avoid the provider's burst limit, so a live test may take several minutes. Additional Mail To recipients increase the number of messages.

## Manual browser test

1. Confirm both templates are Active and Additional Mail To is blank.
2. Log in as a creator and create a ticket with only a committee selected. Expect one creator email and one committee-group email.
3. Repeat for a chapter and for Both. Expect the creator plus the selected group addresses.
4. Create another ticket with a particular member selected. Expect the creator and that member, rather than the group address.
5. Add a comment as the creator. Expect both audiences to receive different messages containing the comment.
6. Add a comment or change status as the assigned member. Expect both audiences to receive different messages containing the change.
7. Refresh the Mailtrap message list after each completed action. Inspect To, CC, subject, ticket ID, and body.
8. Edit either audience's template text and repeat an action to confirm the stored template controls the message.

If messages are missing, inspect `storage/logs/laravel.log` for `Ticket email delivery failed`. An SMTP acceptance confirms the provider accepted a message; check Mailtrap to view the captured message.
