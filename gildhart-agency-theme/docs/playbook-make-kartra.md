# Playbook Checkout → Make.com → Kartra Runbook

How a successful **£995 Playbook** purchase flows from Stripe into Kartra
via Make.com. This is the one-time-payment sibling of the Agent
subscription flow — the mechanics differ in two important ways, called
out below.

> **TL;DR for the busy version:** Trigger on Stripe
> `payment_intent.succeeded`, filter to
> `metadata.product = the-ai-search-playbook`, then create/update a
> Kartra lead from `metadata.*`. Split `services` on the `|` character.

---

## 1. The flow at a glance

```
Customer pays £995 on /the-playbook/
        │  (Stripe Payment Element, inline)
        ▼
Stripe PaymentIntent → status: succeeded
        │  (Stripe fires webhook)
        ▼
Make.com  ── Watch Stripe Events: payment_intent.succeeded
        │  ── Filter: metadata.product = the-ai-search-playbook
        ▼
Kartra  ── Create / Update Lead  (+ tag, + optional sequence)
```

No webhook listener lives in the WordPress theme. Make.com connects to
Stripe directly via its Stripe app, exactly as it does for the Agent.

---

## 2. ⚠️ Two differences from the Agent flow

| | Agent (subscription) | **Playbook (one-time)** |
|---|---|---|
| Stripe trigger event | `invoice.payment_succeeded` | **`payment_intent.succeeded`** |
| Where the data lives | Invoice + Subscription + Customer | **PaymentIntent + Customer** |

**Do not reuse the Agent's `invoice.payment_succeeded` trigger for the
Playbook** — a one-time PaymentIntent that isn't attached to a
subscription invoice won't reliably fire that event with the data you
need. Use `payment_intent.succeeded`.

You can either:
- **(Recommended) Build a separate Make scenario** for the Playbook, or
- Add a second trigger/route to an existing scenario and branch on the
  event type.

Keeping them separate is cleaner and avoids cross-contaminating the
Agent's Kartra mapping.

---

## 3. Make.com — Module 1: Watch Stripe Events

- **App:** Stripe
- **Module:** *Watch Events*
- **Event type:** `payment_intent.succeeded`
- **Connection:** your Stripe account (use the **test** connection while
  testing — keys starting `sk_test_`; switch to the live connection for
  production).

The module emits the event. The PaymentIntent is at **`data.object`** —
every field below is relative to that.

---

## 4. Data available on the event

All lead fields are mirrored onto the PaymentIntent's `metadata` by the
theme (`gildhart_stripe_create_payment_intent_for_lead()` in
`inc/stripe.php`), and onto the **Customer** record too.

| Make.com path | Example value | Notes |
|---|---|---|
| `data.object.metadata.product` | `the-ai-search-playbook` | **Use this to filter** |
| `data.object.metadata.first_name` | `Drew` | |
| `data.object.metadata.last_name` | `Clayton` | |
| `data.object.metadata.customer_email` | `drew.clayton@pharmodigital.co.uk` | Primary email source |
| `data.object.metadata.practice_name` | `PharmoDigital Test` | |
| `data.object.metadata.website` | `http://www.pharmodigital.co.uk` | |
| `data.object.metadata.services` | `Travel Health & Vaccinations\|HPV Vaccination\|Shingles Vaccination` | **Pipe-separated** — see §6 |
| `data.object.metadata.plan_label` | `The AI Search Playbook — £995 one-time` | Human-readable label |
| `data.object.receipt_email` | `drew.clayton@pharmodigital.co.uk` | Fallback email source |
| `data.object.description` | `The AI Search Playbook` | Product label |
| `data.object.amount` | `99500` | **Pence**, VAT-inclusive. ÷100 = £995 |
| `data.object.currency` | `gbp` | |
| `data.object.id` | `pi_3ABC…` | Stripe PaymentIntent ID (idempotency key) |
| `data.object.customer` | `cus_ABC…` | Stripe Customer ID |

Email: prefer `metadata.customer_email`, fall back to `receipt_email`
if ever blank.

---

## 5. Make.com — Module 2: Filter (critical)

Set a filter **between** the Stripe trigger and the Kartra action so the
scenario only proceeds for Playbook purchases (and ignores any other
PaymentIntents on the account):

```
Condition:  data.object.metadata.product   Equal to   the-ai-search-playbook
```

Without this filter, unrelated PaymentIntents (or the Agent's, if they
ever surface as PI events) would also hit Kartra.

---

## 6. Handling the `services` field

`services` arrives as a **single pipe-separated string**, e.g.:

```
Travel Health & Vaccinations|HPV Vaccination|Shingles Vaccination|Mpox Vaccination|Diabetes Management
```

(Up to 5 entries; "Other — please specify" entries arrive as the
free-text the customer typed.)

Two ways to use it in Kartra — pick based on how you want to segment:

**Option A — store as one field (simplest).**
Map the raw string straight into a Kartra custom field (e.g.
`Selected Services`). Good for display / reference in the lead record.

**Option B — split into tags (best for segmentation).**
1. Add a Make **Text parser → "Split"** (or *Tools → Iterator* with a
   split) on `data.object.metadata.services`, delimiter `|`.
2. Iterate the resulting array.
3. For each value, apply a Kartra **tag** (e.g. `service:HPV Vaccination`)
   or add to the matching list.

If you want both a human-readable record **and** segmentation, do A and
B together (store the string in a field *and* split into tags).

---

## 7. Make.com — Module 3: Kartra (Create / Update Lead)

Use the **Kartra** app in Make (or Kartra's inbound API / lead webhook
if you prefer). Create-or-update the lead keyed on **email**.

**Before mapping:** create the matching **custom fields** in Kartra
(My Account → Custom Fields) so they're available as mapping targets.
Suggested set: `Practice Name`, `Website`, `Selected Services`,
`Product`, `Amount Paid`.

### Field mapping

| Kartra field | Source (Make path) | Transform |
|---|---|---|
| First name | `data.object.metadata.first_name` | — |
| Last name | `data.object.metadata.last_name` | — |
| Email | `data.object.metadata.customer_email` | fallback `receipt_email` |
| Practice Name *(custom)* | `data.object.metadata.practice_name` | — |
| Website *(custom)* | `data.object.metadata.website` | — |
| Selected Services *(custom)* | `data.object.metadata.services` | raw, or split per §6 |
| Product *(custom)* | `data.object.metadata.product` | or `description` |
| Amount Paid *(custom)* | `data.object.amount` | `÷ 100` → `995` (or prefix `£`) |

### Recommended lead actions
- **Tag:** `playbook-customer` (and per-service tags from §6 Option B).
- **Assign to list / sequence:** your Playbook onboarding sequence
  (delivers the knowledge-base download + Cowork access instructions —
  mirrors the thank-you page's "what happens next" timeline).
- **Idempotency:** key the create/update on email so a retried webhook
  doesn't create duplicate leads. Optionally store
  `data.object.id` (the `pi_…`) on the lead to dedupe on the
  PaymentIntent itself.

---

## 8. Amount note (VAT)

`amount` is **99500 pence = £995, VAT-inclusive**. There is no separate
VAT line — the displayed price is the final price (deliberate, to remove
checkout friction). If Kartra needs a gross figure, `99500 ÷ 100 = 995`.

---

## 9. Test → Live checklist

- [ ] Stripe in **test mode**; Make's Stripe connection uses the test key.
- [ ] Run a test purchase on `/the-playbook/` with card `4242 4242 4242 4242`.
- [ ] Confirm the Make scenario triggers on `payment_intent.succeeded`.
- [ ] Confirm the filter passes (`metadata.product = the-ai-search-playbook`).
- [ ] Confirm a Kartra lead is created with all fields + `services` handled.
- [ ] Confirm tags / sequence fire as intended.
- [ ] Switch Make's Stripe connection to the **live** key + flip Stripe
      to live mode for production.

---

## 10. Where the source lives (for future changes)

- PaymentIntent + metadata: `gildhart_stripe_create_payment_intent_for_lead()`
  in `inc/stripe.php`.
- REST endpoint the form posts to: `POST /wp-json/gildhart/v1/playbook-checkout`.
- Front-end: `assets/js/playbook-checkout.js`, form in
  `template-parts/service/section-playbook-checkout.php`.
- If you add or rename a metadata key in `inc/stripe.php`, update the
  Make mapping in §4 + §7 to match.
